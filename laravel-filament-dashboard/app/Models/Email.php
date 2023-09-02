<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = ['email_source', 'email_type', 'email_topic', 'mailbox_id'];

    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
    }
}
