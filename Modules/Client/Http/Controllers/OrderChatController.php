<?php

namespace Modules\Client\Http\Controllers;

use App\Models\Chat;
use Modules\Client\Transformers\ChatOrderDTO;

class OrderChatController extends MasterController
{
    public function messages($order_id)
    {
        $chats = Chat::where('order_id',$order_id)->get();
        return $this->sendResponse(ChatOrderDTO::collection($chats));
    }
}
