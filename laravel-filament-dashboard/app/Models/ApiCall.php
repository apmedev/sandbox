<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCall extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'api_id'];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }
}
