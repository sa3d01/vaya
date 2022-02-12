<?php

namespace Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;

abstract class MasterController extends Controller
{

    public function __construct()
    {
    }

    public function sendResponse($result, $message = ''):object
    {
        $response = [
            'status' => 200,
            'message' => $message,
            'data' => $result,
        ];
        return response()->json($response);
    }

    public function sendError($error, $data = [], $code = 400):object
    {
        $response = [
            'status' => $code,
            'message' => $error,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }
}
