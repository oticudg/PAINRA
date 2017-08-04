<div class="modal fade modal-contraseña" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="fa fa-cog"></span> Cambiar contraseña</h4>
			</div>
			<form id="password" class="form" role="form" method="POST" action="" accept-charset="UTF-8">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-md-6">
							<span class="fa fa-key"></span>
							<label for="newpass">Ingresa la nueva Contraseña:*</label>
							<input type="password" class="form-control" id="newpass" name="newpass" minlength="8" maxlength="20" placeholder="Ingresa la Nueva Contraseña" required>
						</div>
						<div class="col-md-6">
							<span class="fa fa-key"></span>
							<label for="confirmacion">Confirma la Contraseña:*</label>
							<input type="password" class="form-control" id="confirmacion" name="confirmacion" minlength="8" maxlength="20" placeholder="Confirma la Nueva Contraseña" required>
							<input type="hidden" name="token" value="3">
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<span class="menssage"></span>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Guardar</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modal-soportistas" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Usuarios Registrados</h4>
			</div>
			<div class="modal-body">
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<button type="btn" class="btn btn-small btn-primary" id="registrarU"><span class="fa fa-plus"></span> Registrar</button>
						<button type="btn" class="btn btn-small btn-primary" id="editarU"><span class="fa fa-plus"></span> Editar</button>
						<button type="btn" class="btn btn-small btn-primary" id="eliminarU"><span class="fa fa-plus"></span> Eliminar</button>
						<button type="btn" class="btn btn-small btn-primary" id="coordinacionU" style="display:none;"><span class="fa fa-plus"></span> Coordinación</button>
						<span class="btncoord"></span>
					</div><br>
				</div>
				<div class="col-md-10 col-md-offset-1 tabla-soportistas overflow"></div>
			</div>
			<div class="clearfix"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modal-soportista-registrar" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="fa fa-plus"></span> Registrar Soportista</h4>
			</div>
			<form id="registrar-soportista" class="form" role="form" accept-charset="UTF-8">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-md-8 col-md-offset-2">
							<div class="form-group">
								<span class="glyphicon glyphicon-user"></span>
								<label for="usuario">Usuario:</label>
								<input type="text" id="usuario" class="form-control" name="usuario" placeholder="Ingrese el nuevo usuario" required>
							</div>
							<div class="form-group">
								<span class="fa fa-address-book-o"></span>
								<label for="nombre">Nombre y Apellido:</label>
								<input type="text" id="nombre" class="form-control" name="nombre" placeholder="Ingrese el nombre y apellido" required>
							</div>
							<div class="form-group">
								<span class="fa fa-id-card"></span>
								<label for="cedula">Cedula:</label>
								<input type="text" id="cedula" class="form-control" name="cedula" placeholder="Ingrese la cedula de identidad" required minlength="7">
							</div>
							<div class="form-group">
								<span class="fa fa-id-card"></span>
								<label for="email">Email</label>
								<input type="email" id="cedula" class="form-control" name="email" placeholder="Ingrese el correo electronico" required>
							</div>
							<div class="form-group">
								<span class="fa fa-calendar"></span>
								<label for="rol">Rol:</label>
								<select name="rol" id="rol" class="form-control" required>
									<option value="">Seleccione el rol</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
								<input type="hidden" name="id" id="id" value="-1">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<span class="msg pull-left"></span>
					<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Guardar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modal-help" tabindex="9999" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="fa fa-plus"></span></h4>
			</div>
			<div class="modal-body">
				<div class="col-md-10 col-md-offset-1 help">
				</div>
				<div class="clearfix"></div>
				<div class="modal-footer">
					<span class="msg pull-left"></span>
					<span class="btnn"></span>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
</div><!-- /.modal -->