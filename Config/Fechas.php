<?php namespace Config;
/**
* Metodos de arreglo de fechas
*/
class Fechas {
	public static function sql($fecha)
	{
		return date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
	}
	public static function normal($fecha)
	{
		return date('d/m/Y', strtotime(str_replace('/', '-', $fecha)));
	}
} /* Fin de la clase Fechas */