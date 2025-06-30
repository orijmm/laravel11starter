<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable = ['country_id', 'name', 'code', 'precision', 'symbol', 'symbol_native', 'symbol_first', 'decimal_mark', 'thousands_separator'];
}
