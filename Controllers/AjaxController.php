<?php namespace Controllers;

date_default_timezone_set("America/La_Paz");
use models\CPrincipales as CPrincipales;
use Config\MED as MED;

/**
* Metodos para los procedimientos ajax
*/
class AjaxController
{
	private $cp;

	function __construct()
	{
		$this->cp = new CPrincipales;
	}

	public function index(){}

	public function login()
	{
		if ($_REQUEST['operation'] == 'login') {
			if ($_REQUEST['token'] == 1) {
				if (isset($_REQUEST['usuario']) && isset($_REQUEST['clave'])) {
					if( !empty($_REQUEST['usuario']) || !empty($_REQUEST['clave']) ){
						$resultado = $this->cp->login($_REQUEST['usuario'])->see();
						if (count($resultado) > 0) {
							if ($resultado[0]['pass'] === MED::e($_REQUEST['clave'])) {
								$_SESSION['validar']	= TRUE;
								$_SESSION['usuario']	= $resultado[0]['usuario'];
								$_SESSION['nombre']		= $resultado[0]['nombre'];
								$_SESSION['privilegio']	= $resultado[0]['privilegio'];
								$_SESSION['cedula']		= $resultado[0]['cedula'];
								$_SESSION['id']			= $resultado[0]['id'];
								$_SESSION['id_coordinacion'] = $resultado[0]['id_coordinacion'];
								$_SESSION['coordinacion'] = $resultado[0]['coordinacion'];
								$_SESSION['coordinacionopc'] = (isset($resultado[1]['coordinacion'])) ? $resultado[1]['coordinacion'] : NULL;
								$_SESSION['id_coordinacionnopc'] = (isset($resultado[1]['id_coordinacion'])) ? $resultado[1]['id_coordinacion'] : NULL;
								echo true;
							}
						}
					}
				}
			}
		}
	}

	public function paginacion() {}

	public function logout()
	{
		if ($_REQUEST['operation'] == 'logout') {
			if ($_REQUEST['token'] == 2) {
				$_SESSION = array();
				setcookie( session_name(), '', time() - 56000 );
				session_destroy();
				header('location:'.URL);
				echo 1;
				exit();
			}
		}
	}

	public function __destruct()
	{
		$this->cp = NULL;
	}
} /*Fin de la clase AjaxController*/
