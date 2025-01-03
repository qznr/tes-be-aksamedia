<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '123456789',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('pastibisa'),
            'role' => 'admin'
        ]);
    }
}