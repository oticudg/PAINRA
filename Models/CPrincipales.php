<?php namespace models;

/**
* Metodos de las consultas principales de PAINRA
*/
class CPrincipales extends Conexion
{
	public function users($id = -1, $rol = 0, $usuario = 0, $cedula = 0, $email= 0)
	{
		$this->sql = "SELECT u.*, uc.id_coordinacion, coordinacion, uc.id AS iduc
		FROM users AS u
		LEFT JOIN user_coordinacion AS uc ON uc.id_user = u.id
		LEFT JOIN coordinaciones AS c ON uc.id_coordinacion = c.id
		WHERE delete_at IS NULL AND (u.id = {$id} OR {$id} = -1) OR
		(u.rol = '{$rol}' OR '{$rol}' = -1) OR
		(u.usuario = '{$usuario}' OR '{$usuario}' = -1)  OR
		(u.cedula = '{$cedula}' OR '{$cedula}' = -1)  OR
		(u.cedula = '{$email}' OR '{$email}' = -1)
		ORDER BY u.nombre ASC;";
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

	public function confirmDeleteUser($id)
	{
		$this->sql = "UPDATE users SET delete_at = 1 WHERE id = '{$id}' LIMIT 1";
		return $this;
	}

	public function addUserCoordinacion($user, $coordinacion, $id = -1)
	{
		$prefijo = ($id == -1) ? 'INSERT INTO ' : 'UPDATE ';
		$sufijo = ($id == -1) ? ';' : ' WHERE id = ' . $id;
		$this->sql .= $prefijo." user_coordinacion SET
		id_user = {$user},
		id_coordinacion = ".$coordinacion.$sufijo;
		return $this;
	}

	public function barrasEstadisticas($coordinacion = '')
	{
		$where = '';
		if ($_SESSION['rol'] == 2) {
			$where = 'WHERE t.coordinacion = '.$_SESSION['id_coordinacion'];
		} elseif ($_SESSION['rol'] == 2) {
			$where = "WHERE t.cedula_soporte = " . $_SESSION['cedula'];
		}
		$this->sql = "SELECT p.id, p.descripcion, COUNT(t.id)
		FROM tickets AS t INNER JOIN prioridades AS p ON t.id_prioridad = p.id
		".$where."
		GROUP BY 2
		ORDER BY t.estatus;";
		return $this;

		// print_r($a);
		// $resul = (new Conexion)->see($consulta);
		// $totalPendiente = 0; $totalEnProceso = 0; $totalResuelto = 0;
		// foreach ($resul as $key)
		// {
		// 	switch ($key['estatus'])
		// 	{
		// 		case 'Abierto':
		// 		$totalPendiente = $key['total']; break;
		// 		case 'En proceso':
		// 		$totalEnProceso = $key['total']; break;
		// 		case 'Cerrado':
		// 		$totalResuelto = $key['total']; break;
		// 	}
		// }
		// $totalSolicitudes = $totalPendiente + $totalEnProceso + $totalResuelto;
		// $efectividad = ( $totalSolicitudes > 0  ) ? (($totalResuelto * 100) / $totalSolicitudes) : 0 ;
		// return array(
		// 	'totalPendiente' => $totalPendiente,
		// 	'totalEnProceso' => $totalEnProceso,
		// 	'totalResuelto' => $totalResuelto,
		// 	'totalSolicitudes' => $totalSolicitudes,
		// 	'efectividad' => $efectividad
		// 	);
	}

	public function cambioPass($id, $clave)
	{
		$this->sql = "UPDATE users SET pass = '{$clave}' WHERE id = '{$id}' LIMIT 1";
		return $this;
	}

} /* Fin de la clase ConsultasPrincipales */

