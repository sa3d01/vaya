<?php

namespace Modules\Client\Http\Requests\Api;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class CreateAddressRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required|string|max:90',
            'phone' => 'nullable|string|max:90',
            'type' => 'required|in:villa,flat',
            'address' => 'required|array',
            'floor_num' => 'nullable|string',
            'flat_num' => 'nullable|string',
        ];
    }
}
