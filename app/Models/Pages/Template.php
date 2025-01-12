<?php

namespace App\Models\Pages;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes, Filterable, Searchable;

    protected $table = 'templates';

    protected $fillable = ['name', 'filename', 'description'];
}
