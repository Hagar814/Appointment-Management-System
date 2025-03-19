<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
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
