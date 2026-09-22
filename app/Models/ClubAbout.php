<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubAbout extends Model
{
    protected $fillable = [
        'title',
        'tagline',
        'description',
        'mission',
        'vision',
        'established_year',
        'home_ground',
        'contact_email',
        'contact_phone',
    ];
}
