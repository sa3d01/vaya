<?php

namespace Modules\Brand\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => (int)$this->id,
            'title' => [
                'ar' => $this->title_ar,
                'en' => $this->title_en
            ],
            'description' => [
                'ar' => $this->description_ar,
                'en' => $this->description_en
            ],
            'slider' => $this->slider,
        ];
    }
}
