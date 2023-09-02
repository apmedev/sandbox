<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected $table = 'apis';

    protected $fillable = ['title', 'key', 'base_url', 'action_url', 'frequency', 'custom_handling'];

    public function calls()
    {
        return $this->hasMany(ApiCall::class);
    }
}
