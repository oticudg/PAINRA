<?php namespace Controllers;

use models\CPrincipales as CPrincipales;

/**
* Metodos de controladores de inicio
*/
class InicioController
{
	private $cp;

	function __construct()
	{
		if (!isset($_SESSION['validar'])) { header('Location: '.URL); exit(); }
		$this->cp = new CPrincipales;
	}

	public function index()
	{
		if($_SESSION['rol'] == 2) {

		}elseif ($_SESSION['rol'] == 3) {

		} else {

		}
	}

	public function inicio()
	{

	}
} /*Fin de la clase InicioController*/
