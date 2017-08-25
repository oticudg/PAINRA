<?php namespace Controllers;

date_default_timezone_set("America/La_Paz");
use Models\CPrincipales as CPrincipales;
use Models\Estadisticas as Estadisticas;
use Config\MED as MED;
use Config\Fechas as Fechas;

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
			$resultado = $this->es->barrasEstadisticas($_SESSION['rol'])->see();
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
			if ($_REQUEST['num'] == 1) {
				echo $this->cp->confirmDelete('categoria', $_REQUEST['ren'])->save();
			} elseif ($_REQUEST['num'] == 2) {
				echo $this->cp->confirmDelete('problema_i', $_REQUEST['ren'])->save();
			} elseif ($_REQUEST['num'] == 3) {
				echo $this->cp->confirmDelete('problema_ii', $_REQUEST['ren'])->save();
			}
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
		$open = $this->es->mTickets("Abierto", $_SESSION['rol'])->see();
		$htmlA = '<div class="col-xs-12">';
		if ($open != array()) {
			$htmlA = '<ol class="listaTickets">';
			foreach ($open as $o) {
				$htmlA .= '<li> <b><a href="#" ren="'.$o['id'].'" id="abrirTicket">N° '.$o['id'].'</a></b><br>Fecha: '.$o['fecha_apertura'].'<br>Asignado: '.$o['soportista'].'</li>';
			}
			$htmlA .= '</ol>';
		}
		$htmlA .= '</div>';

		$process = $this->es->mTickets("En proceso", $_SESSION['rol'])->see();
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

	public function graphic_cerrados()
	{
		$resultado = $this->es->ticketsPorSoportistas()->see();
		foreach ($resultado as $r) {
			$nombre[] = $r['nombre'];
			$tickets[] = $r['tickets'];
		}
		$nombre = json_encode($nombre);
		$tickets = str_replace('"', '', json_encode($tickets));
		echo '{"nombre": '.$nombre.',"tickets":'.$tickets.'}';
	}

	public function ticketsdepartamentos()
	{
		$resultado = $this->es->ticketsPorDepartamentos()->see();
		echo json_encode($resultado);
	}

	public function ticketspersonales()
	{
		if ($_REQUEST['fstart'] != '' && $_REQUEST['fend'] != '') {
			$fstart = Fechas::fechaSql($_REQUEST['fstart']);
			$fend = Fechas::fechaSql($_REQUEST['fend']);
		} else {
			$fstart = 0;
			$fend = 0;
		}
		$resultado = $this->es->estatusPersonal($_REQUEST['responsable'], $fstart, $fend)->see();
		$abierto = 0; $proceso = 0; $cerrado = 0;
		foreach ($resultado as $r) {
			switch ($r['id_estatus']) {
				case '1': $abierto = $r['tickets']; break;
				case '2': $proceso = $r['tickets']; break;
				case '3': $cerrado = $r['tickets']; break;
			}
		}
		$totalSolicitudes = $abierto+$proceso+$cerrado;
		$efectividad = ( $totalSolicitudes > 0  ) ? (($cerrado * 100) / $totalSolicitudes) : 0 ;
		echo json_encode(array('Abierto' => $abierto,
			'Proceso' => $proceso,
			'Cerrado' => $cerrado,
			'Total' => $totalSolicitudes,
			'Efectividad' => $efectividad,
			'Soportista' => $resultado[0]['nombre']));
	}

	public function usuarios()
	{
		$users = $this->cp->select('users', array(array('rol', 3)), 1)->see();
		$html = '<option value="">Escoja una opción</option>';
		foreach ($users as $u) {
			$html .= '<option value="'.$u['cedula'].'">'.$u['nombre'].'</option>';
		}
		echo json_encode($html);
	}

	public function ticketsMensuales($año = -1)
	{
		for ($i=2014; $i <= date('Y'); $i++) {
			$resultado[] = $this->es->ticketsMensuales($i)->see();
		}
		echo json_encode($resultado);
	}

	public function tablaEstDepartamentos()
	{
		$h2 = ($_REQUEST['estadistica'] == 'Total') ? 'Estatus de solicitudes según cada Coordinación de la OTIC.' : 'Direcciones '.$_REQUEST['estadistica'].'.';

		$fechaI = (!empty($_REQUEST['fstart'])) ? Fechas::fechaSql($_REQUEST['fstart']) : '2013-01-01';
		$fechaF = (!empty($_REQUEST['fend'])) ? Fechas::fechaSql($_REQUEST['fend']) : '2099-01-01';

		if ($_REQUEST['estadistica'] == 'Administrativas') { 
			$Departamento = 1;
			$ids = array(1, 2, 3, 4, 5, 6, 7, 8);
		}
		elseif ($_REQUEST['estadistica'] == 'Médicas') { 
			$Departamento = 1;
			$ids = array(9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19);
		}
		elseif ($_REQUEST['estadistica'] == 'Total') {
			$Coordinacion = 1;
			$ids = array(1, 2, 3);
		}

		$count = 0; $tticket = 0; $tabierto = 0; $tproceso = 0; $tcerrado = 0;
		foreach ($ids as $d) {
			if (isset($Departamento)) {
				$resultado = $this->es->estatusSimple($d, $fechaI, $fechaF)->see();
			} elseif (isset($Coordinacion)) {
				$resultado = $this->es->estatusCoordinacion($d, $fechaI, $fechaF)->see();
			}
			if ($resultado) {
				$estatus[$count] = self::organizarResulDep($resultado);
				$estatus[$count]['n'] = $count+1;
				$estatus[$count]['Departamento'] = (isset($resultado[0]['departamento'])) ? $resultado[0]['departamento'] : $resultado[0]['coordinacion'];
				$tticket += $estatus[$count]['Total'];
				$tabierto += $estatus[$count]['Abierto'];
				$tproceso += $estatus[$count]['En proceso'];
				$tcerrado += $estatus[$count]['Cerrado'];
				$count++;
			}
		}
		if ($resultado) {
			foreach ($estatus as $g) {
				$coordinacion[] = (isset($g['coordinacion'])) ? $g['coordinacion'] : $g['Departamento'];
				$total[] = $g['Total'];
			}
			$tbody = '';
			foreach ($estatus as $e) {
				$tbody .= '<tr>
					<td>'.$e['n'].'</td>
					<td>'.$e['Departamento'].'</td>
					<td>'.$e['Cerrado'].'</td>
					<td>'.$e['En proceso'].'</td>
					<td>'.$e['Abierto'].'</td>
					<td>'.$e['Total'].'</td>
					<td>'.(($e['Total'] == 0 ) ? '0,00' : number_format(($e['Cerrado']*100/$e['Total']),2,',','')).'</td>
				</tr>';
			}
			$tfoot = '<td>O</td>
				<td>Sub - Total</td>
				<td>'.$tcerrado.'</td>
				<td>'.$tproceso.'</td>
				<td>'.$tabierto.'</td>
				<td>'.$tticket.'</td>
				<td>'.(($tticket == 0 ) ? '0,00' : number_format(($tcerrado*100/$tticket),2,',','')).'</td>';
			echo json_encode(array('h2' => $h2, 'tbody' => $tbody, 'tfoot' => $tfoot, 'grafica' => array('coordinacion' => $coordinacion, 'total' => $total)));
		} else {
			echo json_encode(array('h2' => 'No Existen tickets registrados.'));
		}
	}

	public static function organizarResulDep($resultado)
	{
		$abierto = 0; $proceso = 0; $cerrado = 0;
		foreach ($resultado as $r) {
			switch ($r['descripcion']) {
				case 'Abierto': $abierto = $r['tickets']; break;
				case 'En proceso': $proceso = $r['tickets']; break;
				case 'Cerrado': $cerrado = $r['tickets']; break;
			}
		}
		return array('Abierto' => $abierto, 
					'En proceso' => $proceso, 
					'Cerrado' => $cerrado, 
					'Total' => ($abierto + $proceso + $cerrado)
					);
	}

	public function departamentos()
	{
	}

	public function __destruct()
	{
		$this->cp = NULL;
		$this->es = NULL;
	}
} /*Fin de la clase AjaxController*/
