<?php

namespace Modules\Employee\Http\Controllers;

use Modules\Brand\Entities\Brand;
use App\Models\Chat;
use Illuminate\Http\Request;
use Modules\Employee\Transformers\ContactDTO;

class ContactController extends MasterController
{
    public function adminChat()
    {
        $brand = Brand::find(auth('employee')->user()->brand_id );
        $chats = Chat::where('brand_id', $brand->id)->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

    public function store(Request $request)
    {
        $input = $request->only('message');
        $brand = Brand::find(auth('employee')->user()->brand_id );
        $input['brand_id'] = $brand->id;
        $input['admin_id'] = 1;
        $input['sent_by'] ='brand_employee';
        Chat::create($input);
        $chats = Chat::where('brand_id', $brand->id)->where('order_id', null)->get();
        return $this->sendResponse(ContactDTO::collection($chats));
    }

}
