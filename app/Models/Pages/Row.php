<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Row extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rows';

    protected $fillable = ['order', 'section_id'];

    /**
     * Get the columns for the blog post.
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }
}
