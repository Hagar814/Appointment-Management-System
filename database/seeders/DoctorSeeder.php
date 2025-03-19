<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        // Create 10 doctors
        for ($i = 1; $i <= 10; $i++) {
            Doctor::create([
                'name' => 'Doctor ' . $i,
                'email' => 'doctor' . $i . '@example.com',
                'password' => Hash::make('password123'), // Default password
                'specialization' => 'Specialization ' . $i,
            ]);
        }
    }
}
