<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahmed Mohamed',
            'email' => 'ahmed@gmail.com',
            'password' => Hash::make('123456'),
            'phone_number' => '01017455236',
        ]);
        DB::table('users')->insert([
            'name' => 'Omar Ahmed',
            'email' => 'omar@gmail.com',
            'password' => Hash::make('123456'),
            'phone_number' => '01017455235',
        ]);
    }
}
