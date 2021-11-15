<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\BrandEmployee;

class Service extends Model
{
    use HasFactory;
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
    public function brand_owner()
    {
        return $this->belongsTo(BrandOwner::class);
    }
}
