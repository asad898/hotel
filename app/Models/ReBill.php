<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReBill extends Model
{
    use HasFactory;

    public function billde()
    {
        return $this->hasMany(BillDe::class, 're_bills_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
