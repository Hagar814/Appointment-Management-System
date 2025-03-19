<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function addDoctor(Request $request)
    {
        // Validate the incoming doctor data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:doctors,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure the password is confirmed
            'specialization' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Doctor Registration Validation Errors', $validator->errors());
        }

        // Create the doctor and hash the password
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashing the password
            'specialization' => $request->specialization,
        ]);

        return ApiResponse::sendResponse(201, 'Doctor Added Successfully', $doctor);
    }

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
