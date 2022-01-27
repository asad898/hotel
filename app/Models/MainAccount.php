<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAccount extends Model
{
    use HasFactory;

    public function sub()
    {
        return $this->hasMany(SubAccount::class, 'main_accounts_id');
    }
}
