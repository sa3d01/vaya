<?php

namespace Modules\Client\Transformers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatOrderDTO extends JsonResource
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
            'brand' => [
                'id'=>$this->brand_id,
                'name'=> [
                    'ar' => $this->brand->title_ar??"",
                    'en' => $this->brand->title_en??""
                ],
                'image'=>$this->brand->image,
            ],
            'message' => $this->message,
            'sent_by' => $this->sent_by??"client",
            'sent_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
