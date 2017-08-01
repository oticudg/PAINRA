<?php namespace Config;
class Route {
	public static function css($string)
	{
		return URL.'Views/resource/css/'.$string.'.';
	}
	public static function _css($string)
	{
		return URL.'Views/resource/css/'.$string.'.';
	}
	public static function js($string)
	{
		return URL.'Views/resource/js/'.$string.'.';
	}
	public static function _js($string)
	{
		return URL.'Views/resource/js/'.$string.'.';
	}
} /* Fin de la clase Route */
