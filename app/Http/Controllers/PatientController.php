<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return response()->json(Patient::all());
    }

   

    public function viewAppointments($patientId)
    {
        $appointments = Appointment::where('patient_id', $patientId)->get();
        return response()->json($appointments);
    }
}
