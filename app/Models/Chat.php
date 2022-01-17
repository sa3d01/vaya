<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Admin;

class Chat extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'admin_id',
        'brand_id',
        'order_id',
        'message',
        'read',
        'sent_by'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function brand()
    {
        return $this->belongsTo(BrandOwner::class,'brand_id','id');
    }
}
