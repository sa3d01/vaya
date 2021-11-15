<?php

namespace Modules\Brand\Http\Controllers;


use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\Service;
use Modules\Brand\Http\Requests\Api\CreateServiceRequest;
use Modules\Brand\Transformers\ServiceResource;


class ServiceController extends MasterController
{
    public function index()
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        return $this->sendResponse(ServiceResource::collection($brand->services));
    }

    public function store(CreateServiceRequest $request)
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        $input = $request->validated();
        $input['brand_id'] = $brand->id;
        $service = Service::create($input);
        $service->technicals()->sync($request['technicals']);
        return $this->sendResponse(ServiceResource::collection($brand->services));
    }

    public function update($id, CreateServiceRequest $request)
    {
        $input = $request->validated();
        $service = Service::find($id);
        $service->update($input);
        $service->technicals()->sync($request['technicals']);
        return $this->sendResponse(ServiceResource::collection($service->brand->services));
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        return $this->sendResponse(ServiceResource::collection($brand->services));
    }

}
