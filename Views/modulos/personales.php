<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form id="form-personales" class="form-inline" method="POST">
				<div class="form-group">
					<div> <label for="fstart">Fecha desde:</label> </div>
					<div class="input-group input-daterange" id="datepicker">
						<div class="input-group-addon"><span class="fa fa-calendar"></span></div>
						<input type="text" class="form-control" id="fstart" name="fstart">
					</div>
				</div>
				<div class="form-group">
					<div> <label for="fend">Fecha hasta:</label> </div>
					<div class="input-group input-daterange" id="datepicker">
						<div class="input-group-addon"><span class="fa fa-calendar"></span></div>
						<input type="text" class="form-control" id="fend" name="fend">
					</div>
				</div>
				<div class="form-group">
					<div><label for="responsable">Cedula de soportista:</label></div>
					<div class="input-group">
						<div class="input-group-addon"><span class="fa fa-id-card"></span></div>
						<select name="responsable" id="responsable" class="form-control" required></select>
					</div>
					<button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Consultar</button>
				</div>
			</form>
		</div>
	</div>
	<h2 class="text-center" id="nombre"></h2>
	<div class="col-md-8 col-md-offset-2">
		<div class="table-responsive">
			<table class="table table-hover tb_estadistica">
				<thead>
					<th>Abierto</th>
					<th>En proceso</th>
					<th>Cerrado</th>
					<th>Total</th>
					<th>Efectividad</th>
				</thead>
				<tbody>
					<tr>
						<td id="Abierto"></td>
						<td id="Proceso"></td>
						<td id="Cerrado"></td>
						<td id="Total"></td>
						<td id="Efectividad"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="grafica_soportistas" class="col-md-8 col-md-offset-2"></div>
</div>