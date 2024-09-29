<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory, Searchable;

    protected $table = 'abilities';

    protected $fillable = ['name', 'title', 'entity_id', 'entity_type', 'only_owned', 'options', 'scope'];

}
