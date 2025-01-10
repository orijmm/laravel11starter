<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Column extends Model
{
    use HasFactory;

    protected $table = 'columns';

    protected $fillable = ['width', 'order', 'row_id'];

    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function row(): BelongsTo
    {
        return $this->belongsTo(Row::class, 'row_id');
    }
}
