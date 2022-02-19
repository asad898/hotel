<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreDeta extends Model
{
    use HasFactory, SoftDeletes;
    
    public function storeBill()
    {
        return $this->hasOne(StoreBill::class)->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
