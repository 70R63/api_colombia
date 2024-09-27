<?php
namespace App\Negocio\Servicios;

//GENERAL
use Carbon\Carbon;
use Log;
use DB;
use Illuminate\Support\Facades\Storage;

//MODELS
use App\Models\Consultas as mConsultas;

//Negocio


//DTO
use App\Dto\Usuarios as dtoUsuarios;
use App\Dto\Servicios\Consultas as dtoConsultas;

//EXCEPCIONES
use Illuminate\Validation\ValidationException;


class Consultas {
 
 	private $numeroDeSolicitud = 0;
 	private $response = null;
	private $mensaje = array();
	private $errors = array();
	public $estatus = false;
 	

	function __construct($numeroDeSolicitud) {
        $this->numeroDeSolicitud = $numeroDeSolicitud;
    }

	/**
     * Parsea y valida valores para la contruccion de un json consultas 
     * 
     * @author Javier Hernandez
     * @copyright 2024 API COLOMBIA
     * @package App\Negocio\Servicios
     * @web
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion crearFromWeb
     * 
     * @throws \LogicException
     *
     * @param 
     * 
     * @var array $data Valores enviados from forma
     * 
     * @return void
     */

    public function crearFromWeb($data){

    	Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

    	Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($data,true));

    	$dtoUsuarios = new dtoUsuarios();
    	Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$dtoUsuarios->tipoDocumentoldentificacion = "CC" ;
    	$dtoUsuarios->numDocumentoldentificacion = "52100200" ;


    	Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    	
        //$file = $data->file('file');
        $handle = fopen($data['file']->getRealPath(), "r");
      
        fgetcsv($handle);
        $consecutivo = 1;
        while ( ($line = fgetcsv($handle)) !==FALSE) {
            Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__." Consecutivo=$consecutivo");
            Log::info(print_r($line,true));
            $dtoConsultas = new dtoConsultas();

            $dtoConsultas->consecutivo = $consecutivo;
            $dtoUsuarios->servicios["consultas"]=array($dtoConsultas);
            $consecutivo++;
        }

    	
    	fclose($handle);

    	Log::debug(print_r(json_encode($dtoUsuarios),true));

    	Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

    }



    /**
     * Parsea y valida valores para la construccion de un json consultas from API
     * 
     * @author Javier Hernandez
     * @copyright 2024 API COLOMBIA
     * @package App\Negocio\Servicios
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion crearFromAPI
     * 
     * @throws \LogicException
     *
     * @param 
     * 
     * @var array $data Valores enviados from forma
     * 
     * @return void
     */

    public function crearFromAPI($data){

        Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($data,true));

        $dtoUsuarios = new dtoUsuarios();
        Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        Log::info("$this->numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        $this->response[]="Proceso Dian completo";
    }


    public function getResponse(){
        return $this->response;
    }

    public function getMensajes(){
        return $this->mensaje;
    }

    public function getErrors(){
        return $this->errors;
    }
    public function getEstatus(){
        return $this->estatus;
    }

}
