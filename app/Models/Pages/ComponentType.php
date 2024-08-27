<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'component_types';

    protected $fillable = ['name'];

    public function scopeListado($query)
    {
        // Define the listado scope
    }

    public function scopeSearch($query, $term)
    {
        // Define the search scope
    }
}
