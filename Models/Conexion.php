<?php namespace models;
define('DBHOST', 'localhost');
define('DBUSER', 'renny');
define('DBPASS', '123456789');
define('DBTABLE', 'st');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', '<1RENNY@SUAREZ!OTIC@SAHUM-2017></1RENNY@SUAREZ!OTIC@SAHUM-2017>');
define('SECRET_IV', 'SAHUM_OTIC_UNIDAD.DE.DESARROLLO');

/**
* Metodos de conexion y consultas a la bd
*/
abstract class Conexion
{
	public $conexion;
	public $sql;
	protected $join = 'FROM tickets AS t 
	INNER JOIN users AS u ON t.registrante = u.id
	INNER JOIN users as u2 ON t.id_soporte = u2.id
	INNER JOIN users as u3 ON t.transferencia = u3.id
	INNER JOIN prioridades AS pr ON t.id_prioridad = pr.id
	INNER JOIN estatus AS e ON t.id_estatus = e.id
	INNER JOIN coordinaciones AS co ON t.coordinacion = co.id
	INNER JOIN problema_i AS p1 ON t.solicitud = p1.id
	INNER JOIN problema_ii AS p2 ON t.problema = p2.id';
	

	public function __construct ()
	{
		$this->conexion = new \mysqli(DBHOST, DBUSER, DBPASS, DBTABLE);
		$this->conexion->query("SET NAMES 'UTF8'");
	}

	public function see()
	{
		$n = 0;
		$resultado = mysqli_query($this->conexion, $this->sql);
		if ($resultado->num_rows === 0) {
			return array();
		} else {
			while($fila  = mysqli_fetch_assoc($resultado))
			{
				$registros[$n] = $fila; $n++;
			}
			return $registros;
		}
	}

	public function getSQL() { echo($this->sql); }

	public function save()
	{
		$resultado = mysqli_query($this->conexion, $this->sql);
		return ($resultado > 0) ? true : false;
	}
	
	public function select($tabla, $where = array(array(-1, -1)), $delete = 1)
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
		if ($delete == 1) {
			$this->sql .= ' AND delete_at IS NULL';
		}
		return $this;
	}

	public function __destruct()
	{
		$this->conexion->close();
		$this->conexion = NULL;
	}
} /*fin de la clase conexion*/