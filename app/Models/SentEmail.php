<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'type',
        'ip_address',
        'was_sent',
    ];
}
