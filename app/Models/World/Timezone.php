<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = 'timezones';

    protected $fillable = ['country_id', 'name'];
}
