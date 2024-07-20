<?php

namespace App\Http\Controllers\API;

use Log;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use Exception;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($message, $result = [], $code= 200 )
    {
        $response = [
            'success' => true,
            'message' => $message,
            'result'    => $result,

        ];


        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $result = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'result'    => $result,

        ];


        return response()->json($response, $code);
    }

}
