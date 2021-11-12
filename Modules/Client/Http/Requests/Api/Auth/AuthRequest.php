<?php

namespace Modules\Client\Http\Requests\Api\Auth;

use App\Utils\PreparePhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Client\Http\Requests\Api\ApiMasterRequest;

class AuthRequest extends ApiMasterRequest
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
            'phone' => 'required|exists:clients,phone',
            'fcm_token' => 'required',
            'os_type' => 'required|in:android,ios',
        ];
    }
}
