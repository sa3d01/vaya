<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'start_date',
        'end_date',
        'type',
        'value',
        'banned',
    ];
    protected $casts = [
        'start_contract' => 'date',
        'end_contract' => 'date',
    ];
    public function getStartDateAttribute(){
        return Carbon::parse($this->attributes['start_date'])->format('Y/m/d');
    }
    public function getEndDateAttribute(){
        return Carbon::parse($this->attributes['end_date'])->format('Y/m/d');
    }
}
