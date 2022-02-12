<?php

namespace Modules\Employee\Http\Controllers\Auth;

use App\Traits\Api\LoginTrait;
use App\Traits\Api\UserPhoneVerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Brand\Entities\BrandEmployee;
use Modules\Brand\Entities\BrandOwner;
use Modules\Brand\Http\Requests\Api\Auth\AuthRequest;
use Modules\Brand\Http\Requests\Api\Auth\UpdateProfileRequest;
use Modules\Brand\Transformers\ClientLoginDTO;

class AuthController extends Controller
{
    use UserPhoneVerificationTrait;
    use LoginTrait;

    public function checkAuth(AuthRequest $request)
    {
        $user = BrandEmployee::where(['phone' => $request['phone'],'type'=>'officer'])->first();
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
        $this->createPhoneVerificationCodeForEmployee($user);
        return $this->loginEmployee($user, $request);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $brand_owner=auth('brand')->user();
        $brand_owner->update($request->validated());
        $response = [
            'status' => 200,
            'message' => "",
            'data' => new ClientLoginDTO(auth('brand')->user()),
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
