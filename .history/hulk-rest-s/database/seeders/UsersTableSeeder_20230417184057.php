<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'password' => bcrypt('password123'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => bcrypt('password456'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
