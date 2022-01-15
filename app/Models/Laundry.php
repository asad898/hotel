<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laundry extends Model
{
    use HasFactory;
    public function clothe()
    {
        return $this->belongsTo(Clothe::class, 'clothe_id');
    }

    public function bill(){
        return $this->belongsTo(Bill::class);
    }
}
