<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    
    
    public function index()
    {
        return response()->json(Doctor::all());
    }

    public function viewAppointments($doctorId)
    {
        $appointments = Appointment::where('doctor_id', $doctorId)->get();
        return response()->json($appointments);
    }

    public function updateAppointmentStatus(Request $request, $appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        $appointment->status = $request->input('status');
        $appointment->save();

        return response()->json($appointment);
    }
}
