<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run()
    {
        // Create 10 patients
        for ($i = 1; $i <= 10; $i++) {
            Patient::create([
                'name' => 'Patient ' . $i,
                'email' => 'patient' . $i . '@example.com',
                'password' => Hash::make('password123'), // Default password
                'phone_number' => '123456789' . $i,
            ]);
        }
    }
}
