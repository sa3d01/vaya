<?php

namespace Modules\Brand\Transformers;

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
            'shifts' => $this->shifts,
            'technicals' => BrandEmployeeDTO::collection($this->technicals),
        ];
    }
}
