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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->role = self::ROLE_ADMIN;
        });
    }

    public static function create(array $attributes = [])
    {
        $attributes['role'] = self::ROLE_ADMIN;
        return parent::create($attributes);
    }
}
