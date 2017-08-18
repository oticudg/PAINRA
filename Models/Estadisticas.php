<?php namespace models;

/**
* Metodos de las consultas principales de PAINRA
*/
class Estadisticas extends Conexion
{
	private $join = 'FROM tickets AS t 
	INNER JOIN users AS u ON t.registrante = u.usuario
	INNER JOIN users as u2 ON t.cedula_soporte = u2.cedula
	INNER JOIN categoria AS c ON t.id_categoriag = c.id
	INNER JOIN problema_i AS p1 ON t.solicitud = p1.id
	INNER JOIN problema_ii AS p2 ON t.problema = p2.id
	INNER JOIN prioridades AS pr ON t.id_prioridad = pr.id
	INNER JOIN estatus AS e ON t.id_estatus = e.id
	INNER JOIN coordinaciones AS co ON t.coordinacion = co.id';

	public function barrasEstadisticas()
	{
		$where = '';
		if ($_SESSION['rol'] == 2) {
			$where = 'WHERE t.coordinacion = '.$_SESSION['id_coordinacion'];
		} elseif ($_SESSION['rol'] == 3) {
			$where = 'WHERE t.cedula_soporte = ' . $_SESSION['cedula'];
		}
		$this->sql = 'SELECT e.id, e.descripcion, COUNT(t.id) AS tickets 
		'.$this->join.'
		GROUP BY 2 ORDER BY 2;';
		return $this;
	}

	public function mTickets($estatus)
	{
		$this->sql = 'SELECT t.id, t.fecha_apertura, t.hora, u2.nombre AS soportista, t.colaborador ';
		$this->sql .= $this->join;
		$this->sql .= ' WHERE e.descripcion = "'.$estatus.'"  ORDER BY id DESC';
		return $this;
	}
} /* Fin de la clase ConsultasPrincipales */