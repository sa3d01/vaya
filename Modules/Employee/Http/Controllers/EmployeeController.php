<?php

namespace Modules\Employee\Http\Controllers;


use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\BrandEmployee;
use Modules\Brand\Http\Requests\Api\CreateEmployeeRequest;
use Modules\Brand\Http\Requests\Api\UpdateEmployeeRequest;
use Modules\Brand\Transformers\BrandEmployeeDTO;


class EmployeeController extends MasterController
{
    public function index()
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
        return $this->sendResponse(
            BrandEmployeeDTO::collection(
                \App\Models\BrandEmployee::where(['brand_id'=>$brand->id,'type'=>'technical'])->get()
            )
        );
    }

    public function store(CreateEmployeeRequest $request)
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
        $input = $request->validated();
        $input['brand_id'] = $brand->id;
        BrandEmployee::create($input);
        return $this->sendResponse(
            BrandEmployeeDTO::collection(
                \App\Models\BrandEmployee::where(['brand_id'=>$brand->id,'type'=>'technical'])->get()
            )
        );
    }

    public function update($id,UpdateEmployeeRequest $request)
    {
        $input = $request->validated();
        $employee=BrandEmployee::find($id);
        $employee->update($input);
        $brand = Brand::find(auth('employee')->user()->brand_id );
        return $this->sendResponse(
            BrandEmployeeDTO::collection(
                \App\Models\BrandEmployee::where(['brand_id'=>$brand->id,'type'=>'technical'])->get()
            )
        );
    }
    public function destroy($id)
    {
        $employee=BrandEmployee::find($id);
        $employee->delete();
        $brand = Brand::find(auth('employee')->user()->brand_id );
        return $this->sendResponse(
            BrandEmployeeDTO::collection(
                \App\Models\BrandEmployee::where(['brand_id'=>$brand->id,'type'=>'technical'])->get()
            )
        );
    }

}
