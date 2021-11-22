<?php

namespace Modules\Brand\Transformers;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'description' => $this->description??"",
            'price' => (double)$this->price,
            'period' => (int)$this->period,
            'shifts'=>(array)$this->shifts,
            'technicals' => BrandEmployeeDTO::collection($this->technicals),
            'orders_count'=>Order::where('service_id',$this->id)->count()
        ];
    }
}
