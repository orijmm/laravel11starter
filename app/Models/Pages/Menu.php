<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menus';

    protected $fillable = ['name', 'description'];

    public function scopeListado($query)
    {
        // Define the listado scope
    }

    public function scopeSearch($query, $term)
    {
        // Define the search scope
    }
}
