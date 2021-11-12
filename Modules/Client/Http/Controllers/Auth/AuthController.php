<?php

namespace Modules\Client\Http\Controllers\Auth;

use App\Models\Client;
use App\Traits\Api\LoginTrait;
use App\Traits\Api\UserPhoneVerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Http\Requests\Api\Auth\AuthRequest;
use Modules\Client\Http\Requests\Api\Auth\RegisterRequest;
use Modules\Client\Http\Requests\Api\Auth\UpdateProfileRequest;
use Modules\Client\Transformers\ClientLoginDTO;

class AuthController extends Controller
{
    use UserPhoneVerificationTrait;
    use LoginTrait;

    public function Register(RegisterRequest $request)
    {
        $client=Client::create($request->validated());
        $this->createPhoneVerificationCodeForClient($client);
        return $this->loginClient($client, $request);
    }

    public function checkAuth(AuthRequest $request)
    {
        $user = Client::where(['phone' => $request['phone']])->first();
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
        $this->createPhoneVerificationCodeForClient($user);
        return $this->loginClient($user, $request);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $client = auth('client')->user();
        $client->update($request->validated());
        $response = [
            'status' => 200,
            'message' => "",
            'data' => new ClientLoginDTO(auth('client')->user()),
        ];
        return response()->json($response);
    }

    public function updateAvatar(Request $request)
    {
        $client = auth('client')->user();
        $client->update([
            'avatar' => $request->file('avatar')
        ]);
        $response = [
            'status' => 200,
            'message' => "",
            'data' => [
                "avatar" => $client->avatar
            ],
        ];
        return response()->json($response);

    }
}
