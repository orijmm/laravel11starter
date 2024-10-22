<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pages';

    protected $fillable = ['title', 'description', 'slug', 'template_id', 'deleted_at'];

    /**
     * Get the menu_items for the blog post.
     */
    public function menuitems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get the sections for the blog post.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->chaperone();
    }
}
