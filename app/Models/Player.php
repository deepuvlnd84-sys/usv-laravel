<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    // ഈ Column-കളിൽ മാത്രം Data save ചെയ്യാൻ അനുവദിക്കുക
    protected $fillable = ['name', 'jersey_number', 'position', 'photo', 'photo_public_id'];

    /**
     * Get the accessible photo URL or default avatar placeholder
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://') || filter_var($this->photo, FILTER_VALIDATE_URL)) {
                return $this->photo;
            }
            // Check if stored in public/uploads/players or public/storage/players
            if (file_exists(public_path('uploads/players/' . $this->photo))) {
                return asset('uploads/players/' . $this->photo);
            }
            if (file_exists(public_path('storage/' . $this->photo))) {
                return asset('storage/' . $this->photo);
            }
            if (file_exists(public_path($this->photo))) {
                return asset($this->photo);
            }
        }
        return null;
    }

    /**
     * Mutator to allow setting photo via photo_url
     */
    public function setPhotoUrlAttribute($value)
    {
        $this->attributes['photo'] = $value;
    }
}