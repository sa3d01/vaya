<?php

namespace Modules\Brand\Transformers;

use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Client\Transformers\BrandDTO;
use Modules\Client\Transformers\ServiceDTO;
use phpDocumentor\Reflection\Types\Object_;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $rate=Rate::where('order_id',$this->id)->where('brand_employee_id',null)->latest()->first();
        if ($rate){
            $rate_res=[
                'rate'=>(int)$rate->rate,
                'comment'=>$rate->comment??""
            ];
        }else{
            $rate_res=new Object_();
        }
        return [
            'id' => (int)$this->id,
            'created_by' => $this->created_by??'client',
            'client' => $this->client_id ? new ClientDTO($this->client) : new Object_(),
            'client_address' => $this->client_address ? new ClientAddressDTO($this->client_address) : new Object_(),
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'brand_employee' => $this->brand_employee ? new BrandEmployeeDTO($this->brand_employee) : new Object_(),
            'service' => new ServiceDTO($this->service),
            'price' => (int)$this->price,
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'time' => $this->time,
            'brand' => $this->brand_id ? new BrandDTO($this->brand) : new Object_(),
            'brand_name' => [
                'ar' => $this->brand->title_ar??"",
                'en' => $this->brand->title_en??""
            ],
            'status'=>$this->status,
            'rate' => $rate_res,
        ];
    }
}
