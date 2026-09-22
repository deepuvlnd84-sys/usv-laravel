<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'president_name',
        'president_role',
        'president_phone',
        'president_photo',
        'president_email',
        'coordinator_name',
        'coordinator_role',
        'coordinator_phone',
        'coordinator_photo',
        'coordinator_email',
        'facebook_url',
        'instagram_url',
        'youtube_url',
    ];
}
