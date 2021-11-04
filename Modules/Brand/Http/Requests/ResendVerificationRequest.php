<?php

namespace Modules\Brand\Http\Requests;

use App\Utils\PreparePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResendVerificationRequest extends FormRequest
{
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
            'phone' => 'required|string|max:90',
            'fcm_token' => 'required',
            'os_type' => 'required|in:android,ios',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
