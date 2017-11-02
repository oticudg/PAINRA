<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form id="formDepartamentos" class="form-inline" method="POST">
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
					<div><label for="estadistica">Departamento a consultar</label></div>
					<div class="input-group">
						<div class="input-group-addon"><span class="fa fa-id-card"></span></div>
						<select id="estadistica" class="form-control" name="estadistica" required>
							<option value="">Seleccione el departamento</option>
							<option value="Administrativas">Estadística dpto. administrativos</option>
							<option value="Médicas">Estadística dpto. médico asistencial</option>
							<option value="Total">Estadística dpto. OTIC</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Consultar</button> 
				</div>
			</form>
		</div>
	</div>
	<div id="estadistica" class="row" style="display:none">
		<h2 class="text-center"></h2><hr>
		<table id="table" class="table table-condensed table-hover" style="font-size: 1.5em;">
			<thead>
				<th>N°</th>
				<th></th>
				<th>Resueltos</th>
				<th>En proceso</th>
				<th>Pendientes</th>
				<th>Ticket´s</th>
				<th>%</th>
			</thead>
			<tbody></tbody>
			<tfoot></tfoot>
		</table>
	</div>
	<div id="graphic" class="col-md-10 col-md-offset-1"></div>
</div>