<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class DoctorAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required'],
            //'captcha' => 'required|captcha', 
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Login Validation Errors', $validator->errors());
        }

        if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $currentDoctor = Auth::guard('doctor')->user();
            $token = $currentDoctor->createToken('doctor-token')->plainTextToken;

            return ApiResponse::sendResponse(200, 'Doctor Logged In Successfully', ['token' => $token]);
        } else {
            return ApiResponse::sendResponse(401, 'Invalid credentials', null);
        }
        
    }
    public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            
            return ApiResponse::sendResponse(200,'Admin Logged Out Successfully', []);
        
           
    }
}
