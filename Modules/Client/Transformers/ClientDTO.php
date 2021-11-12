<?php

namespace Modules\Client\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => 'client',
            'name' => $this->name,
            'email' => $this->email ?? "",
            'phone' => $this->phone,
            'avatar' => $this->avatar,
        ];
    }
}
