<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'client_id',
        'brand_employee_id',
        'rate',
        'comment',
    ];
}
