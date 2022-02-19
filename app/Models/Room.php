<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'rooms';

    public function guest(){
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function partner(){
        return $this->belongsTo(Guest::class, 'partner_id');
    }

    public function roomprice()
    {
        return $this->belongsTo(RoomPrice:: class, 'roomprice_id');
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public function details()
    {
        return $this->hasMany(BillDeta::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution:: class, 'institution_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

}
