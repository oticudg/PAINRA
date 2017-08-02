<div class="modal fade modal-contraseña" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"><span class="fa fa-cog"></span> Cambiar contraseña</h3>
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
							<input type="hidden" name="token" value="2">
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