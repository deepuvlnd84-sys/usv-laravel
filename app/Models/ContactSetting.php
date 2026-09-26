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
        'club_email',
        'club_phone',
        'ground_location',
        'ground_map_url',
    ];

    /**
     * Get accessible President Photo URL
     */
    public function getPresidentPhotoUrlAttribute(): ?string
    {
        if (!$this->president_photo) {
            return null;
        }
        if (str_starts_with($this->president_photo, 'http://') || str_starts_with($this->president_photo, 'https://') || str_starts_with($this->president_photo, '//') || filter_var($this->president_photo, FILTER_VALIDATE_URL)) {
            return $this->president_photo;
        }
        if (file_exists(public_path('uploads/contacts/' . $this->president_photo))) {
            return asset('uploads/contacts/' . $this->president_photo);
        }
        if (file_exists(public_path($this->president_photo))) {
            return asset($this->president_photo);
        }
        return null;
    }

    /**
     * Get accessible Coordinator Photo URL
     */
    public function getCoordinatorPhotoUrlAttribute(): ?string
    {
        if (!$this->coordinator_photo) {
            return null;
        }
        if (str_starts_with($this->coordinator_photo, 'http://') || str_starts_with($this->coordinator_photo, 'https://') || str_starts_with($this->coordinator_photo, '//') || filter_var($this->coordinator_photo, FILTER_VALIDATE_URL)) {
            return $this->coordinator_photo;
        }
        if (file_exists(public_path('uploads/contacts/' . $this->coordinator_photo))) {
            return asset('uploads/contacts/' . $this->coordinator_photo);
        }
        if (file_exists(public_path($this->coordinator_photo))) {
            return asset($this->coordinator_photo);
        }
        return null;
    }
}
