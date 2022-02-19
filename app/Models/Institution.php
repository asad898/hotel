<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
    
    public function room()
    {
        return $this->hasOne(Institution::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'institution_id');
    }
}
