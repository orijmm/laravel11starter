<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admin_settings';

    protected $fillable = ['name_company', 'description', 'address', 'phone', 'email', 'locale', 'timezone', 'state_id', 'city_id', 'country_id', 'currency_id'];

    public function scopeListado($query)
    {
        // Define the listado scope
    }

    public function scopeSearch($query, $term)
    {
        // Define the search scope
    }
}
