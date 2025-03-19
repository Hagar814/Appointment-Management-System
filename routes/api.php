<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController ;
use App\Http\Controllers\DoctorController ;
use App\Http\Controllers\PatientController ;
use App\Http\Controllers\AppointmentController ;
use App\Http\Controllers\Auth\PatientAuthController ;
use App\Http\Controllers\Auth\DoctorAuthController ;
use App\Http\Controllers\Auth\AdminAuthController ;

//patient register and login
Route::controller(PatientAuthController::class)->group(function (){
    Route::post('register','register');
    Route::post('login/patient','login');
});

//doctor login
Route::controller(DoctorAuthController::class)->group(function (){
    Route::post('login/doctor','login');

});

//admin login
Route::controller(AdminAuthController::class)->group(function (){
    Route::post('login/admin','login');

});


//admin
Route::controller(AdminController::class)->group(function (){
    // Admin routes for doctors
    Route::post('/admin/doctor/add', [AdminController::class, 'addDoctor']);
    Route::get('/admin/doctors', [AdminController::class, 'listDoctors']);
    Route::put('/admin/doctor/update/{id}', [AdminController::class, 'updateDoctor']);
    Route::delete('/admin/doctor/delete/{id}', [AdminController::class, 'deleteDoctor']);

    // Admin routes for patients
    Route::get('/admin/patients', [AdminController::class, 'listPatients']);
    Route::put('/admin/patient/update/{id}', [AdminController::class, 'updatePatient']);
    Route::delete('/admin/patient/delete/{id}', [AdminController::class, 'deletePatient']);
    
    // Admin routes for appointments
    Route::get('/admin/appointments', [AdminController::class, 'listAppointments']);
    Route::post('/admin/appointments/{id}/status', [AdminController::class, 'updateAppointmentStatus']);
    Route::delete('/admin/appointment/delete/{id}', [AdminController::class, 'deleteAppointment']);
    
    // Admin routes for appointments
    Route::post('addAdmin','addAdmin');
});

//appointment 
Route::controller(AppointmentController::class)->group(function (){
    //Appointment Creation 
    Route::post('createAppointment','createAppointment');
});
//view Appointments
Route::get('/patient/{id}/appointments', [PatientController::class, 'viewAppointments']);




