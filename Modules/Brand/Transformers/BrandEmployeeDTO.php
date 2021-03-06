<?php

namespace Modules\Brand\Transformers;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandEmployeeDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => $this->type,
            'name' => $this->name,
            'email' => $this->email ?? "",
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'orders_count'=>Order::where('brand_employee_id',$this->id)->count()
        ];
    }
}
