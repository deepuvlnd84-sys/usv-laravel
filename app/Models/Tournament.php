<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'edition',
        'venue',
        'start_date',
        'description',
        'status',
        'trophy_image',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];
}
