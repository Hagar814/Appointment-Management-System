<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create 10 admins
        for ($i = 1; $i <= 10; $i++) {
            Admin::create([
                'name' => 'Admin ' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('password123'), // Default password
            ]);
        }
    }
}
