<?php

namespace Modules\Client\Http\Requests\Api;

use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class CreateOrderRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_id' => 'required|numeric|exists:services,id',
            'promo_code' => 'nullable',
            'date' => 'required|date',
            'time' => 'required|string',
            'address_id' => 'required|numeric|exists:client_addresses,id',
        ];
    }
}
