<?php

namespace Modules\Client\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'brand_owner'=>$this->brand_owner->name,
            'title' => [
                'ar' => $this->title_ar??"",
                'en' => $this->title_en??""
            ],
            'description' => [
                'ar' => $this->description_ar??"",
                'en' => $this->description_en??""
            ],
            'image' => $this->image,
        ];
    }
}
