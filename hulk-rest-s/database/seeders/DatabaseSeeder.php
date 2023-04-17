<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MovieSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\BookmarkeSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MovieSeeder::class,
            UsersTableSeeder::class,
            BookmarkSeeder::class,
        ]);
    }
}
