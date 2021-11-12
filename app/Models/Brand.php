<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected function getImageAttribute()
    {
        $file = $this->getMedia("brands")->first();
        if ($file) {
            return $this->getMedia("brands")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
