<?php

namespace App\Models\Pages;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentType extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'component_types';

    protected $fillable = ['name'];

    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }
}
