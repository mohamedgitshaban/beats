<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'ad_page',
        'is_active',
        'ad_duration',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'ad_duration' => 'double',
    ];
}
