<?php

namespace Modules\Brand\Http\Controllers;


use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\BrandEmployee;
use Modules\Brand\Http\Requests\Api\CreateEmployeeRequest;
use Modules\Brand\Http\Requests\Api\UpdateEmployeeRequest;
use Modules\Brand\Transformers\BrandEmployeeDTO;


class EmployeeController extends MasterController
{
    public function index()
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        return $this->sendResponse(BrandEmployeeDTO::collection($brand->employees));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        $input = $request->validated();
        $input['brand_id'] = $brand->id;
        BrandEmployee::create($input);
        return $this->sendResponse(BrandEmployeeDTO::collection($brand->employees));
    }

    public function update($id,UpdateEmployeeRequest $request)
    {
        $input = $request->validated();
        $employee=BrandEmployee::find($id);
        $employee->update($input);
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        return $this->sendResponse(BrandEmployeeDTO::collection($brand->employees));
    }
    public function destroy($id)
    {
        $employee=BrandEmployee::find($id);
        $employee->delete();
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        return $this->sendResponse(BrandEmployeeDTO::collection($brand->employees));
    }

}
