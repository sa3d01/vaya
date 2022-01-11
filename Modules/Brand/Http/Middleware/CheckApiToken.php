<?php

namespace Modules\Brand\Http\Middleware;

use Closure;

class CheckApiToken
{
    public function handle($request, Closure $next)
    {
        if (!auth('brand')->check()) {
            $response = [
                'status' => 401,
                'message' => 'Wrong device id..',
            ];
            return response()->json($response, 401);
        }
        $user = auth('brand')->user();
//        if ($request->hasHeader('device_uuid') && $request->header('device_uuid') != $user->device_uuid) {
//            $response = [
//                'status' => 401,
//                'message' => 'Wrong device id..',
//            ];
//            return response()->json($response, 401);
//        }
        if ($user->banned == true) {
            $response = [
                'status' => 401,
                'message' => 'تم حظرك من قبل إدارة التطبيق ..',
            ];
            return response()->json($response, 400);
        }
        return $next($request);
    }
}
