<?php
namespace App\Dto;


class Usuarios {

	public string $tipoDocumentoldentificacion;
	public $numDocumentoldentificacion;
	public $tipoUsuario;
    public $fechaNacimiento;
    public $codSexo;
    public $codPaisResidencia;
    public $codMunicipioResidencia;
    public $codZonaTerritorialResidencia;
    public $incapacidad;
    public $consecutivo;
    public array|object $serivicios;

}