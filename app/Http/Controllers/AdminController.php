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
//Add Admin
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

    // Retrieve all appointments
    public function listAppointments()
    {
        $appointments = Appointment::all();
        return ApiResponse::sendResponse(200, 'Appointments Retrieved Successfully', $appointments);
    }
    // Update appointment status
    public function updateAppointmentStatus(Request $request, $id)
    {
        // Validate the status input
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:confirmed,canceled'], // Only allow 'confirmed' or 'canceled'
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Status Update Validation Errors', $validator->errors());
        }
    }
    // Delete an appointment
    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return ApiResponse::sendResponse(200, 'Appointment Deleted Successfully', null);
    }
    // Retrieve all patients
    public function listPatients()
    {
        $patients = Patient::all();
        return ApiResponse::sendResponse(200, 'Patients Retrieved Successfully', $patients);
    }

    // Update patient details
    public function updatePatient(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:patients,email,'.$patient->id],
            'phone_number' => ['required', 'string', 'max:15'],
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Patient Update Validation Errors', $validator->errors());
        }

        $patient->update($request->all());

        return ApiResponse::sendResponse(200, 'Patient Updated Successfully', $patient);
    }

    // Delete a patient
    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return ApiResponse::sendResponse(200, 'Patient Deleted Successfully', null);
    }
}
