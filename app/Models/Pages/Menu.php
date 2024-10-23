<?php

namespace App\Models\Pages;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, Searchable;

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
