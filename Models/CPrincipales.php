<?php namespace models;

/**
* Metodos de las consultas principales de PAINRA
*/
class CPrincipales extends Conexion
{
	public function users($id = -1, $rol = 0, $usuario = 0, $cedula = 0, $email= 0)
	{
		$this->sql = 'SELECT u.*, uc.id_coordinacion, coordinacion, uc.id AS iduc
		FROM users AS u
		LEFT JOIN user_coordinacion AS uc ON uc.id_user = u.id
		LEFT JOIN coordinaciones AS c ON uc.id_coordinacion = c.id
		WHERE u.delete_at IS NULL AND
		(u.id = '.$id.' OR '.$id.' = -1) OR
		(u.rol = "'.$rol.'" OR "'.$rol.'" = -1) OR
		(u.usuario = "'.$usuario.'" OR "'.$usuario.'" = -1)  OR
		(u.cedula = "'.$cedula.'" OR "'.$cedula.'" = -1)  OR
		(u.email = "'.$email.'" OR "'.$email.'" = -1)
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

	public function barrasEstadisticas()
	{
		$where = '';
		if ($_SESSION['rol'] == 2) {
			$where = 'WHERE t.coordinacion = '.$_SESSION['id_coordinacion'];
		} elseif ($_SESSION['rol'] == 3) {
			$where = 'WHERE t.cedula_soporte = ' . $_SESSION['cedula'];
		}
		$this->sql = 'SELECT e.id, e.descripcion, COUNT(t.id) AS tickets FROM tickets AS t INNER JOIN estatus AS e ON t.id_estatus = e.id
		'.$where.'GROUP BY 2 ORDER BY 2;';
		return $this;
	}

	public function select($tabla, $where = array(array(-1, -1)))
	{
		$this->sql = 'SELECT * FROM '.$tabla;
		$cont = count($where);
		if ($cont > 0) {
			$this->sql .=' WHERE '; 
			for($i = 0; $i < $cont; $i++){
				$this->sql .= '('.$where[$i][0].' = "'.$where[$i][1].'" OR '.$where[$i][1].' = -1)';
				if ( $cont > 0 && $i < $cont-1) { $this->sql .= ' AND '; }
			}
		}
		$this->sql .= ' AND delete_at IS NULL';
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

