<?php

namespace Modules\Admin\Http\Requests;

use App\Utils\PreparePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditBrandOwnerRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $phone = new PreparePhone($this->phone);
        if (!$phone->isValid()) {
            return redirect()->back()->withErrors($phone->errorMsg());
        }
        $this->merge(['phone' => $phone->getNormalized()]);
    }
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|max:100|email:rfc,dns|unique:brand_owners,email,' . $this->id,
            'phone' => 'required|string|max:100|unique:brand_owners,phone,' .  $this->id,
            'avatar' => 'nullable|image',
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
