<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = ['name', 'order', 'classes', 'page_id', 'active'];

    /**
     * Get the rows for the blog post.
     */
    public function rows(): HasMany
    {
        return $this->hasMany(Row::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
