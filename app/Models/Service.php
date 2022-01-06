<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\BrandEmployee;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'period',
        'price',
        'shifts',
    ];
    protected $casts=[
        'shifts'=>'json'
    ];
    protected function getImageAttribute()
    {
        $file = $this->getMedia("services")->first();
        if ($file) {
            return $this->getMedia("services")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }
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
