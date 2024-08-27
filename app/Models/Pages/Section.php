<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sections';

    protected $fillable = ['name', 'order', 'background-color', 'text-color', 'page_id'];

    public function scopeListado($query)
    {
        // Define the listado scope
    }

    public function scopeSearch($query, $term)
    {
        // Define the search scope
    }
}
