<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $table = 'contact_persons';

    protected $fillable = [
        'name',
        'designation',
        'phone',
        'photo',
        'photo_public_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get accessible photo URL
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }
        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://') || str_starts_with($this->photo, '//') || filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        if (file_exists(public_path('uploads/contacts/' . $this->photo))) {
            return asset('uploads/contacts/' . $this->photo);
        }
        if (file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        return null;
    }
}
