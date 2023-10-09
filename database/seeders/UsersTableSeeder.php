<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'takaki55730317@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 1,
            ],
            [
                'name' => 'Manager',
                'email' => 'takaproject777@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 5,
            ],
            [
                'name' => 'User',
                'email' => 'cheap_trick_magic@yahoo.co.jp',
                'password' => Hash::make('password123'),
                'role' => 9,
            ]
        ]);
    }
}
