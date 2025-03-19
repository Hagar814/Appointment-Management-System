<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function manageDoctors()
    {
        return response()->json(Doctor::all());
    }

    public function managePatients()
    {
        return response()->json(Patient::all());
    }

    public function manageAppointments()
    {
        return response()->json(Appointment::all());
    }
}
