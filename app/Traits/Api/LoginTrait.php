<?php

namespace App\Traits\Api;

use App\Models\Client;
use Modules\Brand\Entities\BrandOwner;
use Illuminate\Http\Request;

trait LoginTrait
{
    public function loginBrand(BrandOwner $user, Request $request): object
    {
        $user->update([
            'fcm_token' => $request['fcm_token'],
            'os_type' => $request['os_type'],
            'last_session_id' => session()->getId(),
            'last_ip' => $request->ip(),
        ]);
        $response = [
            'status' => 200,
            'message' => '',
            'data' => ["phone" => $request["phone"]],
        ];
        return response()->json($response);
    }
    public function loginClient(Client $user, Request $request): object
    {
        $user->update([
            'fcm_token' => $request['fcm_token'],
            'os_type' => $request['os_type'],
            'last_session_id' => session()->getId(),
            'last_ip' => $request->ip(),
        ]);
        $response = [
            'status' => 200,
            'message' => '',
            'data' => ["phone" => $request["phone"]],
        ];
        return response()->json($response);
    }
}
