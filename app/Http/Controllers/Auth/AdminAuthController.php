<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate admin login credentials
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Login Validation Errors', $validator->errors());
        }

        // Attempt to log in the admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $currentAdmin = Auth::guard('admin')->user();
            $token = $currentAdmin->createToken('admin-token')->plainTextToken;

            return ApiResponse::sendResponse(200, 'Admin Logged In Successfully', ['token' => $token]);
        } else {
            return ApiResponse::sendResponse(401, 'Invalid credentials', null);
        }
    }
    // logout:
    public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            
            return ApiResponse::sendResponse(200,'Admin Logged Out Successfully', []);
        
           
    }

}