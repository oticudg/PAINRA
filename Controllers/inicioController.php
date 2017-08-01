<?php namespace Controllers;
/**
* Metodos de controladores de inicio
*/
class InicioController
{
	function __construct()
	{
		if (!isset($_SESSION['validar'])) { header('Location: '.URL); exit(); }
	}

	public function index()
	{
		if ($_SESSION['privilegio'] == 2) {
			$asignado = $_SESSION['coordinacion'];
		} elseif ($_SESSION['privilegio'] == 3) {
			$asignado = $_SESSION['usuario'];
		} else {
			$asignado = 'La OTIC';
		}

		if($_SESSION['privilegio'] == 2 || $_SESSION['privilegio'] == 1) {
		}elseif ($_SESSION['privilegio'] == 3) {
		} else {
		}

		return array('asignado' => $asignado);
	}

	public function inicio()
	{

	}
} /*Fin de la clase InicioController*/
