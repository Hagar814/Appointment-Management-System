<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController ;
use App\Http\Controllers\DoctorController ;
use App\Http\Controllers\PatientController ;
use App\Http\Controllers\Auth\PatientAuthController ;

// Route::middleware('auth:sanctum')->group(function () {
//     // Protected routes
//     Route::get('/admin', [AdminController::class, 'index']);
//     Route::get('/doctor', [DoctorController::class, 'index']);
//     Route::get('/patient', [PatientController::class, 'index']);
// });

Route::controller(PatientAuthController::class)->group(function (){
    Route::post('register','register');
    Route::post('login/patient','login');
});