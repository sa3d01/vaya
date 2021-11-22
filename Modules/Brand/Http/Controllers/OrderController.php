<?php

namespace Modules\Brand\Http\Controllers;


use App\Models\Order;
use App\Models\Service;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\Api\CreateOrderRequest;
use Modules\Brand\Transformers\OrderResource;


class OrderController extends MasterController
{
    public function store(CreateOrderRequest $request)
    {
        $service=Service::find($request['service_id']);
        $input=$request->validated();
        $input['created_by']='brand';
        $input['brand_id']=$service->brand_id;
        $input['price']=$service->price;
        $order=Order::create($input);
        return $this->sendResponse(new OrderResource($order));
    }
    public function serviceOrders($service_id)
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->firstOrFail();
        $orders=Order::where(['brand_id'=>$brand->id,'service_id'=>$service_id])->paginate();
        return OrderResource::collection($orders);
    }


}
