<?php if ($_SESSION['rol'] < 2): ?>
	<div class="modal fade modal-contraseña" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="password" class="form" role="form" method="POST" action="" accept-charset="UTF-8">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-cog"></span> Cambiar contraseña</h4>
					</div>
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
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<span class="menssage"></span>
						<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Guardar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
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
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<button type="btn" class="btn btn-small btn-primary" id="registrarU" data-toggle="tooltip" data-placement="top" title="Registrar">
								<span class="fa fa-plus"></span>
							</button>
							<button type="btn" class="btn btn-small btn-warning" id="editarU" data-toggle="tooltip" data-placement="top" title="Editar">
								<span class="glyphicon glyphicon-edit">
								</span>
							</button>
							<button type="btn" class="btn btn-small btn-danger" id="eliminarU" data-toggle="tooltip" data-placement="top" title="Eliminar">
								<span class="fa fa-trash"></span>
							</button>
							<button type="btn" class="btn btn-small btn-info" id="coordinacionU" style="display:none;" data-toggle="tooltip" data-placement="top" title="Coordinación">
								<span class="fa fa-cubes"></span>
							</button>
						</div>
					</div><br>
				</div>
				<div class="col-md-10 col-md-offset-1 tabla-soportistas overflow"></div>
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
				<form id="registrar-soportista" class="form" role="form" accept-charset="UTF-8">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-edit"></span> Registrar Soportista</h4>
					</div>
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

	<div class="modal fade modal-soportistas-coordinacion" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<form id="form-user-coordinacion" method="POST">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-cubes" aria-hidden="true"></i> Agregar Coordinación</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="tipo">Tipo de Cambio:</label>
									<select name="tipo" id="tipo" class="form-control"></select>
								</div>
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="coordinacion">Coordinacion:</label>
									<select name="coordinacion" id="coordinacion" class="form-control" required>
										<option value="">Seleccione la Coordinación</option>
										<option value="1">Coordinación de Desarrollo</option>
										<option value="2">Coordinación de Soporte</option>
										<option value="3">Coordinación de Redes</option>
									</select>
									<input type="hidden" id="iduser" name="iduser" value="-1">
								</div>
								<span class="msgcoordinacion"></span>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger deleteUC">Eliminar</button>
						<input type="submit" class="btn btn-primary" value="Guardar">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php if ($_SESSION['rol'] == 1): ?>
		<div class="modal fade modal-departamentos" tabindex="9999" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-cubes" aria-hidden="true"></i> Registro Departamentos</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8 col-md-offset-2" style="margin-bottom: 1em;">
								<button type="btn" class="btn btn-small btn-primary" id="registrarD" data-toggle="tooltip" data-placement="top" title="Registrar">
									<span class="fa fa-plus"></span>
								</button>
								<button type="btn" class="btn btn-small btn-warning" id="editarD" data-toggle="tooltip" data-placement="top" title="Editar">
									<span class="glyphicon glyphicon-edit">
									</span>
								</button>
								<button type="btn" class="btn btn-small btn-danger" id="eliminarD" data-toggle="tooltip" data-placement="top" title="Eliminar">
									<span class="fa fa-trash"></span>
								</button>
							</div>
							<div class="col-md-8 col-md-offset-2">
								<div class="form-group">
									<span class="fa fa-cubes"></span>
									<label for="direccion">Direccion:</label>
									<select name="direccion" id="direccion" class="form-control" required> </select>
								</div>
								<div class="form-group">
									<span class="fa fa-cube"></span>
									<label for="division">Division:</label>
									<select name="division" id="division" class="form-control" required> </select>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-registrarDepartamento" tabindex="9999" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"></h4>
					</div>
					<form id="registrarDepartamento">
						<div class="modal-body">
							<div class="col-md-10 col-md-offset-1">
								<div class="form-group">
									<span class="fa fa-cubes"></span>
									<label for="direccion">Direccion:</label>
									<input type="text" id="direccion" class="form-control" name="direccion" placeholder="Ingrese la direccion" required list="direcciones" autocomplete="off" >
									<input type="hidden" id="id_direccion" name="id_direccion" value="-1">
									<datalist id="direcciones"></datalist>
								</div>
								<div class="form-group">
									<span class="fa fa-cube"></span>
									<label for="division">Division:</label>
									<input type="text" id="division" class="form-control" name="division" placeholder="Ingrese la division" required>
									<input type="hidden" id="id_division" name="id_division" value="-1">
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Guardar</button>
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-servicios" tabindex="9999" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="glyphicon glyphicon-inbox" aria-hidden="true"></i> Servicios</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-10 col-md-offset-1" style="margin-bottom: 1em;">
								<button type="btn" class="btn btn-small btn-primary" id="registrarS" data-toggle="tooltip" data-placement="top" title="Registrar">
									<span class="fa fa-plus"></span>
								</button>
								<button type="btn" class="btn btn-small btn-warning" id="editarS" data-toggle="tooltip" data-placement="top" title="Editar">
									<span class="glyphicon glyphicon-edit">
									</span>
								</button>
								<button type="btn" class="btn btn-small btn-danger" id="eliminarS" data-toggle="tooltip" data-placement="top" title="Eliminar">
									<span class="fa fa-trash"></span>
								</button>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<div class="form-group">
									<i class="fa fa-th-list" aria-hidden="true"></i>
									<label for="categoria">Categoria:</label>
									<select name="categoria" id="categoria" class="form-control" required> </select>
								</div>
								<div class="form-group">
									<i class="fa fa-list-ul" aria-hidden="true"></i>
									<label for="problema">Problema:</label>
									<select name="problema" id="problema" class="form-control" required> </select>
								</div>
								<div class="form-group">
									<i class="fa fa-list" aria-hidden="true"></i>
									<label for="subproblema">Sub-problema:</label>
									<select name="subproblema" id="subproblema" class="form-control" required> </select>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-registroServicios" tabindex="9999" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-plus"></span> Registrar Servicio.</h4>
					</div>
					<form id="registroServicios">
						<div class="modal-body">
							<div class="col-md-10 col-md-offset-1">
								<div class="form-group">
									<i class="fa fa-th-list" aria-hidden="true"></i>
									<label for="categoria">Categoria:</label>
									<input type="text" id="categoria" name="categoria" class="form-control" list="categorias" required autocomplete="off">
									<input type="hidden" name="idcategoria" id="idcategoria" value="-1">
									<datalist id="categorias"></datalist>
								</div>
								<div class="form-group">
									<i class="fa fa-list-ul" aria-hidden="true"></i>
									<label for="problema">Problema:</label>
									<input type="text" id="problema" name="problema" class="form-control" list="problemas" required autocomplete="off">
									<input type="hidden" name="idproblema" id="idproblema" value="-1">
									<datalist id="problemas"></datalist>
								</div>
								<div class="form-group">
									<i class="fa fa-list" aria-hidden="true"></i>
									<label for="subproblema">Sub-problema:</label>
									<input type="text" id="subproblema" name="subproblema" class="form-control" required autocomplete="off">
									<input type="hidden" name="idsubproblema" id="idsubproblema" value="-1">
									<datalist id="subproblema"></datalist>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Guardar</button>
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
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
						<div class="col-md-10 col-md-offset-1 help">
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<span class="msg pull-left"></span>
						<span class="btnn"></span>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<?php endif ?>
<?php endif ?>