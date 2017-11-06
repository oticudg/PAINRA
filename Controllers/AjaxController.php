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
							if ($resultado[0]['pass'] === md5(MED::e($_REQUEST['clave']))) {
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
							echo $this->cp->cambioPass($_SESSION['id'], md5(MED::e($_REQUEST['newpass'])))->save();
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
					if ($_REQUEST['id'] == -1) {
						$pass = md5(MED::e($_REQUEST['cedula']));
					} elseif ($_REQUEST['id'] > 0 && !empty($_REQUEST['pass'])) {
						$pass = md5(MED::e($_REQUEST['pass']));
					} else {
						$pass = '';
					}
					$resultado = $this->cp->add_editUser(
						$_REQUEST['usuario'],
						$_REQUEST['nombre'],
						$_REQUEST['cedula'],
						$_REQUEST['email'],
						$rol,
						$pass,
						$_REQUEST['id']
					)->save();
					if ($_SESSION['rol'] == 2 && $_REQUEST['id'] == -1) {
						$user = $this->cp->users(0, 0, $_REQUEST['usuario'])->see();
						$this->coordinacionRegistrar($user[0]['id'], $_SESSION['id_coordinacion']);
						return;
					}
				}
				echo json_encode($resultado);
			}
		}
	}

	public function coordinacionRegistrar($id = '', $coordinacion = '')
	{
		$iduser = ($id === '') ? MED::d($_REQUEST['iduser']) : $id;
		$add_edit = ($id === '') ? $_REQUEST['tipo'] : -1;
		$coordinacion = ($coordinacion === '') ? $_REQUEST['coordinacion'] : $coordinacion;
		$resultado = $this->cp->select('user_coordinacion', array(array('id_user',$iduser), array('id_coordinacion',$coordinacion)), 0)->see();
		if (count($resultado) > 0) {
			echo 0;
		} else {
			echo $this->cp->addUserCoordinacion($iduser, $coordinacion, $add_edit)->save();
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

	public function paginacion()
	{
		if ($_REQUEST['operation'] == 'paginacion') {
			if ($_SESSION['validar'] == TRUE) {
				if (empty($_REQUEST['modulo'])) {
					if (isset($_SESSION['pagina'])) {
						$modulo = $_SESSION['pagina'];
					} else {
						$modulo = 'inicio';
					}
				} else {
					$modulo = $_REQUEST['modulo'];
				}
				require_once 'Views/Modulos/'.$modulo.'.php';
				$_SESSION['pagina'] = $modulo;
			}
		}
	}

	public function pagina()
	{
		if (empty($_REQUEST['modulo'])) {
			if (isset($_SESSION['pagina'])) {
				$modulo = $_SESSION['pagina'];
			} else {
				$modulo = 'inicio';
			}
		} else {
			$modulo = $_REQUEST['modulo'];
		}
		echo json_encode($modulo);
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
			if ($_REQUEST['num'] == 1) {
				echo $this->cp->confirmDelete('direccion', $_REQUEST['id'])->save();
			} elseif ($_REQUEST['num'] == 2) {
				echo $this->cp->confirmDelete('division', $_REQUEST['id'])->save();
			}
		}
	}	

	public function registrarDepartamento()
	{
		if ($_REQUEST['token'] == 15) {
			$this->cp->add_editDireccion($_REQUEST['direccion'], $_REQUEST['id_direccion'])->save();
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
		echo '<option value="" disabled selected>Seleccione una opción</option>';
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
				echo '<option id="'.$r['id'].'" value="'.$r['opcion'].'"></option>';
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
				if ($_REQUEST['idproblema'] != -1 &&  $_REQUEST['subproblema'] !== '') {
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
			$htmlA = '<ul class="listaTickets">';
			foreach ($open as $o) {
				$htmlA .= '<li> <b><a href="#" ren="'.$o['id'].'" id="abrirTicket">N° '.$o['id'].'</a></b><br>Fecha: '.$o['fecha_apertura'].'<br>Asignado: '.$o['soportista'].'</li>';
			}
			$htmlA .= '</ul>';
		}
		$htmlA .= '</div>';

		$process = $this->es->mTickets("En proceso", $_SESSION['rol'])->see();
		$htmlE = '<div class="col-xs-12">';
		if ($process != array()) {
			$htmlE .= '<ul class="listaTickets">';
			foreach ($process as $p) {
				$htmlE .= '<li> <b><a href="#" ren="'.$p['id'].'" id="abrirTicket">N° '.$p['id'].'</a></b><br>Fecha: '.$p['fecha_apertura'].'<br>Asignado: '.$p['soportista'].'</li>';
			}
			$htmlE .= '</ul>';
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
			$fstart = Fechas::sql($_REQUEST['fstart']);
			$fend = Fechas::sql($_REQUEST['fend']);
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
			'Soportista' => (isset($resultado[0]['nombre']) ? $resultado[0]['nombre'] : '')
		));
	}

	public function usuarios()
	{
		$users = $this->cp->select('users', array(array('rol', 3)), 1)->see();
		$html2 = $html = '<option value="" selected>Escoja una opción</option>';
		foreach ($users as $u) {
			$html .= '<option value="'.$u['id'].'">'.$u['nombre'].'</option>';
			$html2 .= '<option value="'.$u['nombre'].'">'.$u['nombre'].'</option>';
		}
		echo json_encode(array('soportistas' => $html, 'colaboradores' => $html2));
	}

	public function responsable()
	{
		if ($_SESSION['rol'] == 2) {
			$rol = 3;
		} else {
			$rol = 2;
		}
		if ($_SESSION['rol'] == 3) {
			$users = $this->cp->users(0, 0, 0, $_SESSION['cedula'])->see();
		} elseif($_SESSION['rol'] == 2) {
			$users = $this->cp->users(0, 0, 0, 0, 0, $_SESSION['id_coordinacion'])->see();
		} else {
			$users = $this->cp->users()->see();
		}
		$html = '<option value="">Seleccione una opción</option>';
		foreach ($users as $u) {
			$html .= '<option value="'.$u['id'].'" coord="'.$u['id_coordinacion'].'">'.$u['nombre'].'</option>';
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

		$fechaI = (!empty($_REQUEST['fstart'])) ? Fechas::Sql($_REQUEST['fstart']) : '2013-01-01';
		$fechaF = (!empty($_REQUEST['fend'])) ? Fechas::Sql($_REQUEST['fend']) : '2099-01-01';

		if ($_REQUEST['estadistica'] == 'Administrativas') { 
			$Departamento = 1;
			$ids = array(1, 2, 3, 4, 5, 6, 7, 8);
		} elseif ($_REQUEST['estadistica'] == 'Médicas') {
			$Departamento = 1;
			$ids = array(9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19);
		} elseif ($_REQUEST['estadistica'] == 'Total') {
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

	public function verTicket()
	{
		$ticket = $this->cp->verTicket($_REQUEST['ticket'])->see();
		$ticket[0]['fecha_apertura'] = Fechas::normal($ticket[0]['fecha_apertura']);
		$resultado = $this->cp->ultimoEnRevisar($_SESSION['id'], $_REQUEST['ticket'])->save();
		if (!empty($ticket[0]['serial'])) {
			$computador = $this->cp->computador($ticket[0]['serial'])->see();
			$resultado = array_merge($ticket, $computador);
			echo json_encode($resultado);
		} else {
			echo json_encode($ticket);
		}
	}

	public function registrarTicket()
	{
		$resultado = $this->cp->validarTicketSemana(
			$_REQUEST['solicitante'],
			MED::d($_REQUEST['direccion']),
			MED::d($_REQUEST['categoria']),
			$_REQUEST['serial'])->see();
		if (isset($resultado[0])) {
			echo(json_encode(array('ticket' => $resultado[0]['id'], 'estado' => false)));
			return;
		}
		if (!empty($_REQUEST['serial'])) {
			$resultado = $this->cp->computador($_REQUEST['serial'])->see();
			if (isset($resultado[0]['id'])) {
				$resultado = $this->cp->add_editComputador($_REQUEST['serial'], '', '', '', '', '')->save();
			}
		}
		$colaborador = (!empty($_REQUEST['colaborador'])) ? implode(', ', $_REQUEST['colaborador']) : '';
		$estado = $this->cp->add_editTicket(
			date("Y-m-d"),
			$_SESSION['id'],
			date('H:i'),
			$_REQUEST['solicitante'],
			MED::d($_REQUEST['direccion']),
			MED::d($_REQUEST['division']),
			$_REQUEST['categoria'],
			MED::d($_REQUEST['problema_i']),
			MED::d($_REQUEST['problema_ii']),
			$_REQUEST['serial'],
			strtoupper($_REQUEST['detalles']),
			'',
			$_REQUEST['prioridad'],
			1,
			$_REQUEST['coordinacion'],
			$_REQUEST['idTecnico'],
			$colaborador,
			$_SESSION['id'],
			'NULL',
			'NULL')->save();
		if ($estado) {
			$lastId = $this->cp->lastTicket()->see();
			echo(json_encode(array('estado' => $estado, 'lastId' => $lastId[0]['lastId'])));
		} else {
			echo(json_encode(array('estado' => $estado)));
		}
	}

	public function cerrarTicket()
	{
		if ($_REQUEST['serial'] !== $_REQUEST['idserial']) {
			if ($_REQUEST['idserial'] == '-1' && !empty($_REQUEST['serial'])) {
				$this->cp->add_editComputador(
					$_REQUEST['serial'],
					$_REQUEST['modelo'],
					$_REQUEST['disco'],
					$_REQUEST['memoria'],
					$_REQUEST['procesador'],
					$_REQUEST['observaciones'])->save();
			} elseif($_REQUEST['idserial'] !== '-1') {
				$this->cp->add_editComputador(
					$_REQUEST['serial'],
					$_REQUEST['modelo'],
					$_REQUEST['disco'],
					$_REQUEST['memoria'],
					$_REQUEST['procesador'],
					$_REQUEST['observaciones'],
					$_REQUEST['idserial'])->save();
			}
		}
		$estado = $this->cp->add_editTicket(
			NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
			$_REQUEST['serial'],
			NULL,
			$_REQUEST['solucion'],
			$_REQUEST['prioridad'],
			$_REQUEST['estatus'],
			NULL,
			(($_REQUEST['responsable'] == '') ? NULL : $_REQUEST['responsable']),
			($_REQUEST['colaborador'] == '') ? NULL : implode(', ', $_REQUEST['colaborador']),
			$_SESSION['id'],
			NULL,
			$_SESSION['id'],
			$_REQUEST['id'])->save();
		echo json_encode(array('estado' => $estado));
	}

	public function datalistDep()
	{
		$datalist = '';
		$deps = $this->cp->select('division')->see();
		foreach ($deps as $d) {
			$datalist .= '<option departamento="'.MED::e($d['relacion']).'" division="'.MED::e($d['id']).'" value="'.$d['opcion'].'"></option>';
		}
		echo(json_encode(array('datalist' => $datalist)));
	}

	public function datalistPro()
	{
		$datalist = '';
		$prob = $this->cp->problems()->see();
		foreach ($prob as $p) {
			$datalist .= '<option categoria="'.$p['idcategory'].'" problema="'.MED::e($p['idproblem']).'" id="'.MED::e($p['idproblem2']).'" value="'.$p['Subproblema'].'"></option>';
		}
		echo(json_encode(array('datalist' => $datalist)));
	}

	public function coordinaciones()
	{
		echo('<option value="" selected disabled>Seleccione la Coordinación</option>');
		$coord = $this->cp->select('coordinaciones', null, 0)->see();
		foreach ($coord as $c) {
			echo('<option value="'.$c['id'].'">'.$c['coordinacion'].'</option>');
		}
	}

	public function server_side_processing()
	{
		$resultado = $this->cp->totalTickets()->see();
		$totalFiltered = $totalData = $resultado[0]['total'];

		if( !empty($_REQUEST['search']['value']) ) {
			$resultado = $this->cp->totalTickets($_REQUEST['search']['value'])->see();
			$totalFiltered = $resultado[0]['total'];
		}

		$resultado = $this->cp->datosTickets($_REQUEST['search']['value'], $_REQUEST['order'][0]['column'], $_REQUEST['order'][0]['dir'], $_REQUEST['start'], $_REQUEST['length'])->see();
		$data = array();
		foreach ($resultado as $r) {
			$nestedData = array();
			$nestedData[] = '<a href="#" ren="'.$r['id'].'" id="abrirTicket2">'.$r['id'].'</a>';
			$nestedData[] = Fechas::normal($r['fecha_apertura']).'<br>'.$r['hora'];
			$nestedData[] = $r['solicitante'].'<br>'.$r['division'];
			$nestedData[] = $r['problem'].'<br>'.$r['subproblem'];
			$nestedData[] = $r['nombre'].'<br>'.$r['colaborador'];
			$nestedData[] = $r['estatus'];
			$nestedData[] = '
			<div class="btn-group" role="group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Acciones <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="#" ren="'.$r['id'].'" id="abrirTicket2">Detalles</a></li>
			<li><a href="#" ren="'.$r['id'].'" id="editTicket">Modificar</a></li>
			</ul>
			</div>';
			// <li><a href="reportes/informe.php?num='.$r['id'].'">Informe</a></li>
			$data[] = $nestedData;
		}

		echo json_encode(array(
			'draw'            => intval( $_REQUEST['draw'] ),
			'recordsTotal'    => intval( $totalData ),
			'recordsFiltered' => intval( $totalFiltered ),
			'data'            => $data
		));
	}

	public function __destruct()
	{
		$this->cp = NULL;
		$this->es = NULL;
	}
} /*Fin de la clase AjaxController*/