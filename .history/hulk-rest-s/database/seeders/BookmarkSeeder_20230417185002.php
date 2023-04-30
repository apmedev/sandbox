<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Movie;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get all users and movies
       $users = User::all();
       $movies = Movie::all();

       // Generate 20 random bookmarks
       foreach (range(1, 20) as $i) {
           $user = $users->random();
           $movie = $movies->random();

           $user->movies()->attach($movie);
       }
    }
}
