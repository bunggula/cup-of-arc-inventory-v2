<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'Cup Of Arc Admin',
        'email' => 'admin@cupofarc.com', // Palitan niyo ito ng email niyo
        'password' => Hash::make('password123'), // Palitan niyo ang password
    ]);
}
}
