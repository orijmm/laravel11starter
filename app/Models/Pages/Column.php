<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'columns';

    protected $fillable = ['width', 'order', 'row_id'];

    /**
     * Get the components for the blog post.
     */
    public function components(): HasMany
    {
        return $this->hasMany(Row::class);
    }
}
