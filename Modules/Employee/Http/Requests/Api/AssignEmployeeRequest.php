<?php

namespace Modules\Employee\Http\Requests\Api;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class AssignEmployeeRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'brand_employee_id' => 'required|exists:brand_employees,id',
        ];
    }
}
