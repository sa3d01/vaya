<?php

namespace Modules\Client\Http\Controllers\Auth;

use App\Models\Client;
use App\Traits\Api\UserPhoneVerificationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\BrandOwner;
use Modules\Brand\Entities\PhoneVerificationCode;
use Modules\Brand\Http\Controllers\MasterController;
use Modules\Client\Http\Requests\Api\Auth\AuthRequest;
use Modules\Client\Http\Requests\Api\Auth\VerifyPhoneRequest;
use Modules\Client\Transformers\ClientLoginDTO;

class VerifyController extends MasterController
{
    use UserPhoneVerificationTrait;

    public function resendPhoneVerification(AuthRequest $request): object
    {
        $request->validated();
        $user = Client::where('phone', $request['phone'])->first();
        $this->createPhoneVerificationCodeForClient($user);
        return $this->sendResponse([], 'code sent.');
    }

    public function verify(VerifyPhoneRequest $request)
    {
        $user = Client::where('phone', $request['phone'])->first();
        $verificationCode = PhoneVerificationCode::where([
            'client_id' => $user->id,
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
        return $this->sendResponse(new ClientLoginDTO($user));
    }

    public function logout()
    {
        $user = Client::find(auth('client')->id());
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
        $user->update([
            'phone_verified_at' => null,
        ]);
        return $this->sendResponse([], "Logged out successfully.");
    }

}
