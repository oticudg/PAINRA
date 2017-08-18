<?php namespace Controllers;

date_default_timezone_set("America/La_Paz");
use Models\CPrincipales as CPrincipales;
use Models\Estadisticas as Estadisticas;
use Config\MED as MED;

/**
* Metodos para los procedimientos ajax
*/
class AjaxController
{
	private $cp;
	private $es;

	function __construct()
	{
		$this->cp = new CPrincipales;
		$this->es = new Estadisticas;
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
								$_SESSION['usuario']	= $resultado[0]['usuario'];
								$_SESSION['cedula']		= $resultado[0]['cedula'];
								$_SESSION['validar']	= TRUE;
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
				if ($_SESSION['rol'] == 1) {
					$soportistas = $this->cp->soportistas()->see();
				} elseif ($_SESSION['rol'] == 2) {
					$soportistas = $this->cp->soportistas(3, $_SESSION['id_coordinacion'])->see();
				}
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
				echo $this->cp->confirmDelete('users', MED::d($_REQUEST['num']))->save();
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
				$resultado = $this->cp->select('user_coordinacion', array(array('id_user',$iduser), array('id_coordinacion',$_REQUEST['coordinacion'])), 0)->see();
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
				$resultado = $this->cp->delete('user_coordinacion', $_REQUEST['id'])->save();
				echo json_encode($resultado);
			}
		}
	}

	public function paginacion($var = 0)
	{
		if ($_REQUEST['operation'] == 'paginacion') {
			if ($_REQUEST['token'] == 10 && $_SESSION['validar'] == TRUE) {
				require_once 'Views/modulos/'.$_REQUEST['modulo'].'.php';	
			}
		}
	}

	public function barrasEstadisticas()
	{
		if ($_REQUEST['token'] == 11) {
			$resultado = $this->es->barrasEstadisticas()->see();
			echo json_encode($resultado);
		}
	}

	public function buscarDepartamento()
	{
		if ($_REQUEST['operation'] == 'departamentos') {
			echo '<option value="">Seleccione una opción</option>';
			if ($_REQUEST['token'] == 12) {
				$resultado = $this->cp->select('direccion')->see();
				foreach ($resultado as $r) {
					echo '<option value="'.$r['id'].'">'.$r['opcion'].'</option>';
				}
			}
			if ($_REQUEST['token'] == 13) {
				$resultado = $this->cp->select('division', array(array('relacion', $_REQUEST['num'])))->see();
				foreach ($resultado as $r) {
					echo '<option value="'.$r['id'].'">'.$r['opcion'].'</option>';
				}
			}
			if ($_REQUEST['token'] == 16) {
				$resultado = $this->cp->select('direccion')->see();
				foreach ($resultado as $r) {
					echo '<option ren="'.$r['id'].'" value="'.$r['opcion'].'"></option>';
				}
			}
		}
	}

	public function deleteDepartamento()
	{
		if ($_REQUEST['token'] == 14) {
			echo $this->cp->confirmDelete('division', $_REQUEST['num'])->save();
		}
	}

	public function registrarDepartamento()
	{
		if ($_REQUEST['token'] == 15) {
			$this->cp->add_editDireccion($_REQUEST['direccion'],
										$_REQUEST['id_direccion'])->save();
			if (isset($_REQUEST['division']) && $_REQUEST['id_direccion'] != -1) {
				$this->cp->add_editDivision($_REQUEST['division'],
										$_REQUEST['id_direccion'],
										$_REQUEST['id_division'])->save();
			}
			echo(1);
		}
	}

	public function buscarSolicitudes()
	{
		echo '<option>Seleccione una opción</option>';
		if ($_REQUEST['operation'] == 'solicitudes') {
			if ($_REQUEST['token'] == 16) {
				$resultado = $this->cp->select('categoria')->see();
			} elseif ($_REQUEST['token'] == 17) {
				$resultado = $this->cp->select('problema_i', array(array('relacion', $_REQUEST['num'])))->see();
			} elseif ($_REQUEST['token'] == 18) {
				$resultado = $this->cp->select('problema_ii', array(array('relacion', $_REQUEST['num'])))->see();
			}
			foreach ($resultado as $r) {
				echo '<option value="'.$r['id'].'">'.$r['opcion'].'</option>';
			}
		}
		if ($_REQUEST['operation'] == 'solicitudesRegistro') {
			if ($_REQUEST['token'] == 19) {
				$resultado = $this->cp->select('categoria')->see();
			} elseif ($_REQUEST['token'] == 21) {
				$resultado = $this->cp->select('problema_i', array(array('relacion', $_REQUEST['num'])))->see();
			}
			foreach ($resultado as $r) {
				echo '<option value="'.$r['opcion'].'">'.$r['id'].'</option>';
			}
		}
	}

	public function deleteServicio()
	{
		if ($_REQUEST['token'] == 19) {
			echo $this->cp->confirmDelete('problema_ii', $_REQUEST['num'])->save();
		}
	}

	public function registroServicios()
	{
		if ($_REQUEST['token'] == 22) {
			$this->cp->add_editCategoria($_REQUEST['categoria'], $_REQUEST['idcategoria'])->save();
			if ($_REQUEST['idcategoria'] != -1) {
				$this->cp->add_editProblemas('problema_i', $_REQUEST['problema'], $_REQUEST['idcategoria'], $_REQUEST['idproblema'])->save();
				if ($_REQUEST['idproblema'] != -1) {
					$this->cp->add_editProblemas('problema_ii', $_REQUEST['subproblema'], $_REQUEST['idproblema'], $_REQUEST['idsubproblema'])->save();
				}
			}
			echo(1);
		}
	}

	public function ticketsAbiertos()
	{
		$open = $this->es->mTickets("Abierto")->see();
		$htmlA = '<div class="col-xs-12">';
		if ($open != array()) {
			$htmlA = '<ol class="listaTickets">';
			foreach ($open as $o) {
				$htmlA .= '<li> <b><a href="#" ren="'.$o['id'].'" id="abrirTicket">N° '.$o['id'].'</a></b><br>Fecha: '.$o['fecha_apertura'].'<br>Asignado: '.$o['soportista'].'</li>';
			}
			$htmlA .= '</ol>';
		}
		$htmlA .= '</div>';

		$process = $this->es->mTickets("En proceso")->see();
		$htmlE = '<div class="col-xs-12">';
		if ($process != array()) {
			$htmlE .= '<ol class="listaTickets">';
			foreach ($process as $p) {
				$htmlE .= '<li> <b><a href="#" ren="'.$p['id'].'" id="abrirTicket">N° '.$p['id'].'</a></b><br>Fecha: '.$p['fecha_apertura'].'<br>Asignado: '.$p['soportista'].'</li>';
			}
			$htmlE .= '</ol>';
		}
		$htmlE .= '</div>';
		
		$datos = array('abiertos' => $htmlA, 'enproceso' => $htmlE);
		echo json_encode($datos);
	}

	public function __destruct()
	{
		$this->cp = NULL;
		$this->es = NULL;
	}
} /*Fin de la clase AjaxController*/
