<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        // Fetch all doctors and patients from the database
        $doctors = Doctor::all();
        $patients = Patient::all();

        // Generate 10 appointments
        for ($i = 1; $i <= 10; $i++) {
            // Get a random doctor and patient
            $doctor = $doctors->random();
            $patient = $patients->random();

            // Generate a random appointment time (every hour)
            $appointmentTime = Carbon::now()->addDays(rand(0, 5))->setHour(rand(9, 17))->startOfHour();

            // Create the appointment
            Appointment::create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'appointment_time' => $appointmentTime,
                'status' => 'pending', // You can set this to 'confirmed' or 'pending'
            ]);
        }
    }
}
