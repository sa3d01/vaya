<?php

namespace Modules\Employee\Http\Controllers;


use Modules\Employee\Entities\BrandEmployee;
use Modules\Employee\Transformers\BrandEmployeeDTO;


class BrandController extends MasterController
{
    public function profile($id)
    {
        $brand = BrandEmployee::find($id);
        return $this->sendResponse(new BrandEmployeeDTO($brand));
    }

}
