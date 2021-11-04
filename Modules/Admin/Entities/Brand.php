<?php

namespace Modules\Admin\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'brand_owner_id',
        'location_id',
        'title_ar',
        'title_en',
        'commercial_name',
        'commercial_num',
        'start_contract',
        'end_contract',
        'mobile',
        'phone',
        'website',
        'insta',
        'twitter',
        'snap',
        'image',
        'banned',
    ];

    protected $casts = [
        'start_contract' => 'date',
        'end_contract' => 'date',
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
        $file = $this->getMedia("brands")->first();
        if ($file) {
            return $this->getMedia("brands")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }

    protected function setImageAttribute($image)
    {
        $this->clearMediaCollection("brands");
        $fileName = time() . Str::random(10);
        $fileNameWithExt = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $this->addMedia($image)
            ->usingFileName($fileNameWithExt)
            ->usingName($fileName)
            ->toMediaCollection("brands");
    }

    public function getStartContractAttribute(){
        return Carbon::parse($this->attributes['start_contract'])->format('Y/m/d');
    }
    public function getEndContractAttribute(){
        return Carbon::parse($this->attributes['end_contract'])->format('Y/m/d');
    }
    public function owner()
    {
        return $this->belongsTo(BrandOwner::class,'brand_owner_id','id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
