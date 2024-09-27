<?php
namespace App\Negocio;

//GENERAL
use Carbon\Carbon;
use Log;
use DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Config;

//MODELS
use App\Models\User as mUser;

//Negocio


//DTO



//EXCEPCIONES
use Illuminate\Validation\ValidationException;



class User {
 
 	private $numeroDeSolicitud = 0;
 	private $response = array();
	private $mensajes = array();
	private $estatus = false;

	function __construct($numeroDeSolicitud) {
        $this->numeroDeSolicitud = $numeroDeSolicitud;
    }


    /**
     * Funcion para registrar un usuario con sanctum
     * 
     * @author Javier Hernandez
     * @copyright 2024 Colombia API
     * @package App\Negocio
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion registro
     * 
     * @param array $data Arreglo con valores envidos por el usuario 
     * 
     * @throws \LogicException
     * 
     * @var object $this->response Response de la solicutd de timbrar factura
     * 
     * 
     * @return void
     */

    public function registro($data=[])
    {	
    	mUser::create([
    		"name"=>$data['name'],
    		"email"=>$data['email'],
    		"password" => $data['password'],
    	]);


    	$this->estatus = true;
    	
    }



    public function login(array $data)
	{

	    if( !Auth::attempt([ 'email' => $data['email'], 'password' => $data['password'] ] )) {

	    	throw ValidationException::withMessages(array("Sin autorizacion"));    
	    }

	    $user = Auth::user(); 
	    $tokenResult = $user->createToken($data['email'],array('*'),Carbon::now()->addMinutes( Config::get("sanctum.expiration") ));
	    $token = ($tokenResult->plainTextToken);

	    $this->estatus = true;

	    $this->response = [
		    'accessToken' =>$token,
		    'token_type' => 'Bearer',
	    ];
	}



    public function getResponse(){
        return $this->response;
    }

    public function getMensajes(){
        return $this->mensajes;
    }

    public function getEstatus(){
        return $this->estatus;
    }

}
 	