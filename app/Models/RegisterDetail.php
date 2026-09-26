<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterDetail extends Model
{
    use HasFactory;

    protected $table = 'register_details';

    protected $fillable = [
        'photo',
        'name',
        'mobile_no',
        'address',
        'age',
        'dob',
        'blood_group',
        'education_qualification',
        'job',
        'remarks',
        'playing_role',
        'batting_style',
        'bowling_arm',
        'bowling_pace',
        'wicket_keeping_style',
        'batting_position',
        'jersey_number',
        'previous_clubs',
        'cricket_experience',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'dob' => 'date',
        'age' => 'integer',
    ];

    /**
     * Get accessible photo URL or default placeholder
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://') || filter_var($this->photo, FILTER_VALIDATE_URL)) {
                return $this->photo;
            }
            if (file_exists(public_path('uploads/registrations/' . $this->photo))) {
                return asset('uploads/registrations/' . $this->photo);
            }
            if (file_exists(public_path($this->photo))) {
                return asset($this->photo);
            }
        }
        return null;
    }
}
