<?php namespace models;

/**
* Metodos de las consultas principales de PAINRA
*/
class CPrincipales extends Conexion
{


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
		'.(($id == -1) ? 'pass = "'.$pass.'",' : '').'
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
		$this->sql = "SELECT t.id, t.fecha_apertura, t.hora, u.nombre AS registrante, u2.nombre AS soportista, pr.descripcion AS prioridad, e.descripcion AS estatus, co.coordinacion, p1.opcion AS problema, p2.opcion AS subproblema, t.fechaCierre, t.horaCierre, t.colaborador, t.solucion, t.solicitante, t.detalleF, t.serial, u3.nombre AS transferencia, d.opcion AS direccion, di.opcion AS seccion
		FROM tickets AS t 
		INNER JOIN users AS u ON t.registrante = u.usuario
		INNER JOIN users as u2 ON t.cedula_soporte = u2.cedula
		INNER JOIN users as u3 ON t.transferencia = u3.usuario
		INNER JOIN prioridades AS pr ON t.id_prioridad = pr.id
		INNER JOIN estatus AS e ON t.id_estatus = e.id
		INNER JOIN coordinaciones AS co ON t.coordinacion = co.id
		INNER JOIN problema_i AS p1 ON t.solicitud = p1.id
		INNER JOIN problema_ii AS p2 ON t.problema = p2.id
		INNER JOIN direccion AS d ON t.id_departamento = d.id
		INNER JOIN division AS di ON t.id_secciones = di.id
		WHERE t.id = ".$id." OR ".$id." = -1";
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

