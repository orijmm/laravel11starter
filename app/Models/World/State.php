<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = ['country_id', 'name', 'country_code'];
}
