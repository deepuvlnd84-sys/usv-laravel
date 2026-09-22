<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsvPlayers extends Model
{
    use HasFactory;

    // Official club members table in USV database (usv&table=usv_members)
    protected $table = 'usv_members';

    protected $primaryKey = 'sl_no';

    public $timestamps = false;

    protected $fillable = ['sl_no', 'member_id', 'name', 'call_name'];
}
