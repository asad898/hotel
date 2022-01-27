<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAccount extends Model
{
    use HasFactory;

    public function mainAccount()
    {
        return $this->belongsTo(MainAccount::class);
    }
}
