<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = ['iso2', 'name', 'status', 'phone_code', 'iso3', 'region', 'subregion'];
}
