<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends User
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->role = self::ROLE_CLIENT;
        });
    }

    public static function create(array $attributes = [])
    {
        $attributes['role'] = self::ROLE_CLIENT;
        return parent::create($attributes);
    }
    public function otp()
    {
        return $this->hasOne(Otp::class, 'user_id');
    }
}
