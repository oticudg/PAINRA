<?php namespace Views\Modales;
/**
* Modales settings de PAINRA
*/
class Modales
{
	public function __construct()
	{
		if ($_SESSION['rol'] <= 2) {
			Self::Soportistas();
			Self::servicios();
			if ($_SESSION['rol'] == 1) {
				Self::departamentos();
			}
		}
	}

	public function Soportistas()
	{
		?>
		<div class="modal fade modal-soportistas" tabindex="9999" role="dialog">
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
								<?php if ($_SESSION['rol'] == 1) { ?>
								<button type="btn" class="btn btn-small btn-info" id="coordinacionU" style="display:none;" data-toggle="tooltip" data-placement="top" title="Coordinación">
									<span class="fa fa-cubes"></span>
								</button>
								<?php } ?>
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
										<label for="email">Email:</label>
										<input type="email" id="email" class="form-control" name="email" placeholder="Ingrese el correo electronico" required>
									</div>
									<div class="form-group">
										<span class="fa fa-key"></span>
										<label for="pass">Contraseña:</label>
										<input type="password" id="pass" class="form-control" name="pass" placeholder="Ingrese la Contraseña" minlength="8">
									</div>
									<div class="form-group">
										<span class="fa fa-key"></span>
										<label for="cpass">Confirme Contraseña:</label>
										<input type="cpassword" id="cpass" class="form-control" name="cpass" placeholder="Ingrese la Contraseña" minlength="8">
									</div>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<div class="form-group">
										<span class="fa fa-calendar"></span>
										<label for="rol">Rol:</label>
										<select name="rol" id="rol" class="form-control" required>
											<option value="">Seleccione el rol</option>
											<option value="1">Administrador</option>
											<option value="2">Coordinador</option>
											<option value="3">Soportista</option>
											<option value="4">Call Center</option>
										</select>
									</div>
									<?php } ?>
									<input type="hidden" name="id" id="id" value="-1">
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
										<select name="coordinacion" id="coordinacion" class="form-control" required></select>
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
		<?php
	}

	public function departamentos()
	{
		?>
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
		<?php
	}

	public function servicios()
	{
		?>
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
		<?php
	}

	static function ModalesInicio()
	{
		?>
		<div class="modal fade modal-abiertos" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-eye"></span> Ticket's Abiertos</h4>
					</div>
					<div class="modal-body">
						<div class="overflow datos"></div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-enproceso" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-eye"></span> Ticket's En Proceso</h4>
					</div>
					<div class="modal-body">
						<div class="overflow datos"></div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-graphic-cerrados" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-eye"></span> Total de Ticket's Cerrados</h4>
					</div>
					<div class="modal-body">
						<div id="graphic-cerrados" style="height: 50vh"></div>
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-graphic-porcentaje_departamentos" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-eye"></span> Ticket's Cerrados por Departamentos</h4>
					</div>
					<div class="modal-body">
						<div id="graphic-porcentaje_departamentos" style="height: 50vh"></div>
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<?php
	}

	static public function Tickets()
	{
		?>
		<div class="modal fade modal-cerrarTicket" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<form id="cerrar" method="POST" action="test/index.php">
						<div class="modal-header bg-primary text-center">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="fa fa-plus"></span> Modificación de ticket</h4>
						</div>
						<div class="modal-body">
							<div class="col-md-10 col-md-offset-1">
								<div class="row">
									<div class="col-md-5">
										Fecha de apertura: <br><small class="fecha_apertura"></small>.
									</div>
									<div class="col-md-5">
										Solicitante: <br><small class="solicitante"></small>.
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										Registrante: <br><small class="registrante"></small>.
									</div>
									<div class="col-md-5">
										Responsable: <br><small class="responsable"></small>.
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										Departamento: <br><small class="departamento"></small>.
									</div>
									<div class="col-md-5">
										Seccion: <br><small class="seccion"></small>.
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										Estatus: <br><small class="estatus"></small>.
									</div>
									<div class="col-md-5">
										Colaborador: <br><small class="colaborador"></small>.
									</div>
								</div>
							</div>
							<input type="hidden" id="id" name="id">
							<input type="hidden" name="token" value="5">
							<div class="col-md-12">
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="solucion">Trabajo Realizado:</label>
									<input type="text" id="solucion" class="form-control" name="solucion">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="prioridad2">Prioridad de Atención:</label>
									<select name="prioridad" id="prioridad2" class="form-control" required>
										<option value="" selected>Seleccione la prioridad</option>
										<option value="1">Alto</option>
										<option value="2">Medio</option>
										<option value="3">Bajo</option>
									</select>
								</div>
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="colaborador">Colaborador:</label>
									<select id="colaborador" class="form-control" name="colaborador[]" multiple></select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span>Estatus: </span><br>
									<div class="radio">
										<label class="radio-inline">
											<input type="radio" name="estatus" id="radioEstatus" value="1">
											Abierto.
										</label>
									</div>
									<div class="radio">
										<label class="radio-inline">
											<input type="radio" name="estatus" id="radioEstatus" value="2">
											En Proceso.
										</label>
									</div>
									<div class="radio">
										<label class="radio-inline">
											<input type="radio" name="estatus" id="radioEstatus" value="3">
											Cerrado.
										</label>
									</div>
								</div>
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="responsable">Transferir ticket:</label>
									<select name="responsable" id="responsable" class="form-control">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span class="fa fa-"></span>
									<label for="serial">Serial del equipo:</label>
									<input type="text" id="serial" class="form-control" name="serial" placeholder="Debe ingresar un serial.">
									<input type="hidden" id="idserial" name="idserial">
								</div>
							</div>
							<div id="serial" class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<span class="fa fa-"></span>
										<label for="memoria">Memoria del equipo:</label>
										<input type="text" id="memoria" class="form-control" name="memoria" placeholder="Ingrese un memoria.">
									</div>
									<div class="form-group">
										<span class="fa fa-"></span>
										<label for="procesador">Procesador del equipo:</label>
										<input type="text" id="procesador" class="form-control" name="procesador" placeholder="Ingrese un procesador.">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<span class="fa fa-"></span>
										<label for="modelo">Modelo del equipo:</label>
										<input type="text" id="modelo" class="form-control" name="modelo" placeholder="Ingrese el modelo.">
									</div>
									<div class="form-group">
										<span class="fa fa-"></span>
										<label for="disco">Disco del equipo:</label>
										<input type="text" id="disco" class="form-control" name="disco" placeholder="Ingrese datos sobre el disco.">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<span class="fa fa-"></span>
										<label for="observaciones">Descripción del equipo:</label>
										<input type="text" id="observaciones" class="form-control" name="observaciones" placeholder="Ingrese las observaciones presentes.">
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<span class="msg pull-left"></span>
							<span class="print"></span>
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
							<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Registrar</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade modal-registrar" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-plus"></span> Registrar ticket</h4>
					</div>
					<form id="registro">
						<div class="modal-body">
							<div class="col-md-6">
								<div class="form-group">
									<span class="fa fa-calendar"></span>
									<label for="fecha">Fecha de apertura:</label>
									<input type="text" id="fecha" class="form-control" name="fecha" readonly>
								</div>
								<div class="form-group">
									<span class="fa fa-clock-o"></span>
									<label for="hora">Hora de apertura:</label>
									<input type="text" id="hora" class="form-control" name="hora" readonly>
								</div>
								<div class="form-group">
									<span class="fa fa-user-circle"></span>
									<label for="solicitante">*Solicitante:</label>
									<input type="text" id="solicitante" class="form-control" name="solicitante" required placeholder="Nombre y aprellido del solicitante">
								</div>
								<div class="form-group">
									<span class="fa fa-building"></span>
									<label for="searchDep">*Departamento:</label>
									<input type="text" id="searchDep" class="form-control" name="searchDep" required placeholder="Ubicacion del departamento" autofocus="" list="asd" autocomplete="off">
									<input id="direccion" type="hidden" value="" name="direccion" name="direccion">
									<input id="division" type="hidden" value="" name="division" name="division">
									<datalist id="asd"></datalist>
								</div>
								<div class="form-group">
									<span class="fa fa-file-text"></span>
									<label for="detalles">*Resumen del Problema Informático:</label><br>
									<textarea id="detalles" class="form-control" name="detalles" placeholder="Coloque el resumen de la solicitud realizada por usuario" required></textarea><br>
								</div>
								<div class="form-group">
									<span class="fa fa-group"></span>
									<label for="colaborador">Colaborador (Seleccione Presionando "control"):</label><br>
									<select id="colaborador" class="form-control" name="colaborador[]" multiple>
										<option value="Sin colaborador" selected>Sin colaborador</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span class="fa fa-sort-numeric-asc"></span>
									<label for="prioridad">* Prioridad:</label>
									<select  id="prioridad" class="form-control" name="prioridad" required>
										<option value="">Seleccione la prioridad</option>
										<option value="3">Bajo</option>
										<option value="2">Medio</option> 
										<option value="1">Alto</option>
									</select>
								</div>
								<div class="form-group">
									<span class="fa fa-id-card-o"></span>
									<label for="idTecnico">*Responsable:</label>
									<select id="idTecnico" class="form-control" name="idTecnico" required>
									</select>
								</div>
								<div class="form-group">
									<span class="fa fa-exclamation-triangle"></span>
									<label for="searchprob">*Problema Informático:</label>
									<input type="text" id="searchprob" class="form-control" name="searchprob" required placeholder="Seleccione el problema" autofocus="" list="problem" autocomplete="off">
									<datalist id="problem"></datalist>
									<input type="hidden" id="categoria" name="categoria" value=""></input>
									<input type="hidden" id="problema_i" name="problema_i" value=""></input>
									<input type="hidden" id="problema_ii" name="problema_ii" value=""></input>
								</div>
								<div class="form-group">
									<span class="fa fa-barcode"></span>
									<label for="serial">BN / Serial:</label>
									<input type="text" id="serial" class="form-control" name="serial" placeholder="Serial del Bien Nacional">
								</div>
								<div class="message text-center"></div>
							</div>
							<input type="hidden" name="id" value="-1" />
							<input type="hidden" name="token" value="3" />
							<input type="hidden" name="coordinacion" value="" />
						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
							<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Guardar</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<?php
	}

	public function __destruct()
	{
		?>
		<div class="modal fade modal-abrirTicket" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="fa fa-eye"></span> Ver ticket</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-10 col-md-offset-1">
							<table id="datosTicket" class="table table-bordered table-condensed table-hover table-striped">
								<tr>
									<td>Fecha de Solicitud:</td>
									<td class="fecha_apertura"></td>
								</tr>
								<tr>
									<td>Hora:</td>
									<td class="hora"></td>
								</tr>
								<tr>
									<td>Registrante:</td>
									<td class="registrante"></td>
								</tr>
								<tr>
									<td>Departamento:</td>
									<td class="departamento"></td>
								</tr>
								<tr>
									<td>seccion:</td>
									<td class="seccion"></td>
								</tr>
								<tr>
									<td>Solicitante:</td>
									<td class="solicitante"></td>
								</tr>
								<tr>
									<td>Problema Descrito:</td>
									<td class="detalles"></td>
								</tr>
								<tr>
									<td>Problema informático:</td>
									<td class="problema"></td>
								</tr>
								<tr>
									<td>Problema especifico:</td>
									<td class="subproblema"></td>
								</tr>
								<tr>
									<td>Solución aplicada:</td>
									<td class="solucion"></td>
								</tr>
								<tr>
									<td>Estatus de la solicitud:</td>
									<td class="estatus"></td>
								</tr>
								<tr>
									<td>Responsable:</td>
									<td class="responsable"></td>
								</tr>
								<tr>
									<td>Último en revisar:</td>
									<td class="ultimo"></td>
								</tr>
								<tr>
									<td>Colaborador:</td>
									<td class="colaborador"></td>
								</tr>
								<tr>
									<td>prioridad:</td>
									<td class="prioridad"></td>
								</tr>
								<tr>
									<td>Informe técnico:</td>
									<td class="informe"></td>
								</tr>
								<tr>
									<td>Serial:</td>
									<td class="serial"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<!-- <a id="imprimir" class="btn btn-warning" href="#" data-toggle="tooltip" data-placement="top" title="Imprimir Informe"><span class="glyphicon glyphicon-print"></span></a> -->
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

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
		<?php
	}
} /* Final de la clase Modales */
