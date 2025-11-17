<?php

namespace App\Models\Shop;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Searchable, Filterable;

    protected $table = 'categories';

    protected $fillable = ['parent_id', 'name', 'slug', 'type', 'description', 'position', 'is_active'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
