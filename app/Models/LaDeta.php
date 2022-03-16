<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaDeta extends Model
{
    use HasFactory;

    public function clothe()
    {
        return $this->belongsTo(Clothe::class, 'clothe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
