<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    protected $table = 'columns';

    protected $fillable = ['width', 'order', 'row_id'];

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }
}
