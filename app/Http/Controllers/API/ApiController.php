<?php

namespace App\Http\Controllers\API;

use Log;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use Carbon\Carbon;

use Exception;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{


    public $codeErrorHttp  = "404";

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($message, $result = [], $code= 200 )
    {
        $response = [
            'estado' => true,
            'mensajeRespuesta' => $message,
            'result'    => $result,
            'codigoRespuesta'=>"00",
            'fechaRespuesta' => Carbon::now("GMT-6")->toIso8601String(),
            

        ];


        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message,  $code = 404)
    {
        $response = [
            'estado' => false,
            'mensajeRespuesta' => $message,
            'codigoRespuesta'=>"00",
            'fechaRespuesta' => Carbon::now("GMT-6")->toIso8601String() ,
           

        ];


        return response()->json($response, $code);
    }

}
