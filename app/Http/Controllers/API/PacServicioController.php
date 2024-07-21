<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\StorePacServicioRequest;
use App\Http\Requests\UpdatePacServicioRequest;

use Log;
use Carbon\Carbon;


//Exception
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\ServerException;
use ErrorException;
use HttpException;
use Exception;

//NEGOCIO
use App\Negocio\PacServicio as nPacServicio;

class PacServicioController extends ApiController
{
    private $mensaje = array();
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $numeroDeSolicitud = Carbon::now()->timestamp;
            $data = $request->all();
           
           
            $data['calle_d']="calle d";
            $data['no_exterior_d'] = "no_exterior_d";
            $data['no_interior_d'] = "no_interior_d";
            $data['colonia_d'] = "colonia_d ";
            $data['municipio_alcaldia_d'] = "municipio_alcaldia_d";
            $data['estado_d'] = "estado_d";
            

            $nPacServicio = new nPacServicio($numeroDeSolicitud); 
            $nPacServicio->crear($data);

            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            return $this->successResponse( "Registro Exitoso",$nPacServicio->getResponse(), "201");

            //dd(true);
         } catch (ValidationException $ex) {
            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ValidationException");
            
            Log::debug(print_r($ex->getMessage(),true));
            $this->codeErrorHttp= 412;
            
            $this->mensaje =$nPacServicio->getMensajes();
            $this->mensaje[] = sprintf("%s - ValidationException",$numeroDeSolicitud);
            
            return $this->sendError($this->mensaje, $this->codeErrorHttp);
        
        } catch (ModelNotFoundException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__.__LINE__." ModelNotFoundException");
            Log::debug(print_r($ex->getMessage(),true));
            return $this->sendError("ModelNotFoundException","Favor de contactar al proveedor", "400");
            
        
        } catch (ClientException  $ex) {
            Log::info(__CLASS__." ".__FUNCTION__." GuzzleHttp\Exception\ClientException");
            $response = $ex->getResponse()->getBody()->getContents();
            Log::debug(print_r($response,true));
            
            return $this->sendError("LTD ClientException",$response, "400");

        } catch (InvalidArgumentException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__.__LINE__." GuzzleHttp\Exception\InvalidArgumentException");
            Log::debug(print_r($ex->getMessage(),true));
            return $this->sendError("InvalidArgumentException",$ex->getMessage(), "400");

        } catch (ServerException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__.__LINE__." \GuzzleHttp\Exception\ServerException");
            $response = $ex->getResponse()->getBody()->getContents();
            Log::debug(print_r($response,true));
            Log::debug(print_r(json_decode($response),true));
            return $this->sendError("ServerException",$ex->getMessage(), "400");            

        } catch (ErrorException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__." ErrorException");
            Log::debug(print_r($ex,true));
            
            $mensaje =$ex->getMessage();
            return $this->sendError("ErrorException",$ex->getMessage(), "400");

        } catch (HttpException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__." HttpException");
            $resultado = $ex;
            return $this->sendError("HttpException ",$ex->getMessage(), "400");
        } catch (Exception $e) {
            Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__." Exception");
            Log::debug($e->getMessage());
            return $this->sendError("Exception","Favor de validar con tu proveedor", "400");
        }

        return $this->sendError("ValidationException",$ex->getMessage(), $this->codeErrorHttp);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PacServicio $pacServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PacServicio $pacServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacServicioRequest $request, PacServicio $pacServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PacServicio $pacServicio)
    {
        //
    }
}
