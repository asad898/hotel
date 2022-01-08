<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillDeta extends Model
{
    use HasFactory, SoftDeletes;
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
