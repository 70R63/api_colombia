<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePacServicioRequest;
use App\Http\Requests\UpdatePacServicioRequest;
use App\Models\PacServicio;

use Log;
use Carbon\Carbon;

use App\Negocio\PacServicio as nPacServicio;

class PacServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('pacservicio.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pacservicio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacServicioRequest $request)
    {
        try {
            $numeroDeSolicitud = Carbon::now()->timestamp;
            $data = $request->all();
           
            $data['email']="javierv31@gmail.com";
            $data['calle_d']="calle d";
            $data['no_exterior_d'] = "no_exterior_d";
            $data['no_interior_d'] = "no_interior_d";
            $data['colonia_d'] = "colonia_d ";
            $data['municipio_alcaldia_d'] = "municipio_alcaldia_d";
            $data['estado_d'] = "estado_d";
            $data['referencia'] = "folio";
            $data['costo_base'] = "100";
            $data['costo_iva'] = "16";
            $data['precio'] = "116";

            $nPacServicio = new nPacServicio($numeroDeSolicitud); 
            $nPacServicio->crear($data);
            dd(true);
        } catch (Exception $e) {
            return Redirect::back()
                ->withErrors($nPacServicio->getMensajes())
                ->withInput();
            
        }
        
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
