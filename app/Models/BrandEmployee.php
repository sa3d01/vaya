<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Modules\Brand\Entities\Service;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BrandEmployee extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasApiTokens;

    protected $guard = 'employee';

    protected $fillable = [
        'brand_id',
        'type',
        'name',
        'phone',
        'phone_verified_at',
        'email',
        'avatar',
        'os_type',
        'fcm_token',
        'last_session_id',
        'last_login_at',
        'banned',
        'last_ip'
    ];

    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    protected function getAvatarAttribute()
    {
        $file = $this->getMedia("brand_employees")->first();
        if ($file) {
            return $this->getMedia("brand_employees")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }

    protected function setAvatarAttribute($image)
    {
        $this->clearMediaCollection("brand_employees");
        $fileName = time() . Str::random(10);
        $fileNameWithExt = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $this->addMedia($image)
            ->usingFileName($fileNameWithExt)
            ->usingName($fileName)
            ->toMediaCollection("brand_employees");
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, "employee_service", "brand_employee_id", "service_id");
    }
}
