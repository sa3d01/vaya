<?php

namespace Modules\Employee\Http\Controllers;


use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Brand\Entities\Brand;
use Modules\Employee\Http\Requests\Api\AssignEmployeeRequest;
use Modules\Employee\Http\Requests\Api\CancelOrderRequest;
use Modules\Employee\Http\Requests\Api\CreateOrderRequest;
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
        $brand = Brand::find(auth('employee')->user()->brand_id );
        $orders=Order::where(['brand_id'=>$brand->id,'service_id'=>$service_id])->get();
        return $this->sendResponse(OrderResource::collection($orders));
    }
    public function list(Request $request)
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
        $orders=Order::where(['brand_id'=>$brand->id]);
        if ($request['date']){
            $orders=$orders->where('date',$request['date']);
        }
        $orders=$orders->latest()->get();
        return $this->sendResponse(OrderResource::collection($orders));
    }
    public function assignTechnical($id,AssignEmployeeRequest $request)
    {
        $order=Order::find($id);
        $order->update([
            'brand_employee_id'=>$request['brand_employee_id'],
            'status'=>'in_progress'
        ]);
        return $this->sendResponse(new OrderResource($order));
    }
    public function cancel($id,CancelOrderRequest $request)
    {
        $order=Order::find($id);
        $order->update([
            'status'=>'cancelled',
            'cancelled_at'=>Carbon::now(),
            'cancelled_by'=>auth('employee')->id(),
            'cancel_reason'=>$request['cancelled_reason'],
        ]);
        return $this->sendResponse(new OrderResource($order));
    }
    public function complete($id)
    {
        $order=Order::find($id);
        $order->update([
            'status'=>'completed',
        ]);
        return $this->sendResponse(new OrderResource($order));
    }
}
