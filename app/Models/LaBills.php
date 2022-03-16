<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaBills extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function billde()
    {
        return $this->hasMany(LaDeta::class, 'la_bill_id');
    }
}
