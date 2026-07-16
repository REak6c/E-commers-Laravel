<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates the default customer account if it does not already exist.
     * Credentials: tharyvireak@gmail.com / reak123
     */
    public function run(): void
    {
        Customer::firstOrCreate(
            ['email' => 'tharyvireak@gmail.com'],
            [
                'name'     => 'Thary Vireak',
                'password' => Hash::make('reak123'),
                'status'   => 1,
            ]
        );
    }
}
