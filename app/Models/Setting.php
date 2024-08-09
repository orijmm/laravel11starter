<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'or_setting';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_company',
        'description',
        'address',
        'phone',
        'email',
        'locale',
        'timezone',
        'state_id',
        'city_id',
        'country_id',
        'currency_id'
    ];
}
