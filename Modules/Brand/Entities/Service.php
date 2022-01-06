<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
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
        'image'
    ];
    protected $casts=[
        'shifts'=>'json'
    ];
    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    protected function getImageAttribute()
    {
        $file = $this->getMedia("services")->first();
        if ($file) {
            return $this->getMedia("services")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }

    protected function setImageAttribute($image)
    {
        $this->clearMediaCollection("services");
        $fileName = time() . Str::random(10);
        $fileNameWithExt = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $this->addMedia($image)
            ->usingFileName($fileNameWithExt)
            ->usingName($fileName)
            ->toMediaCollection("services");
    }
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
