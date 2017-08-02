<?php namespace Config;
class Route {
	public static function css($string)
	{
		echo URL.'Views/otros/css/'.$string.'.css';
	}
	public static function js($string)
	{
		echo URL.'Views/otros/js/'.$string.'.js';
	}
} /* Fin de la clase Route */
