<?php

namespace Modules\Client\Transformers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'client' => [
                'id'=>$this->client_id,
                'name'=>$this->client->name,
                'image'=>$this->client->avatar,
            ],
            'admin' => [
                'id'=>$this->admin_id,
                'name'=>$this->admin->name,
                'image'=>$this->admin->avatar,
            ],
            'message' => $this->message,
            'sent_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
