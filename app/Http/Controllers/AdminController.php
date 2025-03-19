<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Create a new doctor
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
// Retrieve all doctors
public function listDoctors()
{
    $doctors = Doctor::all();
    return ApiResponse::sendResponse(200, 'Doctors Retrieved Successfully', $doctors);
}

// Update doctor details
public function updateDoctor(Request $request, $id)
{
    $doctor = Doctor::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:doctors,email,'.$doctor->id],
        'specialization' => ['required', 'string', 'max:255'],
    ]);

    if ($validator->fails()) {
        return ApiResponse::sendResponse(422, 'Doctor Update Validation Errors', $validator->errors());
    }

    $doctor->update($request->all());

    return ApiResponse::sendResponse(200, 'Doctor Updated Successfully', $doctor);
}

// Delete a doctor
public function deleteDoctor($id)
{
    $doctor = Doctor::findOrFail($id);
    $doctor->delete();

    return ApiResponse::sendResponse(200, 'Doctor Deleted Successfully', null);
}

    public function addAdmin(Request $request)
    {
        // Validate the admin data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure password is confirmed
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Admin Validation Errors', $validator->errors());
        }

        // Create a new admin and hash the password
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashing the password
        ]);

        return ApiResponse::sendResponse(201, 'Admin Created Successfully', $admin);
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
