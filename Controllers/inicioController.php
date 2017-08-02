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
		if ($_SESSION['rol'] == 2) {
			$asignado = $_SESSION['coordinacion'];
		} elseif ($_SESSION['rol'] == 3) {
			$asignado = $_SESSION['usuario'];
		} else {
			$asignado = 'La OTIC';
		}
// (new CPrincipales)->barrasEstadisticas();
		$this->cp->barrasEstadisticas();

		if($_SESSION['rol'] == 2) {

		}elseif ($_SESSION['rol'] == 3) {

		} else {

		}

		return array('asignado' => $asignado);
	}

	public function inicio()
	{

	}
} /*Fin de la clase InicioController*/
