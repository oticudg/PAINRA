<?php namespace Controllers;

date_default_timezone_set("America/La_Paz");
use Models\CPrincipales as CPrincipales;
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
					if( !empty($_REQUEST['usuario']) || !empty($_REQUEST['clave']) ) {
						$resultado = $this->cp->users(0,0,$_REQUEST['usuario'],0,$_REQUEST['usuario'])->see();
						if (count($resultado) > 0) {
							if ($resultado[0]['pass'] === MED::e($_REQUEST['clave'])) {
								$_SESSION['validar']	= TRUE;
								// $_SESSION['usuario']	= $resultado[0]['usuario'];
								// $_SESSION['cedula']		= $resultado[0]['cedula'];
								$_SESSION['id']			= $resultado[0]['id'];
								$_SESSION['nombre']		= $resultado[0]['nombre'];
								$_SESSION['rol']	= $resultado[0]['rol'];
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

	public function cambioPass()
	{
		if ($_REQUEST['operation'] == 'cambioPass') {
			if ($_REQUEST['token'] == 3) {
				if (isset($_REQUEST['newpass']) && isset($_REQUEST['confirmacion'])) {
					if( !empty($_REQUEST['newpass']) || !empty($_REQUEST['confirmacion']) ){
						if ($_REQUEST['newpass'] === $_REQUEST['confirmacion']) {
							echo $this->cp->cambioPass($_SESSION['id'], MED::e($_REQUEST['newpass']))->save();
						}
					}
				}
			}
		}
	}

	public function soportistas()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'soportistas') {
			if ($_REQUEST['token'] == 4) {
				$soportistas = $this->cp->users()->see();
				$count = 0;
				echo '
				<table class="table table-bordered table-hover table-condensed" id="soportistas">
					<thead>
						<tr>
							<th width="5%">N°</th>
							<th>Nombre</th>
							<th>Cédula</th>
							<th>Coordinación</th>
						</tr>
					</thead>
					<tbody>';
				foreach ($soportistas as $s) {
					echo '
					<tr id="soportista" ren="'.MED::e($s['id']).'" rol="'.$s['rol'].'" '.((isset($s['coordinacion'])) ? 'coord="'.$s['iduc'].'" idcoor="'.$s['id_coordinacion'].'"' : "").'>
						<td>'.++$count.'</td>
						<td>'.$s['nombre'].'</td>
						<td>'.$s['cedula'].'</td>
						<td class="'.(($s['coordinacion'] == '' && ($s['rol'] == 3 || $s['rol'] == 2)) ? 'bg-danger' : '').'">'.$s['coordinacion'].'</td>
					</tr>';
				}
				echo '
				<tbody>
				</table>';
			}
		}
	}

	public function verEditU()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'verU') {
			if ($_REQUEST['token'] == 5) {
				$user = $this->cp->users(MED::d($_REQUEST['num']))->see();
				echo json_encode($user);
			}
		}
	}

	public function confirmDeleteUser()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'confirmDeleteUser') {
			if ($_REQUEST['token'] == 6) {
				echo $this->cp->confirmDeleteUser(MED::d($_REQUEST['num']))->save();
			}
		}
	}

	public function soportistasRegistrar()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'soportistasRegistrar') {
			if ($_REQUEST['token'] == 7) {
				$users = array();
				if ($_REQUEST['id'] == -1) {
					$users = $this->cp->users(0, 0, $_REQUEST['usuario'], $_REQUEST['cedula'], $_REQUEST['email'])->see();
				}
				if (count($users) > 0) {
					$resultado = false;
				} else {
					$rol = ($_SESSION['rol'] == 1) ? $_REQUEST['rol'] : 3;
					$pass = ($_REQUEST['id'] == -1) ? MED::e($_REQUEST['cedula']) : '';
					$resultado = $this->cp->add_editUser(
						$_REQUEST['usuario'],
						$_REQUEST['nombre'],
						$_REQUEST['cedula'],
						$_REQUEST['email'],
						$rol,
						$pass,
						$_REQUEST['id']
						)->save();
				}
				echo json_encode($resultado);
			}
		}
	}

	public function coordinacionRegistrar()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'coordinacionRegistrar') {
			if ($_REQUEST['token'] == 8) {
				$iduser = MED::d($_REQUEST['iduser']);
				$resultado = $this->cp->select('user_coordinacion', array(array('id_user',$iduser), array('id_coordinacion',$_REQUEST['coordinacion'])))->see();
				if (count($resultado) > 0) {
					echo 0;
				} else {
					echo $this->cp->addUserCoordinacion($iduser, $_REQUEST['coordinacion'], $_REQUEST['tipo'])->save();
				}
			}
		}
	}

	public function deleteUserCoordinacion()
	{
		if (isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'deleteUserCoordinacion') {
			if ($_REQUEST['token'] == 9) {
				$resultado = $this->cp->deleteUserCoordinacion($_REQUEST['id'])->save();
				echo json_encode($resultado);
			}
		}
	}





	public function __destruct()
	{
		$this->cp = NULL;
	}
} /*Fin de la clase AjaxController*/
