<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends User
{
    use HasFactory, SoftDeletes;
    

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::ROLE_ADMIN;
        });
    }

    public function otp()
    {
        return $this->hasOne(Otp::class, 'user_id');
    }
}
