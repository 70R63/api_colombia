<?php
namespace App\Dto;

use Log;
use Carbon\Carbon;


//MODELS
use App\Models\Empresa;
use App\Models\MpPreference;
use App\Models\CertificadoFiscal as mCertificadoFiscal;

//EXCEPCIONES
use Illuminate\Validation\ValidationException;

class FacturaExterna 
{
    private $numeroDeSolicitud = 0;
    private $data = array();

    const REMITENTE = 'remitente';
    const DESTINATARIO = 'destinatario';

    
    function __construct($numeroDeSolicitud)
    {
        $this->numeroDeSolicitud = $numeroDeSolicitud;
    }

    /**
     * Genera parce para el vbody de factuacion
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Dto\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion parsear
     * 
     * @throws \LogicException
     *
     * @param array $data 
     * 
     * @var array $dataParseado Array que contendra la estructura del body  
     * 
     * 
     * @return void
     */

    public function parsear($data){
    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
        Log::debug(print_r($data,true));
        $data['calle'] = "LAGO ALBERTO";
        $data['no_exterior'] = "442";
        $data['no_interior'] ="TORRE A 5 PISO INT 503 A";
        $data['colonia']="ANAHUAC I SECCION"; 
        $data['municipio_alcaldia']="MIGUEL HIDALGO"; 
        $data['estado']="CIUDAD DE MEXICO"; 
        
        //Datos solo se usaran en produccion, para LOCAL y DEV se tiene que usar datos entregaedos po el proveedor
        $data['rfcEmisor']= "CXM201015UN0";
        $data['razon_social']= "COMERCIALIZADORA XPERTA MEXICO SA DE CV";
        $data['regimen_fiscal']= "601";
        $data['cp']="11320";
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        
        //$this->obtenerDatosCSF($data);
        //$data = $this->data;

        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        //$this->obtenerCostoRecarga($data);
        //$data = $this->data;

        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        $this->obtenerCertificado($data);
        $data = $this->data;

        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".config('app.env'));

        if (config('app.env') === "local" || config('app.env') === "dev") {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $data['rfcEmisor']= "EKU9003173C9";
            $data['razon_social']= "ESCUELA KEMPER URGATE";
            $data['regimen_fiscal']= "601";
            $data['cp']="06470";

            $data['rfcReceptor']= "SSF1103037F1";
            $data['razon_social_d']= "SCAFANDRA SOFTWARE FACTORY,";
            $data['uso_cfdi'] = "G03";
            $data['regimen_fiscal_d']= "601";
            $data['cp_d']="06470"; 

        } 
        

        $dataParseado = array();

        $emailMensaje = sprintf("Gracias por su prerencia ");
        
        $fecha = sprintf("%sT%s",carbon::now()->format('Y-m-d'),carbon::now()->format('H:i:s'));
        Log::info($fecha);

        $dataParseado =["DatosGenerales" => [
         "Version" => "4.0", 
         "CSD" => $data["csd"], 
         "LlavePrivada" => $data["llave_privada"], 
         "CSDPassword" => $data["csd_password"], 
         "GeneraPDF" => true, 
         "Logotipo" => "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIGlkPSJMYXllcl8yIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyODkuMDcgMjg5LjA3Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6bm9uZTt9LmNscy0xLC5jbHMtMiwuY2xzLTMsLmNscy00e3N0cm9rZS13aWR0aDowcHg7fS5jbHMtMntmaWxsOiNmN2JjMTY7fS5jbHMtNXtpc29sYXRpb246aXNvbGF0ZTt9LmNscy0ze2ZpbGw6I2ZmZjt9LmNscy00e2ZpbGw6IzFjNzViYzt9PC9zdHlsZT48L2RlZnM+PGcgaWQ9IkxheWVyXzEtMiI+PGcgY2xhc3M9ImNscy01Ij48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik04My42NywxMjQuODdjLTEuMDgsMC0yLjE3LS4yMi0zLjIxLS42OC0yMy4xMi0xMC4yMi0zOC4wNi0zMy4xNS0zOC4wNi01OC40MnYtOC44M2MwLTQuNCwzLjU2LTcuOTYsNy45NS03Ljk2czcuOTYsMy41Niw3Ljk2LDcuOTZ2OC44M2MwLDE4Ljk4LDExLjIyLDM2LjIsMjguNTgsNDMuODcsNC4wMiwxLjc3LDUuODQsNi40Nyw0LjA2LDEwLjQ5LTEuMzEsMi45Ny00LjIzLDQuNzQtNy4yOCw0Ljc0Ii8+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNNjAuOTQsNTYuOTNjMC01Ljg1LTQuNzQtMTAuNTgtMTAuNTgtMTAuNThzLTEwLjU4LDQuNzQtMTAuNTgsMTAuNTgsNC43NCwxMC41OCwxMC41OCwxMC41OCwxMC41OC00Ljc0LDEwLjU4LTEwLjU4Ii8+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNNTQuNSw1Mi40MmgwYy0xLjkxLDAtMy40Ni0xLjU1LTMuNDYtMy40NnYtMTAuMzljMC0xLjkxLDEuNTUtMy40NywzLjQ2LTMuNDdzMy40NiwxLjU1LDMuNDYsMy40N3YxMC4zOWMwLDEuOTEtMS41NSwzLjQ2LTMuNDYsMy40NiIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTUyLjM0LDQ5Ljk4aDBjLTEuMzUsMS4zNS0zLjU0LDEuMzUtNC45LDBsLTcuMzUtNy4zNWMtMS4zNS0xLjM1LTEuMzUtMy41NSwwLTQuOSwxLjM1LTEuMzUsMy41NC0xLjM1LDQuOSwwbDcuMzUsNy4zNWMxLjM1LDEuMzUsMS4zNSwzLjU0LDAsNC45Ii8+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNMjM5LjQsMTgyLjQxYy00LjMxLDAtNy44Ni0zLjQ1LTcuOTUtNy43OWwtLjE5LTguODNjLS40LTE4Ljk4LTExLjk5LTM1Ljk1LTI5LjUxLTQzLjI1LTQuMDUtMS42OS01Ljk4LTYuMzUtNC4yOS0xMC40LDEuNjktNC4wNiw2LjM1LTUuOTcsMTAuNC00LjI4LDIzLjMzLDkuNzIsMzguNzYsMzIuMzIsMzkuMyw1Ny42bC4xOSw4LjgzYy4wOSw0LjM5LTMuMzksOC4wMy03Ljc4LDguMTItLjA2LDAtLjEyLDAtLjE4LDAiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0yMjguODMsMTc0LjY4Yy4xMyw1Ljg0LDQuOTYsMTAuNDgsMTAuODEsMTAuMzUsNS44NC0uMTIsMTAuNDgtNC45NiwxMC4zNi0xMC44MS0uMTMtNS44NC00Ljk2LTEwLjQ4LTEwLjgxLTEwLjM1LTUuODQuMTItMTAuNDgsNC45Ni0xMC4zNSwxMC44MSIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTIzNy43MiwxNjcuODJoMGMxLjQ3LDEuMjMsMS42NiwzLjQxLjQzLDQuODhsLTYuNjgsNy45NmMtMS4yMywxLjQ3LTMuNDEsMS42Ni00Ljg4LjQzLTEuNDctMS4yMy0xLjY2LTMuNDEtLjQzLTQuODhsNi42OC03Ljk2YzEuMjMtMS40NywzLjQxLTEuNjYsNC44OC0uNDMiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik05MC42OSwyNTMuOTZjLTQuMzMsMC04LjAzLTMuMzEtOC40Mi03LjcxLS40Mi00LjY2LDMuMDItOC43Nyw3LjY4LTkuMTlsNy4xNC0uNjRjLTIuMjUtMTYuMjEtLjU5LTMyLjcxLDQuOS00OC4yNWwuODItMi4zMWMxLjU2LTQuNDEsNi40LTYuNzIsMTAuOC01LjE2LDQuNDEsMS41Niw2LjcyLDYuNCw1LjE2LDEwLjgxbC0uODIsMi4zMWMtNS40OSwxNS41NC02LjM5LDMyLjIzLTIuNiw0OC4yNy41NiwyLjM5LjA3LDQuOTEtMS4zNyw2LjktMS40NCwxLjk5LTMuNjcsMy4yNi02LjExLDMuNDhsLTE2LjQxLDEuNDdjLS4yNS4wMi0uNTEuMDMtLjc2LjAzIi8+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNMjA0LjA1LDI1My45NmMtLjI1LDAtLjUxLDAtLjc2LS4wM2wtMTYuNDEtMS40N2MtMi40NS0uMjItNC42OC0xLjQ5LTYuMTItMy40OC0xLjQzLTEuOTktMS45My00LjUxLTEuMzctNi45LDMuNzktMTYuMDQsMi44OS0zMi43My0yLjYtNDguMjdsLS44MS0yLjMxYy0xLjU2LTQuNDEuNzUtOS4yNSw1LjE2LTEwLjgxLDQuNC0xLjU2LDkuMjUuNzUsMTAuOCw1LjE2bC44MiwyLjMxYzUuNSwxNS41NSw3LjE1LDMyLjA1LDQuOTEsNDguMjZsNy4xMy42NGM0LjY2LjQyLDguMSw0LjUzLDcuNjgsOS4xOS0uNCw0LjQtNC4wOSw3LjcxLTguNDIsNy43MSIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTE0Ny4zNywzNy43MmM0MS44NiwwLDc1Ljc5LDMzLjkzLDc1Ljc5LDc1Ljc5cy0zMy45Myw3NS43OS03NS43OSw3NS43OS03NS43OS0zMy45My03NS43OS03NS43OSwzMy45My03NS43OSw3NS43OS03NS43OSIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTcxLjU4LDExNS4zMWgxNTEuNThjMCwxMC4xNy0xLjQ1LDIwLjI0LTQuMjgsMjkuOTEtNC4xOCwxNC4zMS0xMi4zOSwyNy4xMi0yMy4yNSwzNy4zM2wtNDEuNTMsMzkuMDJjLTMuNzgsMy41NS05LjY3LDMuNTUtMTMuNDUsMGwtNDEuNTMtMzkuMDJjLTEwLjg3LTEwLjIxLTE5LjA4LTIzLjAyLTIzLjI1LTM3LjMzLTIuODItOS42Ny00LjI4LTE5Ljc0LTQuMjgtMjkuOTEiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0xNDcuMzcsNjYuNDRjMjUuOTksMCw0Ny4wNiwyMS4wNyw0Ny4wNiw0Ny4wNnMtMjEuMDcsNDcuMDYtNDcuMDYsNDcuMDYtNDcuMDYtMjEuMDctNDcuMDYtNDcuMDYsMjEuMDctNDcuMDYsNDcuMDYtNDcuMDYiLz48cGF0aCBjbGFzcz0iY2xzLTQiIGQ9Ik0xNDcuODIsMTUwLjk4Yy0xOS4zMSwwLTM1LjAyLTE1LjcxLTM1LjAyLTM1LjAyLDAtMi41MSwyLjA0LTQuNTUsNC41NS00LjU1czQuNTUsMi4wMyw0LjU1LDQuNTVjMCwxNC4zLDExLjYzLDI1LjkyLDI1LjkyLDI1LjkyczI1LjkyLTExLjYzLDI1LjkyLTI1LjkyYzAtMi41MSwyLjA0LTQuNTUsNC41NS00LjU1czQuNTUsMi4wMyw0LjU1LDQuNTVjMCwxOS4zMS0xNS43MSwzNS4wMi0zNS4wMiwzNS4wMiIvPjxwYXRoIGNsYXNzPSJjbHMtNCIgZD0iTTE2OS42OCw5Mi40YzAtMy44My0zLjEtNi45My02LjkzLTYuOTNzLTYuOTMsMy4xLTYuOTMsNi45MywzLjEsNi45Myw2LjkzLDYuOTMsNi45My0zLjEsNi45My02LjkzIi8+PHBhdGggY2xhc3M9ImNscy00IiBkPSJNMTM3LjcxLDkyLjRjMC0zLjgzLTMuMS02LjkzLTYuOTMtNi45M3MtNi45MywzLjEtNi45Myw2LjkzLDMuMSw2LjkzLDYuOTMsNi45Myw2LjkzLTMuMSw2LjkzLTYuOTMiLz48L2c+PHJlY3QgY2xhc3M9ImNscy0xIiB3aWR0aD0iMjg5LjA3IiBoZWlnaHQ9IjI4OS4wNyIvPjwvZz48L3N2Zz4=", 
         "CFDI" => "Factura", 
         "OpcionDecimales" => "1", 
         "NumeroDecimales" => "2", 
         "TipoCFDI" => "Ingreso", 
         "EnviaEmail" => true, 
         "ReceptorEmail" => $data['email'], 
         "ReceptorCC" => "", 
         "ReceptorCCO" => "", 
         "EmailMensaje" => $emailMensaje
        ], 
        "Encabezado" => [
            "CFDIsRelacionados" => "", 
            "TipoRelacion" => "00", 
            "Emisor" => [
               "RFC" => $data['rfcEmisor'], 
               "NombreRazonSocial" => $data['razon_social'], 
               "RegimenFiscal" => $data['regimen_fiscal'], 
               "Direccion" => array($this->direccion($data, self::REMITENTE))
            ], 
            "Receptor" => [
                "RFC" => $data['rfcReceptor'], 
                "NombreRazonSocial" => $data['razon_social_d'], 
                "UsoCFDI" => $data['uso_cfdi'], 
                "DomicilioFiscalReceptor" => $data['cp_d'], 
                "RegimenFiscal" => $data['regimen_fiscal_d'], 
                "Direccion" => $this->direccion($data, self::DESTINATARIO)
             ], 
            "Fecha" => $fecha, 
            "Serie" => "OK-", 
            "Folio" => $data['referencia'], 
            "MetodoPago" => "PUE", 
            "FormaPago" => "03", 
            "Moneda" => "MXN", 
            "LugarExpedicion" => $data['cp'], 
            "SubTotal" => $data['costo_base'], 
            "Total" => $data['precio'],
        ], 
        "Conceptos" => [
            [
                "Cantidad" => "1", 
                "CodigoUnidad" => "E48", 
                "Unidad" => "Servicio", 
                "CodigoProducto" => "80141706", 
                "Producto" => "Servicio de intermediación de productos", 
                "PrecioUnitario" => $data['costo_base'], 
                "Importe" => $data['costo_base'], 
                "ObjetoDeImpuesto" => "02", 
                "Impuestos" => [
                    [
                        "TipoImpuesto" => "1", 
                        "Impuesto" => "2", 
                        "Factor" => "1", 
                        "Base" => $data['costo_base'], 
                        "Tasa" => "0.160000", 
                        "ImpuestoImporte" => $data['costo_iva']
                    ] 
                ] 
            ] 
        ] 
        ]; //fin dataParseado 

    	Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
    	$this->data=$dataParseado;
    }


    /**
     * Persea la direccions Destino y Remitente
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Dto\Guias
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion direccion
     * 
     * @throws \LogicException
     *
     * @param array $data Array con los datos de creacion de la guia
     * @param string $tipo Indicador para saber que 'key' usar del arreglao data
     * 
     * @var array $dataParseado Array que contendra la estructura del body  
     * 
     * 
     * @return array
     */

    private function direccion($data, $tipo){
        Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($data,true));
        $direccion = array();
        
        $comodinKey = "";
        if ($tipo === self::DESTINATARIO) {
            $comodinKey = "_d";
        } 

        $calle = $data['calle'.$comodinKey];
        $noExt = $data['no_exterior'.$comodinKey];
        $noInt = $data['no_interior'.$comodinKey];
        $colonia = $data['colonia'.$comodinKey]; 
        $localidad = $data['municipio_alcaldia'.$comodinKey]; 
        $municipio = $data['municipio_alcaldia'.$comodinKey]; 
        $estado = $data['estado'.$comodinKey]; 
        $cp = $data['cp'.$comodinKey];

        $direccion = [
            "Calle" => $calle, 
            "NumeroExterior" => $noExt, 
            "NumeroInterior" => $noInt, 
            "Colonia" => $colonia, 
            "Localidad" => $municipio, 
            "Municipio" => $municipio, 
            "Estado" => $estado, 
            "Pais" => "Mexico", 
            "CodigoPostal" => $cp 
        ];
        


        Log::info(__CLASS__." ".__FUNCTION__." ".__LINE__);
        return $direccion;
    }


    /**
     * Funciona para obtener los datos a facturar
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Finanzas
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion obtenerDatosCSF
     * 
     * @throws \LogicException
     *
     * @param array $data Valores de toda la peticion de crear guia
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var App\Models\Empresa $empresa  
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    private function obtenerDatosCSF($data){
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        $empresa= null;
        $empresa = Empresa::base()
            ->where("empresas.id", auth()->user()->empresa_id)
            ->get()
            ;

        //dd( count($empresa));
        if ( !(bool)count($empresa)) {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            throw ValidationException::withMessages(array("No se cuenta con Datos Fiscales"));   
        }

        $data['rfcReceptor']= $empresa->first()->rfc;
        $data['razon_social_d']= $empresa->first()->razon_social;
        $data['uso_cfdi'] = $empresa->first()->uso_cfdi;
        $data['regimen_fiscal_d']= $empresa->first()->regimen_fiscal;
        $data['cp_d']=$empresa->first()->cp; 
        $data['calle_d'] = $empresa->first()->calle;
        $data['no_exterior_d'] = $empresa->first()->no_exterior;
        $data['no_interior_d'] =$empresa->first()->no_interior;
        $data['colonia_d']=$empresa->first()->colonia; 
        $data['municipio_alcaldia_d']=$empresa->first()->municipio_alcaldia; 
        $data['estado_d']=$empresa->first()->estado; 
        
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        $this->data=$data;
    }


    /**
     * Funciona para obtener los datos a facturar
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Finanzas
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion obtenerDatosCSF
     * 
     * @throws \LogicException
     *
     * @param array $data Valores de toda la peticion de crear guia
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var App\Models\Empresa $empresa  
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    private function obtenerCostoRecarga($data){
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        $mpPreference = MpPreference::where("id_preference", $data['id_preference'])
            ->get()
            ;

        if ( !(bool)count($mpPreference)) {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $mensaje = sprintf("La preferencia '%s', es invalida.",$data['id_preference'] );
            throw ValidationException::withMessages(array($mensaje));
            
        }
        
        
        $data['costo_base']= $mpPreference->first()->costo;
        $data['costo_iva']= $mpPreference->first()->costo_iva; 
        $data['precio']= $mpPreference->first()->unit_price; 
        
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        $this->data=$data;
    }


    /**
     * Funciona para obtener los datos del CSD
     * 
     * @author Javier Hernandez
     * @copyright 2024 EnviosOK
     * @package App\Negocio\Finanzas
     * @api
     * 
     * @version 1.0.0
     * 
     * @since 1.0.0 Primera version de la funcion obtenerCertificado
     * 
     * @throws \LogicException
     *
     * @param array $data Valores de toda la peticion 
     * 
     * @var string $uri La uri que se usara para obtener el token
     * @var App\Models\CertificadoFiscal $mCertificadoFiscal  
     * 
     * 
     * @return json Objeto con la respuesta de exito o fallo 
     */

    private function obtenerCertificado($data){
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);

        $mCertificadoFiscal = mCertificadoFiscal::get()
            ;

        if ( !(bool)count($mCertificadoFiscal)) {
            Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $mensaje = sprintf("Favor de validar el Certificado Fiscal.");
            throw ValidationException::withMessages(array($mensaje));
            
        }
        
        
        $data['csd']= $mCertificadoFiscal->first()->csd;

        $data['llave_privada']= $mCertificadoFiscal->first()->llave_privada; 
        
        $data['csd_password']= $mCertificadoFiscal->first()->csd_password; 
        
        
        Log::info($this->numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        $this->data=$data;
    }



    public function getData(){
        return $this->data;
    }


}