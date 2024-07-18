<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PacServicio;

class PacServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PacServicio::create([
            'descripcion' => 'Servicio de token ',
            'tipo' => '1',
            'uri' => 'https://testapi.facturoporti.com.mx/token/crear',
            'usuario'  =>  'pruebastimbrado',
            'password' => '@Notiene1',
            'token' => 'token'
        ]);

        PacServicio::create([
            'descripcion' => 'Servicio para solicitar una factura ',
            'tipo' => '2',
            'uri' => 'https://testapi.facturoporti.com.mx/servicios/timbrar/json',
            'usuario'  =>  'usuario',
            'password' => 'password',
            'token' => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoialYrdVVUYmtWNmUxRmNZb2cvNWtGQT09IiwibmJmIjoxNzE3ODI0NDc0LCJleHAiOjE3MjA0MTY0NzQsImlzcyI6IlNjYWZhbmRyYVNlcnZpY2lvcyIsImF1ZCI6IlNjYWZhbmRyYSBTZXJ2aWNpb3MiLCJJZEVtcHJlc2EiOiJqVit1VVRia1Y2ZTFGY1lvZy81a0ZBPT0iLCJJZFVzdWFyaW8iOiJidXlaYzFMWUl5VURaSGhGR3NqaGdRPT0ifQ.6eIztG2aRxClGTjLRo5dtGUysL3xekESJLnp0WEth4U'
            
        ]);
    }
}
