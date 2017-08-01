<?php namespace models;
/**
* Metodos de las consultas principales de PAINRA
*/
class CPrincipales extends Conexion
{
	public function login($usuario)
	{
		$this->sql = "SELECT u.*, uc.id_coordinacion, coordinacion
		FROM users AS u
		LEFT JOIN user_coordinacion AS uc ON uc.id_user = u.id
		LEFT JOIN coordinaciones AS c ON uc.id_coordinacion = c.id
		WHERE activo = 1 AND u.usuario = '{$usuario}'
		ORDER BY id ASC";
		return $this;
	}

	public function cambioPass($id, $clave)
	{
		$this->sql = "UPDATE users SET pass = '{$clave}' WHERE id = '{$id}' LIMIT 1";
		return $this;
	}

} /* Fin de la clase ConsultasPrincipales */

