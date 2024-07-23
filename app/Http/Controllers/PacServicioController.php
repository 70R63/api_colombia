<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoFiscalRequest;
use App\Http\Requests\UpdateCertificadoFiscalRequest;
use Redirect;

use Log;
use Carbon\Carbon;

use App\Models\CertificadoFiscal;


//NEGOCIO
use App\Negocio\PacServicio as nPacServicio;



class PacServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pacservicio.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pacservicio.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificadoFiscalRequest $request)
    {
        $numeroDeSolicitud = Carbon::now()->timestamp;
        $data = $request->all();
       
        
        $data['calle_d']="calle d";
        $data['no_exterior_d'] = "no_exterior_d";
        $data['no_interior_d'] = "no_interior_d";
        $data['colonia_d'] = "colonia_d ";
        $data['municipio_alcaldia_d'] = "municipio_alcaldia_d";
        $data['estado_d'] = "estado_d";

        $data['encabezado']['numeroDocumento'] = "12345";
        $data['totales']['subtotal'] = 100;
        $data['totales']['total'] = 116;


        $data['detalle'][] = [
            'cantidad' => 1,
            'descripcion'  => "Producto Ejemplo 1" ,
            'precioUnitario'  => 100 ,
            'subtotal'  => 100 ,
            'impuesto'  => 16 ,
        ];


        Log::debug(print_r($data,true));
        

        $nPacServicio = new nPacServicio($numeroDeSolicitud); 
        $nPacServicio->crear($data);

        $success['Solicitud']="Exitosa";
        $success = $nPacServicio->getresponse();
        $success['Solicitud']="Exito";
       // array_push($success, array("Solicitud" =>"Exito"));
        
        Log::info($numeroDeSolicitud." ".__CLASS__." ".__FUNCTION__." ".__LINE__);
        return Redirect::route("pac.index") -> withSuccess ($success);
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificadoFiscal $certificadoFiscal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificadoFiscal $certificadoFiscal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificadoFiscalRequest $request, CertificadoFiscal $certificadoFiscal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificadoFiscal $certificadoFiscal)
    {
        //
    }
}
