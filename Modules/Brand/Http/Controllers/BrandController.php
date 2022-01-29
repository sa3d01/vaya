<?php

namespace Modules\Brand\Http\Controllers;


use Modules\Brand\Entities\BrandOwner;
use Modules\Brand\Transformers\BrandOwnerDTO;


class BrandController extends MasterController
{
    public function profile($id)
    {
        $brand = BrandOwner::find($id);
        return $this->sendResponse(new BrandOwnerDTO($brand));
    }

}
