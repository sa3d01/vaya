<?php

namespace Modules\Client\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Modules\Client\Transformers\ContactDTO;

class ContactController extends MasterController
{
    public function adminChat()
    {
        $chats = Chat::where('client_id', auth('client')->id())->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

    public function store(Request $request)
    {
        $input = $request->only('message');
        $input['client_id'] = auth('client')->id();
        $input['admin_id'] = 1;
        Chat::create($input);
        $chats = Chat::where('client_id', auth('client')->id())->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

}
