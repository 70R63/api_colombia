<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use Redirect;

use App\Http\Requests\StoreConsultasRequest;
use App\Http\Requests\UpdateConsultasRequest;
use App\Models\Consultas;

use App\Negocio\Servicios\Consultas as nConsultas;

use Exception;

class ConsultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("consultas.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultasRequest $request)
    {
        $numeroDeSolicitud = Carbon::now()->timestamp;
        try {
            
            Log::info("$numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);
            $data = $request->all();

            $nConsultas = new nConsultas($numeroDeSolicitud);
            $nConsultas->crearFromWeb($data);

            Log::info("$numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);

            $success['Solicitud']="Exito";
            return Redirect::route("servicios.consultas.index") -> withSuccess ($success);

        } catch (Exception $e) {
           Log::info("$numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__);
           Log::info("$numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".$e->getMessage());
           Log::debug("$numeroDeSolicitud ".__CLASS__." ".__FUNCTION__." ".__LINE__." ".print_r($e,true));
           return Redirect::route("servicios.consultas.index") -> withErrors (["Mensaje" => " Falla Inesplicable"]);
        }   
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultas $consultas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultas $consultas)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultasRequest $request, Consultas $consultas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultas $consultas)
    {
        //
    }
}
