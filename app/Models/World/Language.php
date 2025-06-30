<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = ['code', 'name', 'name_native', 'dir'];
}
