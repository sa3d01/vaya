<?php

namespace Modules\Brand\Http\Controllers;

use App\Models\Brand;
use App\Models\Chat;
use Illuminate\Http\Request;
use Modules\Brand\Transformers\ContactDTO;

class ContactController extends MasterController
{
    public function adminChat()
    {
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->first();
        $chats = Chat::where('brand_id', $brand->id)->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

    public function store(Request $request)
    {
        $input = $request->only('message');
        $brand = Brand::where('brand_owner_id', auth('brand')->id())->first();
        $input['brand_id'] = $brand->id;
        $input['admin_id'] = 1;
        $input['sent_by'] ='brand_owner';
        Chat::create($input);
        $chats = Chat::where('brand_id', $brand->id)->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

}
