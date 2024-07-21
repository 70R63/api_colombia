<?php
namespace App\Negocio;

//GENERAL
use Carbon\Carbon;
use Log;
use DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

//MODELS
use App\Models\PacServicio as mPacServicio;

//Negocio


//DTO
use App\Dto\FacturaExterna as dtoFacturaExterna;


//EXCEPCIONES
use Illuminate\Validation\ValidationException;


class PacServicio {
 
 	private $numeroDeSolicitud = 0;
 	private $response = null;
	private $mensaje = array();
	private $errors = array();
	public $estatus = false;
 	

	function __construct($numeroDeSolicitud) {
        $this->numeroDeSolicitud = $numeroDeSolicitud;
    }

	/**
     * genera un token par acceso al porta de factuacion
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion obtenerToken
     * 
     * @throws \LogicException
     *
     * @param 
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var GuzzleHttp\Client $client Clse apra uso de ptriciones para la APi 
     * @var array $formQuery Valores que se enviaran para autenticar
     * @var array $headers Cabeceras de la peticion 
     * @var array $parametros Valores de array para la peticion
     * @var array $response Respuesta de la peticion 
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    public function obtenerToken(){

    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
        $mPacServicio = mPacServicio::where("tipo",1)->get();

        if ( !(bool)count($mPacServicio)) {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $mensaje = sprintf("No cuenta con Servicio de timbrado");
            throw ValidationException::withMessages(array($mensaje));
            
        }

    	$uri = $mPacServicio->first()->uri;
    	$formQuery = [
    				'Usuario' => $mPacServicio->first()->usuario,
                	'Password' => $mPacServicio->first()->password,
            ];

        $headers = [
            'accept' => 'application/json'
        ];

        $parametros = [
            'headers'=> $headers
            ,'query' => $formQuery
        ];

        Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$client = new Client();
    	$response = $client->request('GET', $uri, $parametros);

    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$this->response = json_decode($response->getBody()->getContents());
    	Log::debug(print_r($this->response ,true));
    }



    /**
     * genera un token par acceso al porta de factuacion
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion crear
     * 
     * @throws \LogicException
     *
     * @param array $data Valores de toda la peticion de crear guia
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var GuzzleHttp\Client $client Clse apra uso de ptriciones para la APi 
     * @var array $data Valores de array para la peticion
     * @var array $response Respuesta de la peticion 
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    public function crear($data){
    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
        $mPacServicio = mPacServicio::where("tipo",2)->get();

        if ( !(bool)count($mPacServicio)) {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $mensaje = sprintf("No cuenta con Servicio de timbrado - Creación");
            throw ValidationException::withMessages(array($mensaje));
            
        }

    	$uri = $mPacServicio->first()->uri;
    	$token = $mPacServicio->first()->token;
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".$token);
        $authorization = sprintf("Bearer %s",$token);

        $headers = [
            'Authorization' => $authorization,
            'accept' => 'application/json',
    		'content-type' => 'application/*+json',
        ];

        Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
        $dtoFacturaExterna = new dtoFacturaExterna($this->numeroDeSolicitud);
        $dtoFacturaExterna->parsear($data);
        $body = $dtoFacturaExterna->getData();

        Log::debug($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".json_encode($body));
        
        $parametros = [
            'headers'=> $headers,
            'body'	=> json_encode($body),
        ];

        Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$client = new Client();
    	$response = $client->request('POST', $uri, $parametros);

    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$this->response = json_decode($response->getBody()->getContents());
    	Log::debug(print_r($this->response ,true));

    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$this->validaResponse($data);
    }


    /**
     * genera un token par acceso al porta de factuacion
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion validaResponse
     * 
     * @throws \LogicException
     *
     * @param array $data Valores de toda la peticion de crear guia
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var GuzzleHttp\Client $client Clse apra uso de ptriciones para la APi 
  
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    private function validaResponse($data){
    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);

    	if ( ! ($this->response->estatus->codigo === "000") ) {
            Log::debug($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    		$this->mensaje[] = $this->response->estatus->descripcion;
    		//$this->mensaje[] = sprintf("CUFE = '%s'",$this->response->cfdiTimbrado->respuesta->uuid);

    		$this->estatus = true;

            $this->response=[
                'numeroDocumento'=> "00",
                'cufe' => "d1f5e1b8c1d2f3a4567e8b9a1c0d2e3f",    
            ];
             
    	} else {
    		Log::debug($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    		$this->mensaje[]= sprintf("Referencia:%s - Fecha de la solicitud: %s",$data['encabezado']['numeroDocumento'],$this->response->estatus->fecha);

    		$this->mensaje[]= sprintf("%s-%s",$this->response->estatus->codigo, $this->response->estatus->descripcion);


            Log::debug($this->mensaje);


            throw ValidationException::withMessages($this->mensaje);
    		
    	}

    
    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    }

    /**
     * Funcion para actualizar el estado de campo facturado 
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion actualizaPagoFacturado
     * 
     * @throws \LogicException
     *
     * @param int $pago_id Id delpago qeu se solicitop facturar
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var GuzzleHttp\Client $client Clse apra uso de ptriciones para la APi 
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    public function actualizaPagoFacturado(int $pago_id){
    	Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    	Pagos::where('id', $pago_id)
           ->update([
               'facturado' => 2,       
           ]);
    
    	Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
    }


    /**
     * Funcion para descargar el pdf y xml, de forma consecutiva 
     * inserta el registro
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Finanzas
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion validaResponse
     * 
     * @throws \LogicException
     * 
     * @var object $this->response Response de la solicutd de timbrar factura
     * 
     * 
     * @return void
     */

    public function guardarPdfXmlCFDI(int $pago_id){
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        $nameXml = sprintf("facturaexterna/%s.xml",$this->response->cfdiTimbrado->respuesta->uuid );
        
        Storage::disk('public')->put($nameXml,$this->response->cfdiTimbrado->respuesta->cfdixml);

        $namePdf = sprintf("facturaexterna/%s.pdf", $this->response->cfdiTimbrado->respuesta->uuid);
         Storage::disk('public')->put($namePdf,base64_decode($this->response->cfdiTimbrado->respuesta->pdf));
            
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        mFacturaExterna::create([
            "noCertificado" => $this->response->cfdiTimbrado->respuesta->noCertificado,
            "rfcProvCertif" => $this->response->cfdiTimbrado->respuesta->rfcProvCertif,
            "fecha" =>$this->response->cfdiTimbrado->respuesta->fecha ,
            "uuid" => $this->response->cfdiTimbrado->respuesta->uuid,
            "ruta_pdf" => $namePdf,
            "ruta_xml" => $nameXml,
            "empresa_id" => auth()->user()->empresa_id,
            "pago_id" => $pago_id,
        ]);

        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
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
};