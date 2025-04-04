<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, Filterable, Searchable;

    protected $table = 'projects';

    protected $fillable = ['img_src', 'img_alt', 'link', 'category', 'title', 'description'];
}
