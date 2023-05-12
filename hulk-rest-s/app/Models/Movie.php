<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'genre', 'runtime', 'released', 'year', 'director', 'imdbRating', 'poster'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }
}
