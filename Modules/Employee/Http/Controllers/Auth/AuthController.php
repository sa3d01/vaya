<?php

namespace Modules\Employee\Http\Controllers\Auth;

use App\Traits\Api\LoginTrait;
use App\Traits\Api\UserPhoneVerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\BrandEmployee;
use Modules\Employee\Http\Requests\Api\Auth\AuthRequest;
use Modules\Employee\Http\Requests\Api\Auth\UpdateProfileRequest;
use Modules\Employee\Transformers\EmployeeLoginDto;

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
            'data' => new EmployeeLoginDto(auth('employee')->user()),
        ];
        return response()->json($response);
    }

    public function updateAvatar(Request $request)
    {
        $brand_employee=auth('employee')->user();
        $brand_employee->update([
            'avatar'=>$request->file('avatar')
        ]);
        $response = [
            'status' => 200,
            'message' => "",
            'data' => [
                "avatar" => $brand_employee->avatar
            ],
        ];
        return response()->json($response);

    }
}
