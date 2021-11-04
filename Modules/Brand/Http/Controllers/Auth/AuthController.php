<?php

namespace Modules\Brand\Http\Controllers\Auth;

use App\Traits\Api\LoginTrait;
use App\Traits\Api\UserPhoneVerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Brand\Entities\BrandOwner;
use Modules\Brand\Http\Requests\Api\Auth\AuthRequest;
use Modules\Brand\Http\Requests\Api\Auth\UpdateProfileRequest;
use Modules\Brand\Transformers\BrandLoginDTO;

class AuthController extends Controller
{
    use UserPhoneVerificationTrait;
    use LoginTrait;

    public function checkAuth(AuthRequest $request)
    {
        $user = BrandOwner::where(['phone' => $request['phone']])->first();
        if (!$user) {
            $response = [
                'status' => 400,
                'message' => 'user not found',
                'data' => "",
            ];
            return response()->json($response, 400);
        }
        if ($user->banned == 1) {
            $response = [
                'status' => 400,
                'message' => 'you are banned from administrator',
                'data' => "",
            ];
            return response()->json($response, 400);
        }
        $this->createPhoneVerificationCodeForBrand($user);
        return $this->loginBrand($user, $request);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $brand_owner=auth('brand')->user();
        $brand_owner->update($request->validated());
        $response = [
            'status' => 200,
            'message' => "",
            'data' => new BrandLoginDTO(auth('brand')->user()),
        ];
        return response()->json($response);
    }

    public function updateAvatar(Request $request)
    {
        $brand_owner=auth('brand')->user();
        $brand_owner->update([
            'avatar'=>$request->file('avatar')
        ]);
        $response = [
            'status' => 200,
            'message' => "",
            'data' => [
                "avatar" => $brand_owner->avatar
            ],
        ];
        return response()->json($response);

    }
}
