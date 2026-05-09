<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends User
{
    use SoftDeletes;
    protected $table = 'users';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::ROLE_CLIENT;
        });
    }
    public function otp()
    {
        return $this->hasOne(Otp::class, 'user_id');
    }
}
