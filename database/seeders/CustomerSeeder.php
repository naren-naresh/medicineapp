<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([
            ['first_name' => 'Vicky', 'email' => 'vicky123@gmail.com', 'phone_number' => '8556544136', 'gender' => 'Male', 'dob' => '2004-03-01', 'password' => Hash::make('12345678'), 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Ajith', 'email' => 'ajith@gmail.com', 'phone_number' => '6566646136', 'gender' => 'Male', 'dob' => '2000-06-13', 'password' => Hash::make('123456'), 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Vijay', 'email' => 'vijay123@gmail.com', 'phone_number' => '7346044136', 'gender' => 'Male', 'dob' => '2006-07-07', 'password' => Hash::make('123456'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
