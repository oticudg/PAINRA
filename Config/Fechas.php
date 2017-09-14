<?php namespace Config;
/**
* Metodos de arreglo de fechas
*/
class Fechas {
	public static function sql($fecha)
	{
		return date('Y-m-d', strtotime($fecha));
	}
	public static function normal($fecha)
	{
		return date('d/m/Y', strtotime($fecha));
	}
} /* Fin de la clase Fechas */