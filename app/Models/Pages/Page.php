<?php

namespace App\Models\Pages;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes, Filterable, Searchable;

    protected $table = 'pages';

    protected $fillable = ['title', 'description', 'slug', 'template_id'];

    /**
     * Get the template for the blog post.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the sections for the blog post.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
