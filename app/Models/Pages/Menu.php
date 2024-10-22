<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menus';

    protected $fillable = ['name', 'description', 'deleted_at'];

    /**
     * Get the menu_items for the blog post.
     */
    public function menuitems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->chaperone();
    }
}
