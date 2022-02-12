<?php

namespace Modules\Employee\Http\Requests\Api;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class UpdateEmployeeRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $phone = new PreparePhone($this->phone);
        if (!$phone->isValid()) {
            throw new HttpResponseException(response()->json([
                'status' =>400,
                'message' => $phone->errorMsg()
            ], 400));
        }
        $this->merge(['phone' => $phone->getNormalized()]);
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:90',
            'phone' => 'nullable|string|max:90|unique:brand_employees,phone,' . $this->id,
            'email' => 'nullable|email|unique:brand_employees,email,' . $this->id,
            'type' => 'nullable|in:officer,technical',
        ];
    }
}
