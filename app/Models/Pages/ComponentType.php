<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'component_types';

    protected $fillable = ['name', 'deleted_at'];
}
