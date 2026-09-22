<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrollingMessage extends Model
{
    protected $fillable = [
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
