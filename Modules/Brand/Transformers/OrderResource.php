<?php

namespace Modules\Brand\Transformers;

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
        return [
            'id' => (int)$this->id,
            'created_by' => $this->created_by??'brand',
            'client' => $this->client_id ? new ClientDTO($this->client) : new Object_(),
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
        ];
    }
}
