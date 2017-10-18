<?php namespace models;
use Config\Fechas;

/**
* Metodos de las consultas principales de PAINRA
*/
class CPrincipales extends Conexion
{

	protected $join = 'FROM tickets AS t 
	INNER JOIN users AS u ON t.registrante = u.id
	INNER JOIN users as u2 ON t.id_soporte = u2.id
	INNER JOIN users as u3 ON t.transferencia = u3.id
	INNER JOIN prioridades AS pr ON t.id_prioridad = pr.id
	INNER JOIN estatus AS e ON t.id_estatus = e.id
	INNER JOIN coordinaciones AS co ON t.coordinacion = co.id
	INNER JOIN problema_i AS p1 ON t.solicitud = p1.id
	INNER JOIN problema_ii AS p2 ON t.problema = p2.id
	INNER JOIN direccion AS d ON t.id_departamento = d.id
	INNER JOIN division AS di ON t.id_secciones = di.id';

	protected $columns = array(
		0 => 't.id',
		1 => 't.fecha_apertura',
		2 => 't.hora',
		3 => 't.solicitante',
		4 => 'd.opcion AS division',
		5 => 'p1.opcion AS problem',
		6 => 'p2.opcion AS subproblem',
		7 => 'u2.nombre',
		8 => 'e.descripcion AS estatus',
		9 => 't.colaborador'
	);

	protected $search = array(
		't.id',
		'OR t.fecha_apertura',
		'OR t.hora',
		'OR t.solicitante',
		'OR d.opcion',
		'OR p1.opcion',
		'OR p2.opcion',
		'OR u.nombre',
		'OR t.colaborador',
		'OR e.descripcion',
		'OR t.serial',
	);

	protected $arr = array(
		0 => 't.id',
		1 => 't.fecha_apertura, t.hora',
		2 => 't.solicitante, division',
		3 => 'problem, subproblem',
		4 => 'u.nombre, t.colaborador',
		5 => 'estatus',
		6 => '1'
	);

	public function users($id= -1, $rol= 0, $usuario= 0, $cedula= 0, $email= 0, $id_coord= 0)
	{
		$this->sql = 'SELECT u.*, uc.id_coordinacion, coordinacion, uc.id AS iduc
		FROM users AS u
		LEFT JOIN user_coordinacion AS uc ON uc.id_user = u.id
		LEFT JOIN coordinaciones AS c ON uc.id_coordinacion = c.id
		WHERE u.delete_at IS NULL AND
		(u.id = '.$id.' OR '.$id.' = -1) OR
		(u.rol = "'.$rol.'" OR "'.$rol.'" = -1) OR
		(u.usuario = "'.$usuario.'" OR "'.$usuario.'" = -1)  OR
		(u.cedula = "'.$cedula.'" OR "'.$cedula.'" = -1) OR
		(u.email = "'.$email.'" OR "'.$email.'" = -1) OR
		(uc.id_coordinacion = "'.$id_coord.'" OR "'.$id_coord.'" = -1)
		ORDER BY u.nombre ASC;';
		return $this;
	}

	public function add_editUser($usuario, $nombre, $cedula, $email, $rol, $pass, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.' users SET 
		'.(($pass != '') ? 'pass = "'.$pass.'",' : '').'
		usuario = "'.$usuario.'",
		nombre = "'.$nombre.'",
		email = "'.$email.'",
		cedula = '.$cedula.',
		rol = "'.$rol.'" '.$sufijo;
		return $this;
	}

	public function soportistas($rol = -1, $id_coord = -1)
	{
		$this->sql = 'SELECT u.*, uc.id_coordinacion, coordinacion, uc.id AS iduc
		FROM users AS u
		LEFT JOIN user_coordinacion AS uc ON uc.id_user = u.id
		LEFT JOIN coordinaciones AS c ON uc.id_coordinacion = c.id
		WHERE u.delete_at IS NULL AND
		(u.rol = "'.$rol.'" OR "'.$rol.'" = -1) AND
		(uc.id_coordinacion = "'.$id_coord.'" OR "'.$id_coord.'" = -1)
		ORDER BY u.nombre ASC;';
		return $this;
	}

	public function cambioPass($id, $clave)
	{
		$this->sql = 'UPDATE users SET pass = "'.$clave.'" WHERE id = '.$id.' LIMIT 1';
		return $this;
	}

	public function addUserCoordinacion($user, $coordinacion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.'user_coordinacion SET
		id_user = '.$user.',
		id_coordinacion = '.$coordinacion.$sufijo;
		return $this;
	}

	public function add_editDireccion($opcion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.'direccion SET
		opcion = "'.$opcion.'" '.$sufijo;
		return $this;
	}

	public function add_editDivision($opcion, $relacion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.'division SET
		opcion = "'.$opcion.'",
		relacion = '.$relacion.$sufijo;
		return $this;
	}

	public function add_editCategoria($opcion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.'categoria SET opcion = "'.$opcion.'"'.$sufijo;
		return $this;
	}

	public function add_editProblemas($tabla, $opcion, $relacion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo.$tabla.' SET
		opcion = "'.$opcion.'",
		relacion = '.$relacion.$sufijo;
		return $this;
	}

	public function verTicket($id = -1)
	{
		$this->sql = "SELECT t.id, t.fecha_apertura, t.hora, u.nombre AS registrante, u2.nombre AS soportista, pr.descripcion AS prioridad, e.descripcion AS estatus, id_estatus, co.coordinacion, p1.opcion AS problema, p2.opcion AS subproblema, t.colaborador, t.solucion, t.solicitante, t.detalleF, t.serial, u3.nombre AS transferencia, d.opcion AS direccion, di.opcion AS seccion, t.fecha_cierre, t.id_soporte AS id_soportista, id_prioridad, id_categoriag
		".$this->join."
		WHERE t.id = ".$id." OR ".$id." = -1";
		return $this;
	}

	public function ultimoEnRevisar($iduser, $idticket)
	{
		$this->sql = "UPDATE tickets SET ultimo_revisar = ".$iduser." WHERE id = ".$idticket." LIMIT 1";
		return $this;
	}

	public function validarTicketSemana($sole, $dep, $cat, $ser)
	{
		$this->sql = "SELECT id
		FROM tickets 
		WHERE fecha_apertura BETWEEN  '".(date('Y-m-d', time() - (7 * 24 * 60 * 60)))."' AND '".date('Y-m-d')."'
		AND (id_estatus = 1 OR id_estatus = 2) 
		AND serial = '".$ser."' 
		AND solicitante = '".$sole."' 
		AND id_departamento = ".$dep." 
		AND id_categoriag = ".$cat.";";
		return $this;
	}

	public function add_editTicket($feca, $reg, $hor, $sole, $dep, $sec, $cat, $sold, $pro, $ser, $det, $soln, $pri, $est, $coo, $ced, $col, $tra, $fecc, $ultr, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo." tickets SET ";
		$this->sql .= ($id == -1) ? "id_departamento = ".$dep.", " : '';
		$this->sql .= ($id == -1) ? "id_secciones = ".$sec.", " : '';
		$this->sql .= ($id == -1) ? "id_categoriag = ".$cat.", " : '';
		$this->sql .= ($id == -1) ? "solicitud = ".$sold.", " : '';
		$this->sql .= ($id == -1) ? "problema = ".$pro.", " : '';
		$this->sql .= ($id == -1) ? "registrante = '".$reg."', " : '';
		$this->sql .= ($id == -1) ? "hora = '".$hor."', " : '';
		$this->sql .= ($id == -1) ? "solicitante = '".$sole."', " : '';
		$this->sql .= ($id == -1) ? "detalleF = '".$det."', " : '';
		$this->sql .= ($id == -1) ? "fecha_apertura = '".$feca."', " : '';
		$this->sql .= ($id == -1) ? "coordinacion = ".$coo.", " : '';
		$this->sql .= ($id == -1) ? "fecha_cierre = NULL, " : "fecha_cierre = '".$fecc."', ";
		$this->sql .= ($col !== '' && $col != NULL) ? "colaborador = '".$col."', " : '';
		$this->sql .= ($ced == NULL) ? '' : 'id_soporte = "'.$ced.'",';
		$this->sql .= "
		serial = '".$ser."',
		solucion = '".$soln."',
		id_prioridad = ".$pri.",
		id_estatus = ".$est.",
		transferencia = ".$tra.",
		ultimo_revisar = ".$ultr."
		".$sufijo;
		return $this;
	}

	public function lastTicket()
	{
		$this->sql = "SELECT max(id) as lastId FROM tickets LIMIT 1";
		return $this;
	}

	public function computador($serial)
	{
		$this->sql = 'SELECT * FROM computador WHERE (serial = "'.$serial.'" OR "'.$serial.'" = -1)';
		return $this;
	}

	public function add_editComputador($se, $mo, $di, $me, $pr, $ob, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql = $prefijo."computador SET
		serial = '".$se."',
		modelo = '".$mo."',
		disco = '".$di."',
		memoria = '".$me."',
		procesador = '".$pr."',
		observaciones = '".$ob."'".$sufijo;
		return $this;
	}

	public function totalTickets($busqueda = '')
	{
		$this->sql = 'SELECT count(*) as total '.$this->join;
		if ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || !empty($busqueda)) {
			$this->sql .= ' WHERE ';
		}
		if ($_SESSION['rol'] == 2) {
			$this->sql .= 't.coordinacion = '.$_SESSION['id_coordinacion'];
			if ($_SESSION['id_coordinacionnopc'] != NULL) {
				$this->sql .= ' OR t.coordinacion = '.$_SESSION['id_coordinacionnopc'];
			}
		} elseif ($_SESSION['rol'] == 3) {
			$this->sql .= 't.id_soporte = '.$_SESSION['id'];
		}
		if( !empty($busqueda) ) {
			if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 2) {
				$this->sql .= ' AND ';
			}
			foreach ($this->search as $s) {
				$this->sql .= $s.' LIKE "%'.$busqueda.'%" ';
			}
		}
		return $this;
	}

	public function datosTickets($busqueda, $columnaOrdenar, $ordenar, $start, $length)
	{
		$this->sql = 'SELECT '.implode(', ', $this->columns).' '.$this->join;
		if ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || !empty($busqueda)) {
			$this->sql .= ' WHERE ';
		}
		if ($_SESSION['rol'] == 2) {
			$this->sql .= 't.coordinacion = '.$_SESSION['id_coordinacion'];
			if ($_SESSION['id_coordinacionnopc'] != NULL) {
				$this->sql .= ' OR t.coordinacion = '.$_SESSION['id_coordinacionnopc'];
			}
		} elseif ($_SESSION['rol'] == 3) {
			$this->sql .= 't.id_soporte = '.$_SESSION['id'];
		}
		if( !empty($busqueda) ) {
			if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 2) {
				$this->sql .= ' AND ';
			}
			foreach ($this->search as $s) {
				$this->sql .= $s.' LIKE "%'.$busqueda.'%" ';
			}
		}
		$this->sql .= ' ORDER BY '. $this->arr[$columnaOrdenar].' '.$ordenar.' LIMIT '.$start.' ,'.$length;
		return $this;
	}

	public function keySearch($table, $key)
	{
		$this->sql = "SELECT * FROM {$table} WHERE opcion LIKE '%{$key}%' AND delete_at IS NULL";
		return $this;
	}

	public function confirmDelete($tabla, $id)
	{
		$this->sql = 'UPDATE '.$tabla.' SET delete_at = "'.date('Y-m-d H:m:s').'" WHERE id = '.$id.' LIMIT 1';
		return $this;
	}

	public function delete($tabla, $id)
	{
		$this->sql = 'DELETE FROM '.$tabla.' WHERE id = '.$id.' LIMIT 1';
		return $this;
	}

} /* Fin de la clase ConsultasPrincipales */

