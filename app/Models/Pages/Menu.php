<?php

namespace App\Models\Pages;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, Filterable, Searchable;

    protected $table = 'menus';

    protected $fillable = ['name', 'description'];

    /**
     * Get the menu_items for the blog post.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
