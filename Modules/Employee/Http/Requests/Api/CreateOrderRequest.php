<?php

namespace Modules\Employee\Http\Requests\Api;

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
            'brand_employee_id' => 'required|numeric|exists:brand_employees,id',
            'client_name' => 'required',
            'client_phone' => 'required',
            'date' => 'required|date',
            'time' => 'required|string',
        ];
    }
}
