<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'period',
        'price',
        'shifts',
    ];
    protected $casts=[
        'shifts'=>'array'
    ];
    public function technicals()
    {
        return $this->belongsToMany(BrandEmployee::class, "employee_service", "service_id", "brand_employee_id");
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    protected static function newFactory()
    {
        return \Modules\Brand\Database\factories\ServiceFactory::new();
    }
}
