<?php namespace Config;
class Autoload
{
	public static function run()
	{
		spl_autoload_register(function ($class) {
			$ruta = str_replace("\\",'/',$class).'.php';
			if (is_readable($ruta))
				require_once $ruta;
		});
	}
}