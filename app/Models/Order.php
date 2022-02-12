<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'client_name',
        'client_phone',
        'client_address_id',
        'brand_id',
        'brand_employee_id',
        'service_id',
        'promo_code_id',
        'created_by',
        'price',
        'date',
        'time',
        'status',
        'cancelled_at',
        'cancelled_by',
        'cancel_reason'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function client_address()
    {
        return $this->belongsTo(ClientAddress::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function brand_employee()
    {
        return $this->belongsTo(BrandEmployee::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function promo_code()
    {
        return $this->belongsTo(PromoCode::class);
    }
}
