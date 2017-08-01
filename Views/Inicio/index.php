<?php
// require_once("clases/modelo.php");
// session_start();
// date_default_timezone_set("America/La_Paz");
// if(!isset($_SESSION['id']) || !isset($_SESSION['privilegio'])){echo '<script> alert("Debe iniciar sesion para poder acceder al sistema"); window.location="index.php"; </script>'; exit(); }

// $privilegio 	= $_SESSION['privilegio'];
// $subpri = substr($privilegio, 0, 1);
// $cedula 	= $_SESSION['cedula'];
// $cp = new consultasPrincipales();

// $ticket = Estadisticas::ticket();
// require_once 'resource/template/head.php';
?>

<h1 class="text-center">P A I N R A</h1>
<h2 class="text-center"> Tiques asignados a <?php echo $data['asignado']; ?> </h2>
<hr>
<div class="container">
	<div class="row">
		<div class="notice notice-primary col-md-5 ventana">
			<strong>Abiertos: </strong> <i><?php /*echo ($resultado['totalPendiente'] < 1) ? 0 : $resultado['totalPendiente'];*/ ?></i>
			<div class="pull-right">
				<button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal-abiertos"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-warning col-md-5 col-md-offset-2 ventana">
			<strong>En proceso: </strong> <i><?php /*echo ($resultado['totalEnProceso'] < 1) ? 0 : $resultado['totalEnProceso'];*/ ?></i>
			<div class="pull-right">
				<button class="btn btn-sm btn-warning" data-toggle="modal" data-target=".modal-enproceso"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-danger col-md-5 ventana">
			<strong>Cerrados: </strong> <i><?php /*echo ($resultado['totalResuelto'] < 1) ? 0 : $resultado['totalResuelto'];*/ ?></i>
			<div class="pull-right">
				<button class="btn btn-sm btn-danger" data-toggle="modal" data-target=".modal-graphic-porcentaje_departamentos"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-success col-md-5 col-md-offset-2 ventana">
			<strong>Efectividad: </strong> <i><?php /*echo number_format(($resultado['efectividad']),2,'.',',').'%';*/ ?></i>
			<div class="pull-right">
				<span class="fa fa-check text-success fa-2x"></span>
			</div>
		</div>
		<div class="notice notice-info col-md-5 col-md-offset-4 ventana">
			<strong>Total de solicitudes: </strong> <i><?php /*echo $resultado['totalSolicitudes'];*/ ?></i>
			<div class="pull-right">
				<button class="btn btn-sm btn-info" data-toggle="modal" data-target=".modal-graphic-cerrados"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
	</div>
</div>
<!-- <script src="resource/js/graphic_registros.js"></script> -->
