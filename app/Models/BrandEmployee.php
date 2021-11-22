<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Service;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BrandEmployee extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected function getAvatarAttribute()
    {
        $file = $this->getMedia("brand_employees")->first();
        if ($file) {
            return $this->getMedia("brand_employees")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, "employee_service", "brand_employee_id", "service_id");
    }
}
