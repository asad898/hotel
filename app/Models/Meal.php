<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    public function restbills()
    {
        return $this->hasMany(RestBill::class);
    }

    public function billde()
    {
        return $this->hasOne(BillDe::class, 'meal_id');
    }
}
