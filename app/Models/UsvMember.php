<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsvMember extends Model
{
    use HasFactory;

    // Direct mapping to official club members table in USV database
    protected $table = 'usv_members';

    protected $primaryKey = 'sl_no';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'sl_no',
        'member_id',
        'name',
        'call_name',
    ];
}
