<?php
if ($_SESSION['rol'] == 2) {
	$asignado = $_SESSION['coordinacion'];
} elseif ($_SESSION['rol'] == 3) {
	$asignado = $_SESSION['usuario'];
} else {
	$asignado = 'La OTIC';
}
?>
<div class="container">
	<h1 class="text-center">P A I N R A</h1>
	<h2 class="text-center"> Tiques asignados a <?php echo $asignado ?> </h2>
	<hr>
	<div class="row">
		<div class="notice notice-primary col-md-5 ventana abiertos">
			<strong></strong>
			<div class="pull-right">
				<button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal-abiertos"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-warning col-md-5 col-md-offset-2 ventana proceso">
			<strong></strong>
			<div class="pull-right">
				<button class="btn btn-sm btn-warning" data-toggle="modal" data-target=".modal-enproceso"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-danger col-md-5 ventana cerrados">
			<strong></strong>
			<div class="pull-right">
				<button class="btn btn-sm btn-danger" data-toggle="modal" data-target=".modal-graphic-porcentaje_departamentos"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
		<div class="notice notice-success col-md-5 col-md-offset-2 ventana efectividad">
			<strong></strong>
			<div class="pull-right">
				<span class="fa fa-check text-success fa-2x"></span>
			</div>
		</div>
		<div class="notice notice-info col-md-5 col-md-offset-4 ventana total">
			<strong></strong>
			<div class="pull-right">
				<button class="btn btn-sm btn-info" data-toggle="modal" data-target=".modal-graphic-cerrados"><span class="fa fa-eye"></span> Ver</button>
			</div>
		</div>
	</div>
</div>
