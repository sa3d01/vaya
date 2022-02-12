<?php

namespace Modules\Employee\Http\Controllers\Auth;

use App\Traits\Api\UserPhoneVerificationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\BrandOwner;
use Modules\Brand\Entities\PhoneVerificationCode;
use Modules\Brand\Http\Controllers\MasterController;
use Modules\Brand\Http\Requests\Api\Auth\AuthRequest;
use Modules\Brand\Http\Requests\Api\Auth\VerifyPhoneRequest;
use Modules\Brand\Transformers\BrandLoginDTO;
use App\Models\BrandEmployee;
use Modules\Employee\Transformers\EmployeeLoginDto;

class VerifyController extends MasterController
{
    use UserPhoneVerificationTrait;

    public function resendPhoneVerification(AuthRequest $request): object
    {
        $request->validated();
        $user = BrandEmployee::where(['phone' => $request['phone'],'type'=>'officer'])->first();
        $this->createPhoneVerificationCodeForEmployee($user);
        return $this->sendResponse([], 'code sent.');
    }

    public function verify(VerifyPhoneRequest $request)
    {
        $user = BrandEmployee::where(['phone' => $request['phone'],'type'=>'officer'])->first();
        $verificationCode = PhoneVerificationCode::where([
            'brand_employee_id' => $user->id,
            'phone' => $request['phone'],
            'activation_code' => $request['activation_code'],
        ])->latest()->first();
        if (!$verificationCode) {
            return $this->sendError('Wrong code! Please try again.');
        }
        if (Carbon::now()->gt(Carbon::parse($verificationCode->expires_at))) {
            return $this->sendError('Code expired. Please request a new token.');
        }
        DB::transaction(function () use ($user, $verificationCode) {
            $now = Carbon::now();
            $verificationCode->update(['verified_at' => $now]);
            $user->update(['phone_verified_at' => $now]);
        });
        return $this->sendResponse(new EmployeeLoginDto($user));
    }

    public function logout()
    {
        $user = BrandEmployee::find(auth('employee')->id());
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
        $user->update([
            'phone_verified_at' => null,
        ]);
        return $this->sendResponse([], "Logged out successfully.");
    }

}
