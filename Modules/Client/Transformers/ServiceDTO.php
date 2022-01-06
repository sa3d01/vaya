<?php

namespace Modules\Client\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDTO extends JsonResource
{
    public function toArray($request)
    {
        $days_count=6;
        $data=[];
        for ($i = 0; $i <= $days_count; $i++) {
            $date = Carbon::now()->addDays($i);
            $day=$date->format('l');
            if(array_key_exists($day, $this->shifts)) {
                $arr['day'] = $date->format('Y/m/d');
                $arr['times'] = $this->shifts[$day];
                $data[]=$arr;
            }else{
                if($days_count<30){
                    $days_count++;
                }
            }
        }
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'description' => $this->description ?? "",
            'price' => (double)$this->price,
            'period' => (string)$this->period,
            'shifts'=>$data
        ];
    }
}