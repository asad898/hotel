<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    public function dAccount()
    {
        return $this->belongsTo(SubAccount::class, 'debit');
    }

    public function cAccount()
    {
        return $this->belongsTo(SubAccount::class, 'credit');
    }
}
