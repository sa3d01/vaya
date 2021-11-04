<?php

namespace App\Traits\Api;

use Carbon\Carbon;
use Modules\Brand\Entities\PhoneVerificationCode;

trait UserPhoneVerificationTrait
{
    protected function createPhoneVerificationCodeForBrand($user)
    {
        $token = 2022;
        $data = [
            'brand_owner_id' => $user->id,
            'phone' => $user->phone,
            'activation_code' => $token,
            'expires_at' => Carbon::now()->addMinutes(10),
        ];
        PhoneVerificationCode::create($data);
        //todo:: send-sms
        return $data;
    }

}
