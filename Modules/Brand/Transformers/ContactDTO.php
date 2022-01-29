<?php

namespace Modules\Brand\Transformers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'brand' => [
                'id'=>$this->brand->brand_owner_id,
                'name'=>$this->brand->brand_owner->name,
                'image'=>$this->brand->brand_owner->avatar,
            ],
            'admin' => [
                'id'=>$this->admin_id,
                'name'=>$this->admin->name,
                'image'=>$this->admin->avatar,
            ],
            'message' => $this->message,
            'sent_by' => $this->sent_by??"admin",
            'sent_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
