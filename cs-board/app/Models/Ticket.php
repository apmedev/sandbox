<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatus;
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'creator_id', 'agent_id', 'status'];

    protected $enumCasts = [
        'status' => TicketStatus::class,
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function getCreatorEmailAttribute()
    {
        if ($this->relationLoaded('creator')) {
            return $this->creator->email;
        }

        return optional($this->creator)->email;
    }

    public function getAgentEmailAttribute()
    {
        if ($this->relationLoaded('agent')) {
            return $this->agent->email;
        }

        return optional($this->agent)->email;
    }
}
