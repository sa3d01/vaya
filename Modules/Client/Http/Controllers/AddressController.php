<?php

namespace Modules\Client\Http\Controllers;

use App\Models\ClientAddress;
use Illuminate\Routing\Controller;
use Modules\Client\Http\Requests\Api\CreateAddressRequest;
use Modules\Client\Transformers\AddressDTO;

class AddressController extends MasterController
{
    public function index()
    {
        $addresses = ClientAddress::where('client_id', auth('client')->id())->get();
        return $this->sendResponse(AddressDTO::collection($addresses));
    }

    public function store(CreateAddressRequest $request)
    {
        $input = $request->validated();
        $input['client_id'] = auth('client')->id();
        ClientAddress::create($input);
        $addresses = ClientAddress::where('client_id', auth('client')->id())->get();
        return $this->sendResponse(AddressDTO::collection($addresses));
    }

    public function update($id, CreateAddressRequest $request)
    {
        $input = $request->validated();
        $address = ClientAddress::find($id);
        $address->update($input);
        $addresses = ClientAddress::where('client_id', auth('client')->id())->get();
        return $this->sendResponse(AddressDTO::collection($addresses));
    }

    public function destroy($id)
    {
        $address = ClientAddress::find($id);
        $address->delete();
        $addresses = ClientAddress::where('client_id', auth('client')->id())->get();
        return $this->sendResponse(AddressDTO::collection($addresses));
    }
}
