<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhoneVerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_owner_id',
        'brand_employee_id',
        'client_id',
        'phone',
        'activation_code',
        'expires_at',
        'verified_at',
    ];

}
