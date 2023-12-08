<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin123@gmail.com',
            'phone' => '09790361390',
            'gender' => 'male',
            'address' => 'kachin',
            'role' => 'admin',
            'password' => Hash::make('admin12345')
        ]);
    }
}
