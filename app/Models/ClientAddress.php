<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'client_id',
        'name',
        'phone',
        'address',
        'flat_num',
        'floor_num',
    ];
    protected $casts=[
        'address'=>'json'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
