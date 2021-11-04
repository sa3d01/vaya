<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BrandSlider extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'banned',
        'slider',
    ];
    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    protected function getSliderAttribute()
    {
        $file = $this->getMedia("brand_sliders")->first();
        if ($file) {
            return $this->getMedia("brand_sliders")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }

    protected function setSliderAttribute($image)
    {
        $this->clearMediaCollection("brand_sliders");
        $fileName = time() . Str::random(10);
        $fileNameWithExt = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $this->addMedia($image)
            ->usingFileName($fileNameWithExt)
            ->usingName($fileName)
            ->toMediaCollection("brand_sliders");
    }

}
