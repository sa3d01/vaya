<?php

namespace Modules\Client\Http\Requests\Api\Auth;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Brand\Http\Requests\Api\ApiMasterRequest;

class UpdateProfileRequest extends ApiMasterRequest
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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:90',
            'email' => 'nullable|email|unique:clients,email,' . auth('client')->id(),
            'phone' => 'nullable|string|unique:clients,phone,' . auth('client')->id(),
            'fcm_token' => 'required',
            'os_type' => 'required|in:android,ios',
        ];
    }
}
