<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Patient;
use Illuminate\Validation\Rules;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'email'=>['required','email','max:255','unique:'.Patient::class],
            'password'=>['required','confirmed',Rules\Password::defaults()],
            'phone_number' => 'required|string|max:15', 
            //'captcha' => 'required|captcha',
            
            
        ]);
        if ($validator->fails())
        {
            return ApiResponse::sendResponse(422,'Register Validation Errors', $validator->messages()->all());
        }
        $patient = Patient::create([
                'name'=> $request->name,
                'email'=>$request->email,
                'phone_number' => $request->phone_number, 
                'password' => Hash::make($request->password)
        ]);
    
        // Generate token for the newly registered user
        $token = $patient->createToken('patient-token')->plainTextToken;
    
        return ApiResponse::sendResponse(201,'User Account Created Successfully', $token);
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>['required','email','max:255'],
            'password'=>['required',],
            //'phone_number' => 'required|string|max:15', 
            //'captcha' => 'required|captcha',
            
            
        ]);
        if ($validator->fails())
        {
            return ApiResponse::sendResponse(422,'Login Validation Errors', $validator->errors());
        }
        if (Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $currentUser = Auth::guard('patient')->user();
            $token = $currentUser->createToken('patient')->plainTextToken;
            return ApiResponse::sendResponse(200, 'Patient Logged In Successfully', ['token' => $token]);
        
        } else {
            // Return invalid credentials message
            return ApiResponse::sendResponse(401, 'Invalid credentials', null);
        }
    }
//     public function bookAppointmentAsGuest(Request $request)
// {
//     $validated = $request->validate([
//         'doctor_id' => 'required|exists:doctors,id',
//         'email' => 'required|email', // Email validation for guest
//         'appointment_time' => 'required|date_format:Y-m-d H:i:s|after:now',
//     ]);

//     // Check if the email is associated with a registered patient
//     $patient = Patient::where('email', $validated['email'])->first();

//     if (!$patient) {
//         // Create a new patient entry as a guest (no password needed)
//         $patient = Patient::create([
//             'name' => 'Guest',
//             'email' => $validated['email'],
//             'password' => bcrypt(Str::random(8)), // You can generate a random password for the guest
//         ]);
//     }

//     // Create appointment for guest
//     $appointment = Appointment::create([
//         'doctor_id' => $validated['doctor_id'],
//         'patient_id' => $patient->id,
//         'appointment_time' => $validated['appointment_time'],
//     ]);

//     return response()->json($appointment, 201);
// }

}