<?php

namespace Modules\Client\Http\Controllers;

use App\Models\Brand;
use Modules\Client\Transformers\BrandDTO;
use Modules\Client\Transformers\ServiceDTO;

class BrandController extends MasterController
{
    public function index()
    {
        $brands = Brand::whereBanned(false)->get();
        return $this->sendResponse(BrandDTO::collection($brands));
    }
    public function brandServices($id)
    {
        $brand = Brand::find($id);
        return $this->sendResponse(ServiceDTO::collection($brand->services));
    }


}
