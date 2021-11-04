<?php

namespace Modules\Brand\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandOwnerDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => 'brand_owner',
            'name' => $this->name,
            'email' => $this->email ?? "",
            'phone' => $this->phone,
            'avatar' => $this->avatar,
        ];
    }
}
