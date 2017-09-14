<div class="container">
	<h3 class="text-center">Total de Solicitudes</h3>
	<button type="btn" class="btn btn-small btn-primary" data-toggle="modal" data-target=".modal-registrar"><span class="fa fa-plus"></span> Agregar ticket</button><br><br>
	<table id="tabla" class="table table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th>Fecha</th>
				<th>Solicitante</th>
				<th>Requerimiento</th>
				<th>Responsables</th>
				<th>Estatus</th>
				<th width="10%">Operaciones</th>
			</tr>
		</thead>
	</table>
</div>
<?php Views\Modales\Modales::Tickets() ?>