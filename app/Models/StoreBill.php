<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreBill extends Model
{
    use HasFactory, SoftDeletes;
    
    public function storeDetas()
    {
        return $this->hasMany(StoreDeta::class, 'bill_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
