<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeFixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_no',
        'stage',
        'team1',
        'team1_short',
        'team1_score',
        'team2',
        'team2_short',
        'team2_score',
        'match_date',
        'match_time',
        'venue',
        'status',
        'result',
        'order_position',
    ];
}
