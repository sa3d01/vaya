<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasApiTokens;
    use Notifiable;

    protected $guard = 'client';

    protected $fillable = [
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
    protected $hidden = [
        'remember_token',
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
        $file = $this->getMedia("clients")->first();
        if ($file) {
            return $this->getMedia("clients")->first()->getFullUrl('thumb');
        }
        return asset('images/users/user.jpg');
    }

    protected function setAvatarAttribute($image)
    {
        $this->clearMediaCollection("clients");
        $fileName = time() . Str::random(10);
        $fileNameWithExt = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $this->addMedia($image)
            ->usingFileName($fileNameWithExt)
            ->usingName($fileName)
            ->toMediaCollection("clients");
    }

}
