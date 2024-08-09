<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'filename',
        'extension',
        'file_path',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
