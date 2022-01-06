<?php

namespace Modules\Brand\Http\Requests\Api;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class CreateServiceRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:90',
            'description' => 'required|string|max:255',
            'price' => 'required',
            'period' => 'nullable',
            'shifts' => 'required',
            'technicals' => 'required|array',
            'image' => 'nullable',
        ];
    }
}
