<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function guest(){
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function partner(){
        return $this->belongsTo(Guest::class, 'partner_id');
    }

    public function details(){
        return $this->hasMany(BillDeta::class);
    }

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function laundry(){
        return $this->hasMany(Laundry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
