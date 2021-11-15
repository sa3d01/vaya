<?php

namespace Modules\Client\Http\Requests\Api;

use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class CheckPromoCodeRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'promo_code' => 'required|max:20',
            'service_id' => 'required|numeric|exists:services,id',
        ];
    }
}
