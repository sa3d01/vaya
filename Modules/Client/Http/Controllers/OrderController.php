<?php

namespace Modules\Client\Http\Controllers;

use App\Models\ClientAddress;
use App\Models\Config;
use App\Models\Order;
use App\Models\PromoCode;
use App\Models\Service;
use Carbon\Carbon;
use Modules\Brand\Transformers\OrderResource;
use Modules\Client\Http\Requests\Api\CheckPromoCodeRequest;
use Modules\Client\Http\Requests\Api\CreateOrderRequest;

class OrderController extends MasterController
{
    public function serviceShifts($service_id)
    {
        $service=Service::find($service_id);
        $days_count=6;
        $data=[];
        for ($i = 0; $i <= $days_count; $i++) {
            $date = Carbon::now()->addDays($i);
            $day=$date->format('l');
            if(array_key_exists($day, $service->shifts)) {
                $arr['day'] = $date->format('Y/m/d');
                $arr['times'] = $service->shifts[$day];
                $data[]=$arr;
            }else{
                if($days_count<30){
                    $days_count++;
                }
            }
        }
        return $this->sendResponse($data);
    }
    public function checkPromoCode(CheckPromoCodeRequest $request)
    {
        $promo_code = PromoCode::where(['code'=> $request['promo_code'],'banned'=>false])->first();
        $service=Service::find($request['service_id']);
        if (!$promo_code) {
            return $this->sendError("هذا الكود غير صالح");
        } elseif (Carbon::parse($promo_code->end_date) < Carbon::now()) {
            return $this->sendError("هذا الكود غير صالح");
        } elseif (Carbon::parse($promo_code->start_date) > Carbon::now()) {
            return $this->sendError("هذا الكود غير صالح");
        } else {
            if ($promo_code->type=='percent')
            {
                $new_price = ($service->price) - ($promo_code->value * $service->price / 100);
            }else{
                $new_price = ($service->price) - ($promo_code->value);
            }
            return $this->sendResponse(
                [
                    'price' => $new_price,
                    'discount' => $service->price - $new_price,
                    'app_ratio' => Config::value('ratio'),
                    'total_price' => $new_price + (Config::value('ratio') * $new_price / 100),
                ]
                , "تم التأكد من صحة الكود");
        }
    }

    public function store(CreateOrderRequest $request)
    {
        $service=Service::find($request['service_id']);
        $address=ClientAddress::find($request['address_id']);
        $input=$request->validated();
        $input['client_address_id']=$request['address_id'];
        $input['client_id']=auth('client')->id();
        $input['client_name']=auth('client')->user()->name;
        $input['client_phone']=$address->phone;
        $input['brand_id']=$service->brand_id;
        $input['status']='new';
        if ($request['promo_code']){
            $promo_code = PromoCode::where(['code'=> $request['promo_code'],'banned'=>false])->first();
            $input['promo_code_id']=$promo_code->id;
            if ($promo_code->type=='percent')
            {
                $new_price = ($service->price) - ($promo_code->value * $service->price / 100);
            }else{
                $new_price = ($service->price) - ($promo_code->value);
            }
            $input['price']=$new_price;
        }else{
            $input['price']=$service->price;
        }
        $order=Order::create($input);
        return $this->sendResponse(new OrderResource($order));
    }

    public function currentOrders()
    {
        $client=auth('client')->user();
        $orders=Order::where(['client_id'=>$client->id,'status'=>'in_progress'])->orWhere(['client_id'=>$client->id,'status'=>'new'])->latest()->get();
        return $this->sendResponse(OrderResource::collection($orders));
    }

    public function allOrders()
    {
        $client=auth('client')->user();
        $orders=Order::where('client_id',$client->id)->where('status','!=','in_progress')->where('status','!=','new')->latest()->get();
        return $this->sendResponse(OrderResource::collection($orders));
    }
}
