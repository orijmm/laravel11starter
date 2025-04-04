<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes, Filterable, Searchable;

    protected $table = 'testimonials';

    protected $fillable = ['name', 'quote', 'avatar_src', 'img_src', 'img_alt', 'role', 'bg_class'];
}
