<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sections';

    protected $fillable = ['name', 'order', 'background-color', 'text-color', 'page_id'];

    /**
     * Get the rows for the blog post.
     */
    public function rows(): HasMany
    {
        return $this->hasMany(Row::class);
    }
}
