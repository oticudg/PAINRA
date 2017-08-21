<?php namespace Config;
/**
* Metodos de arreglo de fechas
*/
class Fechas {
	public static function fechaSql($fecha)
	{
		$fecha = explode('/', $fecha);
		return $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	}
} /* Fin de la clase Fechas */
