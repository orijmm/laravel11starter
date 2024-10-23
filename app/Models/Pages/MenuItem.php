<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu_items';

    protected $fillable = ['label', 'url', 'description', 'order', 'parent_id', 'menu_id', 'page_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
    
    public function parentId(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }

}
