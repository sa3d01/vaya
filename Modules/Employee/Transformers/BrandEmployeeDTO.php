<?php

namespace Modules\Employee\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandEmployeeDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => 'brand_employee',
            'name' => $this->name,
            'email' => $this->email ?? "",
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'brand_id'=>$this->brand_id
        ];
    }
}
