<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function createAppointment(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_time' => ['required', 'date_format:Y-m-d H:i:s', 'after:now'],
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Appointment Validation Errors', $validator->errors());
        }

        // Extract the time slot from the appointment time (hourly basis)
        $appointmentTime = Carbon::parse($request->appointment_time)->startOfHour();

        // Check if an appointment already exists for this time slot with the same patient or admin
        $existingAppointment = Appointment::where('appointment_time', $appointmentTime)
            ->where(function($query) {
                // Allow only one appointment per time slot for the same patient or admin
                $query->where('patient_id', Auth::id())
                      ->orWhere('admin_id', Auth::id());
            })
            ->exists();

        if ($existingAppointment) {
            return ApiResponse::sendResponse(409, 'You already have an appointment for this time slot', null);
        }

        // Create the new appointment
        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => Auth::id(), 
            'appointment_time' => $appointmentTime,
            'status' => 'pending', 
        ]);

        return ApiResponse::sendResponse(201, 'Appointment Created Successfully', $appointment);
    }
    public function book(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s|after:now',
        ]);

        // Check if time slot is available
        $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_time', $validated['appointment_time'])
            ->first();

        if ($existingAppointment) {
            return response()->json(['message' => 'Time slot already booked.'], 422);
        }

        // Create the appointment
        $appointment = Appointment::create($validated);

        return response()->json($appointment, 201);
    }
}
