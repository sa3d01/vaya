<?php

namespace Modules\Employee\Http\Requests\Api;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class CancelOrderRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'cancel_reason' => 'nullable',
        ];
    }
}
