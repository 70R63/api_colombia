<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

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
USE App\Negocio\User as nUser;

class UserController extends ApiController
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function register(StoreUserRequest $request)
    {
        
        try{
            $numeroDeSolicitud = Carbon::now()->timestamp;
            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

            $request->validate( [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required'
            ]);
            
            $data =$request->all();

            Log::debug($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($data,true));

            if(empty($data))
                throw ValidationException::withMessages(array("Favor de validar tu body"));
           

            $nUser = new nUser($numeroDeSolicitud);
            $nUser->registro($data);
            
            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            return $this->successResponse( "Registro Exitoso",$nUser->getResponse());


        } catch (ValidationException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__.__LINE__." ValidationException");
            Log::debug(print_r($ex->getMessage(),true));
            return $this->sendError("ValidationException",$ex->getMessage(), "400");
        
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
    }


    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function login(StoreUserRequest $request)
    {
        
        try{
            $numeroDeSolicitud = Carbon::now()->timestamp;
            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            
            $data =$request->all();

            Log::debug($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($data,true));

            if(empty($data))
                throw ValidationException::withMessages(array("Favor de validar tu body"));
           

            $nUser = new nUser($numeroDeSolicitud);
            $nUser->login($data);
            
            Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            return $this->successResponse( "Registro Exitoso",$nUser->getResponse());


        } catch (ValidationException $ex) {
            Log::info(__CLASS__." ".__FUNCTION__.__LINE__." ValidationException");
            Log::debug(print_r($ex->getMessage(),true));
            return $this->sendError("ValidationException",$ex->getMessage(), "400");
        
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
    }


}
