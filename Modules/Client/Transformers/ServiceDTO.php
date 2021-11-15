<?php

namespace Modules\Client\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'description' => $this->description ?? "",
            'price' => (double)$this->price,
            'period' => (int)$this->period,
            'shifts'=>(array)$this->shifts
        ];
    }
}
