<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'polygon',
        'banned',
    ];
}
