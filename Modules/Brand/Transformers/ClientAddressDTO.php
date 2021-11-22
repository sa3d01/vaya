<?php

namespace Modules\Brand\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientAddressDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => $this->type,
            'name' => $this->name ?? "",
            'phone' => $this->phone,
            'address' => $this->address,
            'flat_num' => $this->flat_num ?? "",
            'floor_num' => $this->floor_num ?? "",
        ];
    }
}
