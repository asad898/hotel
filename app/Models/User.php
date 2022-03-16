<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'tel',
        'role',
        'password',5
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user){
            $user->profile()->create([
                'user_id' => $user->id
            ]);
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }

    public function storeBills()
    {
        return $this->hasMany(StoreBill::class, 'user_id');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'user_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    
    public function bonds()
    {
        return $this->hasMany(Bond::class, 'user_id');
    }
}
