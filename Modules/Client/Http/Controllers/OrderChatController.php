<?php

namespace Modules\Client\Http\Controllers;

use App\Models\Brand;
use App\Models\Chat;
use App\Models\Order;
use Illuminate\Http\Request;
use Modules\Client\Transformers\ChatOrderDTO;

class OrderChatController extends MasterController
{
    public function messages($order_id)
    {
        $chats = Chat::where('order_id',$order_id)->get();
        return $this->sendResponse(ChatOrderDTO::collection($chats));
    }
    public function store(Request $request)
    {
        $input = $request->only('message','order_id');
        $order=Order::find($request['order_id']);
        $input['client_id'] = auth('client')->id();
        $input['brand_id'] = $order->brand_id;
        Chat::create($input);
        $chats = Chat::where('order_id',$request['order_id'])->get();
        return $this->sendResponse(ChatOrderDTO::collection($chats));
    }
}
