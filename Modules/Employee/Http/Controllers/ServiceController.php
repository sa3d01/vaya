<?php

namespace Modules\Employee\Http\Controllers;


use App\Models\Order;
use Illuminate\Http\Request;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Entities\Service;
use Modules\Brand\Http\Requests\Api\CreateServiceRequest;
use Modules\Brand\Transformers\ServiceResource;


class ServiceController extends MasterController
{
    public function index(Request $request)
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
        if ($request['date']){
            $service_ids=Order::where(['brand_id'=>$brand->id])->where('date',$request['date'])->pluck('service_id');
            $services=Service::whereIn('id',$service_ids)->get();
        }else{
            $services=$brand->services;
        }
        return $this->sendResponse(ServiceResource::collection($services));
    }

    public function store(CreateServiceRequest $request)
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
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
        $brand = Brand::find(auth('employee')->user()->brand_id );
        return $this->sendResponse(ServiceResource::collection($brand->services));
    }

}
