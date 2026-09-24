<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'System Admin',
                'qalam_id' => null,
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Donor
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'donor@gmail.com',
            ],
            [
                'name' => 'Test Donor',
                'qalam_id' => null,
                'password' => Hash::make('12345678'),
                'role' => 'donor',
                'email_verified_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Beneficiary
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'beneficiary@gmail.com',
            ],
            [
                'name' => 'Test Beneficiary',
                'qalam_id' => '123456',
                'password' => Hash::make('12345678'),
                'role' => 'beneficiary',
                'email_verified_at' => now(),
            ]
        );
    }
}