<?php

namespace Modules\Brand\Http\Controllers;


use Modules\Admin\Entities\BrandSlider;
use Modules\Brand\Transformers\SliderResource;


class SliderController extends MasterController
{
    public function index()
    {
        $sliders = BrandSlider::whereBanned(false)->get();
        return $this->sendResponse(SliderResource::collection($sliders));
    }


}
