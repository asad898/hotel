<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->hasOne(Room::class, 'guest_id');
    }

    public function roomPartner()
    {
        return $this->hasOne(Room::class, 'partner_id');
    }
    
}
