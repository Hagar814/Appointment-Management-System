<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController ;
use App\Http\Controllers\DoctorController ;
use App\Http\Controllers\PatientController ;
use App\Http\Controllers\Auth\PatientAuthController ;
use App\Http\Controllers\Auth\DoctorAuthController ;

// Route::middleware('auth:sanctum')->group(function () {
//     // Protected routes
//     Route::get('/admin', [AdminController::class, 'index']);
//     Route::get('/doctor', [DoctorController::class, 'index']);
//     Route::get('/patient', [PatientController::class, 'index']);
// });
//patient register and login
Route::controller(PatientAuthController::class)->group(function (){
    Route::post('register','register');
    Route::post('login/patient','login');
});

//doctor login
Route::controller(DoctorAuthController::class)->group(function (){
    Route::post('login/doctor','login');

});

//admin
Route::controller(AdminController::class)->group(function (){
    Route::post('addDoctor','addDoctor');
});


