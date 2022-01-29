<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $fillable=[
        'ratio',
        'about_ar',
        'about_en',
        'policy_ar',
        'policy_en',
    ];
}
