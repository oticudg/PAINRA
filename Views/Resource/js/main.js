$(document).ready(function () {
	var url = $("meta[url]").attr("url");
	/*
	* Configuraciones
	*/
	/*se trae la pantalla de inicio*/
	content("inicio");
	/*se llena la tabla de soportistas*/
	llenarSoportistas();
	/* Inicializo los tooltips */
	$('[data-toggle="tooltip"]').tooltip();
	/*el preload circular*/
	$("#page-loader").fadeOut(1000);
	/*
	* Eventos
	*/
	/* Recarga la pagina por ajax */
	$("a#enlace").click(function (e) {
		e.preventDefault();
		$("a#enlace").parent().removeClass("active");
		$(this).parent().addClass("active");
		content($(this).attr("href"));
	});
	/* Cierra el login abierto */
	$("a#logout").click(function (e) {
		e.preventDefault();
		$.ajax({
			url: url+"Ajax/logout",
			data: { token: 2, operation: "logout" },
			type: "POST",
			success: function () {
				window.location = url;
			}
		});
	});
	/*ajax para cambiar el pass*/
	$("form#password").submit(function (e) {
		e.preventDefault();
		var data = $(this).serializeArray();
		if (data[0].value.length > 7 && data[1].value.length > 7) {
			if (data[0].value == data[1].value) {
				data.push({ name: "operation", value: "cambioPass" });
				$.ajax({
					url: url+"Ajax/cambioPass",
					type: "POST",
					dataType: "json",
					data: data,
					beforeSend: function () {
						$(".fa-spinner").css("display","inline-block");
					}
				})
				.done(function() {
					$(".menssage").html('<span class="alert alert-success" role="alert"><b><span class="glyphicon glyphicon-ok"></span> Cambio Exitoso <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></b></span>');
					setTimeout(function () {
						$(".modal-contraseña").modal("toggle");
						$("form#password")[0].reset();
						$("span.alert.alert-danger").remove();
						$("span.alert.alert-success").remove();
					}, 1000);
				})
				.fail(function() {
					$(".menssage").html('<span class="alert alert-danger" role="alert"><b>Error al Cambiar la contraseña.</b></span>');
				});
			} else {
				$(".menssage").html('<span class="alert alert-warning" role="alert"><b><span class="glyphicon glyphicon-exclamation-sign"></span> Los valores ingresados no coinciden.</b></span>');
			}
		} else {
			$(".menssage").html('<span class="alert alert-warning" role="alert"><b><span class="glyphicon glyphicon-exclamation-sign"></span> La constraseña debe tener mas de 8 caracteres.</b></span>');
		}
	});
	/* 
	* Departamentos
	*/
	$(".modal-departamentos select#direccion").ready(function () {
		$.ajax({
			url: url+"Ajax/buscarDepartamento",
			dataType: 'html',
			data: {
				operation: "departamentos",
				token: 12
			},
			type: "POST",
			success: function (res) {
				$(".modal-departamentos select#direccion").html(res);
			}
		});
	});
	$(".modal-departamentos select#direccion").change(function () {
		$.ajax({
			url: url+"Ajax/buscarDepartamento",
			dataType: 'html',
			data: {
				operation: "departamentos",
				token: 13,
				num: $(this).val()
			},
			type: "POST",
			success: function (res) {
				$(".modal-departamentos select#division").html(res);
			}
		});
	});
	$(".modal-departamentos button#registrarD").click(function () {
		$(".modal-registrarDepartamento form#registrarDepartamento")[0].reset();
		$("input#id_direccion").val(-1);
		$("input#id_division").val(-1);
		$(".modal-registrarDepartamento h4").html('<span class="fa fa-plus"></span> Registrar Departamento');
		$("form#registrarDepartamento input#division").parent().show();
		$("form#registrarDepartamento input#division").attr("type", "text");
		$(".modal-registrarDepartamento").modal("toggle");
	});
	$(".modal-departamentos select#division").change(function () {
		$(".modal-departamentos button#editarD").attr("ren", $(this).val())
		$(".modal-departamentos button#eliminarD").attr("ren", $(this).val())
	});
	$(".modal-departamentos button#eliminarD").click(function () {
		if ($(this).attr("ren")) {
			direccion = $("select#direccion").val();
			direccion = $("select#direccion option[value="+direccion+"]").text();
			division = $("select#division").val();
			division = $("select#division option[value="+division+"]").text();
			$(".modal-help h4").html('<span class="fa fa-trash"></span> Eliminar Departamento');
			$(".modal-help .modal-body .help").html('<h3 class="text-center">¿Esta seguro de eliminar este departamento?</h3> <div class="col-md-8 col-md-offset-2 help"> <div class="form-group"> <span class="fa fa-cubes"></span> <label for="direccion">Dirección:</label> <input type="text" id="direccion" class="form-control" name="direccion" readonly value="'+direccion+'"> </div> <div class="form-group"> <span class="fa fa-cube"></span> <label for="division">División:</label> <input type="text" id="division" class="form-control" name="division" readonly value="'+division+'"> </div> </div>');
			$(".modal-help .modal-footer .btnn").html('<button class="btn btn-primary" id="confirmarDep" ren="'+$(this).attr("ren")+'"><span class="glyphicon glyphicon-ok"></span> Confirmar</button>')
			$(".modal-help").modal("toggle");
			$(".modal-help button#confirmarDep").click(function () {
				$.ajax({
					url: url+"Ajax/deleteDepartamento",
					dataType: 'json',
					data: {
						token: 14,
						num: $(this).attr("ren")
					},
					type: "POST",
					success: function (res) {
						swal({
							title: '¡Borrado Exitoso!',
							type: 'success',
							timer: 2000
						}).then(
						function () {},
						function (dismiss) {
							$(".modal-help").modal("toggle");
							direccion = $("select#direccion").val("");
							division = $("select#division").val("");
						});
					}
				});
			});
		}
	});
	$("datalist#direcciones").ready(function () {
		$.ajax({
			url: url+"Ajax/buscarDepartamento",
			dataType: 'html',
			data: {
				operation: "departamentos",
				token: 12
			},
			type: "POST",
			success: function (res) {
				$(".modal-registrarDepartamento datalist#direcciones").html(res);
			}
		});
	});
	$(".modal-registrarDepartamento form#registrarDepartamento").submit(function (e) {
		e.preventDefault();
		var data = $(this).serializeArray();
		data.push({ name: "token", value: "15" });
		$.ajax({
			url: url+"Ajax/registrarDepartamento",
			dataType: 'json',
			data: data,
			type: "POST",
			success: function (res) {
				swal({
					title: '¡Registro Exitoso!',
					type: 'success',
					timer: 2000
				}).then(
				function () {},
				function (dismiss) {
					$(".modal-registrarDepartamento").modal("toggle");
					$("form#registrarDepartamento")[0].reset();
				});
			}
		})
		.fail(function() {
			swal({
				title: '¡Error al Registrar!',
				type: 'error',
				timer: 2000
			});
		});
	});
	$("form#registrarDepartamento input#direccion").change(function () {
		num = $("datalist#direcciones option[value='"+$(this).val()+"']").attr("ren");
		if (num) {
			$("form#registrarDepartamento input#id_direccion").val(num);
			$("form#registrarDepartamento input#division").parent().show();
			$("form#registrarDepartamento input#division").attr("type", "text");
		} else {
			$("form#registrarDepartamento input#division").parent().hide();
			$("form#registrarDepartamento input#division").attr("type", "hidden");
		}
	});
	$(".modal-departamentos button#editarD").click(function () {
		if ($(this).attr("ren")) {
			iddireccion = $(".modal-departamentos select#direccion").val();
			direccion = $(".modal-departamentos select#direccion option[value="+iddireccion+"]").html();
			iddivision = $("select#division").val();
			division = $("select#division option[value="+iddivision+"]").text();
			$("form#registrarDepartamento input#direccion").val(direccion);
			$("form#registrarDepartamento input#id_direccion").val(iddireccion);
			$("form#registrarDepartamento input#division").val(division);
			$("form#registrarDepartamento input#id_division").val(iddivision);
			$(".modal-registrarDepartamento h4").html('<span class="fa fa-edit"></span> Editar Departamento');
			$(".modal-registrarDepartamento").modal("toggle");
		}
	});
	/*
	* Servicios
	*/
	$(".modal-servicios").modal("toggle");
	var addEditservicios;
	$(".modal-servicios select#categoria").ready(function () {
		$.ajax({
			url: url+"Ajax/buscarSolicitudes",
			dataType: 'html',
			data: {
				operation: "solicitudes",
				token: 16
			},
			type: "POST",
			success: function (res) {
				$(".modal-servicios select#categoria").html(res);
			}
		});
	});
	$(".modal-servicios select#categoria").change(function () {
		var num = $(this).val();
		$(".modal-servicios #editarS").attr("ren", num);
		$(".modal-servicios #editarS").attr("num", 1);
		$(".modal-servicios #eliminarS").attr("ren", num);
		$(".modal-servicios #eliminarS").attr("num", 1);
		$.ajax({
			url: url+"Ajax/buscarSolicitudes",
			dataType: 'html',
			data: {
				operation: "solicitudes",
				token: 17,
				num: $(this).val()
			},
			type: "POST",
			success: function (res) {
				$(".modal-servicios select#subproblema").html("");
				$(".modal-servicios select#problema").html(res);
			}
		});
	});
	$(".modal-servicios select#problema").change(function () {
		var num = $(this).val();
		$(".modal-servicios #editarS").attr("ren", num);
		$(".modal-servicios #editarS").attr("num", 2);
		$(".modal-servicios #eliminarS").attr("ren", num);
		$(".modal-servicios #eliminarS").attr("num", 2);
		$.ajax({
			url: url+"Ajax/buscarSolicitudes",
			dataType: 'html',
			data: {
				operation: "solicitudes",
				token: 18,
				num: $(this).val()
			},
			type: "POST",
			success: function (res) {
				$(".modal-servicios select#subproblema").html(res);
			}
		});
	});
	$(".modal-servicios select#subproblema").change(function () {
		var num = $(this).val();
		$(".modal-servicios #editarS").attr("ren", num);
		$(".modal-servicios #editarS").attr("num", 3);
		$(".modal-servicios #eliminarS").attr("ren", num);
		$(".modal-servicios #eliminarS").attr("num", 3);
	});
	$(".modal-servicios #eliminarS").click(function () {
		if ($(this).attr("ren")) {
			num = $(this).attr("num");
			$(".modal-help h4").html('<span class="fa fa-trash"></span> Eliminar Servicio.');
			if (num == 1) {select = "categoria";}
			else if (num == 2) {select = "problema";}
			else if (num == 3) {select = "subproblema"; }
			valor = $(".modal-servicios select#"+select).val();
			elemento = $(".modal-servicios select#"+select+" option[value="+valor+"]").html();
			$(".modal-help .help").html('<h4>¿Esta Seguro de eliminar este servicio?</h4> <div class="form-group"><i class="fa fa-list" aria-hidden="true"></i> <label>'+select+':</label> <input type="text" class="form-control" value="'+elemento+'" disabled> </div>');
			$(".modal-help .btnn").html('<button type="button" class="btn btn-primary" id="confirmDeleteServicio" ren="'+valor+'" num="'+num+'"><span class="glyphicon glyphicon-ok"></span> Confirmar</button>');
			$(".modal-help #confirmDeleteServicio").click(function () {
				$.ajax({
					url: url+"Ajax/deleteServicio",
					dataType: 'json',
					data: {
						token: 19,
						ren: $(this).attr("ren"),
						num: $(this).attr("num")
					},
					type: "POST",
					success: function (res) {
						$(".modal-help").modal("toggle");
						alerta('¡Borrado Exitoso!', 'success');
					}
				}).fail(function() {
					alerta('¡Error al Borrar!', 'error');
				});
			});
			$(".modal-help").modal("toggle");
		}
	});
	$(".modal-registroServicios datalist#categorias").ready(function () {
		$.ajax({
			url: url+"Ajax/buscarSolicitudes",
			dataType: 'html',
			data: {
				operation: "solicitudesRegistro",
				token: 19
			},
			type: "POST",
			success: function (res) {
				$(".modal-registroServicios datalist#categorias").html(res);
			}
		});
	});
	$(".modal-registroServicios input#categoria").change(function () {
		var html = $(this).val(),
		id = $("datalist#categorias option[value='"+html+"'").html();
		if (id) {
			$.ajax({
				url: url+"Ajax/buscarSolicitudes",
				dataType: 'html',
				data: {
					operation: "solicitudesRegistro",
					token: 21,
					num: id
				},
				type: "POST",
				success: function (res) {
					$("input[type='hidden']#idcategoria").val(id);
					$("input[type='hidden']#idproblema").parent().show();
					$("input#problema").attr("type", "text");
					$("datalist#problemas").html(res);
				}
			});
		} else if (addEditservicios != 2) {
			$("input[type='hidden']#idproblema").parent().hide();
			$("input[type='hidden']#idsubproblema").parent().hide();
			$("input[type='hidden']#idproblema").val(-1);
			$("input[type='hidden']#idsubproblema").val(-1);
			$("input#idcategoria").val(-1);
			$("input#problema").attr("type", "hidden");
			$("input#subproblema").attr("type", "hidden");
			$("input#problema").val("");
			$("input#subproblema").val("");
		}
	});
	$(".modal-registroServicios input#categoria").change(function () {
		var html = $(this).val();
		id = $("datalist#categorias option[value='"+html+"'").html();
		$.ajax({
			url: url+"Ajax/buscarSolicitudes",
			dataType: 'html',
			data: {
				operation: "solicitudesRegistro",
				token: 21,
				num: id
			},
			type: "POST",
			success: function (res) {
				$("datalist#problemas").html(res);
			}
		});
	});
	$(".modal-registroServicios input#problema").change(function () {
		var html = $(this).val();
		id = $("datalist#problemas option[value='"+html+"'").html();
		if (id) {
			$("input[type='hidden']#idproblema").val(id);
			$("input#subproblema").attr("type", "text");
			$("input[type='hidden']#idsubproblema").parent().show();
		} else if (addEditservicios != 2) {
			$("input[type='hidden']#idproblema").val(-1);
			$("input[type='hidden']#idsubproblema").val(-1);
			$("input#subproblema").attr("type", "hidden");
			$("input[type='hidden']#idsubproblema").parent().hide();
		}
	});
	$(".modal-servicios #registrarS").click(function () {
		addEditservicios = 1;
		$("input[type='hidden']#idcategoria").val(-1);
		$("input[type='hidden']#idproblema").val(-1);
		$("input[type='hidden']#idsubproblema").val(-1);
		$("input#problema").attr("type", "text");
		$("input#problema").attr("value", "");
		$("input#subproblema").attr("type", "text");
		$("input#subproblema").attr("value", "");
		$("input[type='hidden']#idproblema").parent().show();
		$("input[type='hidden']#idsubproblema").parent().show();
		$("form#registroServicios")[0].reset();
		$(".modal-registroServicios").modal("toggle");
	});
	$(".modal-servicios #editarS").click(function () {
		$("form#registroServicios")[0].reset();
		addEditservicios = 2;
		if ($(this).attr("ren")) {
			num = $(this).attr("num");
			if (num >= 1) {
				nCategoria = $("select#categoria").val();
				categoria = $("select#categoria option[value="+nCategoria+"]").html();
				$(".modal-registroServicios input#categoria").val(categoria);
				$(".modal-registroServicios input#idcategoria").val(nCategoria);
				if (num >= 2) {
					nProblema = $("select#problema").val();
					problema = $("select#problema option[value="+nProblema+"]").html();
					$(".modal-registroServicios input#problema").val(problema);
					$(".modal-registroServicios input#idproblema").val(nProblema);
					$(".modal-registroServicios input#problema").parent().show();
				}
				if (num >= 3) {
					nSubproblema = $("select#subproblema").val();
					subproblema = $("select#subproblema option[value="+nSubproblema+"]").html();
					$(".modal-registroServicios input#subproblema").val(subproblema);
					$(".modal-registroServicios input#idsubproblema").val(nSubproblema);
					$(".modal-registroServicios input#subproblema").parent().show();
				}
			}
			if ($(".modal-registroServicios input#problema").val() == '') {
				$(".modal-registroServicios input#idproblema").parent().hide();
				$(".modal-registroServicios input#idproblema").val(-1);
			}
			if ($(".modal-registroServicios input#subproblema").val() == '') {
				$(".modal-registroServicios input#idsubproblema").parent().hide();
				$(".modal-registroServicios input#idsubproblema").val(-1);
			}
			$(".modal-registroServicios").modal("toggle");
		}
	});
	$(".modal-registroServicios form#registroServicios").submit(function (e) {
		e.preventDefault();
		var data = $(this).serializeArray();
		data.push({ name: "token", value: "22" });
		$.ajax({
			url: url+"Ajax/registroServicios",
			type: "POST",
			dataType: "json",
			data: data,
			beforeSend: function () {
			}
		})
		.done(function(res) {
			alerta('¡Registro Exitoso!', 'success');
		})
		.fail(function() {
			alerta('¡Error al Borrar!', 'error');
		});
	});
	/* 
	* soportistas
	*/
	/* Realiza el registro al presionar el boton submit */
	$("#registrar-soportista").submit(function(e){
		e.preventDefault();
		var data = $(this).serializeArray();
		data.push({ name: "operation", value: "soportistasRegistrar" });
		data.push({ name: "token", value: "7" });
		$.ajax({
			url: url+"Ajax/soportistasRegistrar",
			type: 'POST',
			dataType: 'json',
			data: data,
			beforeSend: function () {
				$(".msg").html('<div class="alert alert-info" role="alert">Enviando Datos...<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><div>');
			}
		})
		.done(function(resul) {
			if (resul == false) {
				$(".msg").html('<div class="alert alert-danger" role="alert"> <span class="fa fa-exclamation-triangle"></span> Ya existe este usuario o cedula.<div>');
			} else {
				$(".msg").html('<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Datos Recibidos Exitosamente...<div>');
				setTimeout(function () {
					$('.modal-soportista-registrar').modal('toggle');
					$("form#registrar-soportista")[0].reset();
					$(".msg").html('');
					llenarSoportistas();
				}, 1000);
				setTimeout(function () {
					$("div.alert").fadeOut();
				}, 5000);
			}
		})
		.fail(function(resul) {
			$(".msg").html('<div class="alert alert-danger" role="alert">Error al enviar Datos...<div>');
		});
	});
	/* Abre el modal para registrar nuevo usuario */
	$("button.btn.btn-small.btn-primary#registrarU").click(function () {
		$("form#registrar-soportista.form")[0].reset();
		$(".modal-soportista-registrar select#rol").val("");
		$(".modal-soportista-registrar").modal("show");
		$("input[type='hidden']#id").attr("value", -1);
	});
	/* Abre el modal para editar usuario */
	$("button.btn#editarU").click(function (e) {
		e.preventDefault();
		if ($(this).attr("ren")) {
			$.ajax({
				url: url+"Ajax/verEditU",
				type: 'POST',
				dataType: 'json',
				data: {
					operation: "verU",
					token: 5,
					num: $(this).attr("ren")
				}
			})
			.done(function(resul) {
				$(".modal-soportista-registrar input#usuario").val(resul[0].usuario);
				$(".modal-soportista-registrar input#nombre").val(resul[0].nombre);
				$(".modal-soportista-registrar input#cedula").val(resul[0].cedula);
				$(".modal-soportista-registrar input#id").val(resul[0].id);
				$(".modal-soportista-registrar input#email").val(resul[0].email);
				$(".modal-soportista-registrar select#rol option").removeAttr("selected");
				var option = $(".modal-soportista-registrar select#rol option");
				for (var i = 0; i < option.length; i++) {
					if (resul[0].rol == option[i].text) {
						option[i].setAttribute("selected", "");
					}
				}
				$(".modal-soportista-registrar").modal("show");
			});
		}
	});
	/* Abre un modal para preguntar si se va a eliminar y al presionar el boton lo elimina. */
	$("button.btn#eliminarU").click(function (e) {
		e.preventDefault();
		var num = $(this).attr("ren");
		if (num) {
			var a = $("tr[ren="+num+"]").children("td"),
			nombre = a[1].innerHTML,
			cedula = a[2].innerHTML;
			$(".modal-help .modal-body .help").html('<div class="row"> <h4>¿Esta Seguro de Eliminar a '+nombre+'?.</h4> <div class="col-md-8 col-md-offset-2"> <label for="usuario">Usuario:</label> <input type="text" class="form-control" name="usuario" value="'+nombre+'" disabled> <label for="cedula">Cedula:</label> <input type="text" class="form-control" name="cedula" value="'+cedula+'" disabled> <br> </div> </div>');
			$(".modal-help h4.modal-title").html("<span class='glyphicon glyphicon-trash'></span> Eliminar Usuario");
			$(".modal-help .modal-footer span.btnn").html('<button type="button" class="btn btn-primary" id="confirmDeleteUser" ren="'+num+'"><span class="glyphicon glyphicon-ok"></span> Confirmar</button>');
			$(".modal-help").modal("show");
			$("button#confirmDeleteUser").click(function () {
				$.ajax({
					url: url+"Ajax/confirmDeleteUser",
					type: 'POST',
					dataType: 'json',
					data: {
						operation: "confirmDeleteUser",
						token: 6,
						num: $(this).attr("ren")
					},
					beforeSend: function () {
						$(".modal-help .modal-footer span.msg").html('<div class="alert alert-info" role="alert">Enviando Datos Enviados... <i class="fa fa-spinner fa-pulse fa-1x"></i></div>');
					}
				})
				.done(function(resul) {
					if (resul == true) {
						llenarSoportistas();
						$("button#eliminarU").attr("ren", "");
						$("button#editarU").attr("ren", "");
						$("button.btn#coordinacionU").fadeOut('2');
						swal('Borrado de Usuario', 'Exitoso...!', 'success');
						setTimeout(function () {
							$(".modal-help").modal("toggle");
							$(".modal-help .modal-footer span.msg").html('');
							$(".modal-help .modal-footer span.btnn").html('');
						}, 1500);
					} else {
						$(".modal-help .modal-footer span.msg").html('<div class="alert alert-danger" role="alert">Error al Ingresar Datos.</div>');
					}
				});
			});
		}
	});
	/* Abre el modal para registrar a los usuarios en una coordinacion */
	$("button.btn#coordinacionU").click(function(e) {
		e.preventDefault();
		$(".modal-soportistas-coordinacion input#iduser").attr("value", $(this).attr("ren"));
		$(".modal-soportistas-coordinacion").modal("toggle");
		if ($(this).attr("coord") == "") {
			$(".modal-soportistas-coordinacion select#tipo").html("<option value='-1' selected>Nuevo</option>");
			$(".modal-soportistas-coordinacion input#iduc").attr("value", "-1");
			$(".modal-soportistas-coordinacion button.deleteUC").hide();
			$('.modal-soportistas-coordinacion select#coordinacion').val("");
		} else {
			$(".modal-soportistas-coordinacion select#tipo").html("<option value='-1'>Nuevo</option> <option value='"+$(this).attr("coord")+"' selected>Actualización</option>");
			$(".modal-soportistas-coordinacion button.deleteUC").attr("ren", $(this).attr("coord"));
			$(".modal-soportistas-coordinacion input#iduc").attr("value", $(this).attr("coord"));
			$('.modal-soportistas-coordinacion select#coordinacion').val($(this).attr("idcoor"));
			$(".modal-soportistas-coordinacion button.deleteUC").show();
		}
	});
	/* Quita al usuario de la coordinacion */
	$(".modal-soportistas-coordinacion .deleteUC").click(function (e) {
		e.preventDefault();
		$.ajax({
			url: url+"Ajax/deleteUserCoordinacion",
			type: 'POST',
			dataType: 'json',
			data: {
				operation: "deleteUserCoordinacion",
				token: 9,
				id: $(this).attr("ren")
			}
		})
		.done(function(resul) {
			if (resul == true) {
				$("span.msgcoordinacion").html('<div class="alert alert-success" role="alert"> Borrado Exitoso <span class="glyphicon glyphicon-ok"></span> </div>');
				$("button.btn#coordinacionU").hide();
				$("button.btn#coordinacionU").removeAttr("ren");
				$("button.btn#coordinacionU").removeAttr("idcoor");
				$("button.btn#coordinacionU").removeAttr("coord");
			} else {
				$("span.msgcoordinacion").html('<div class="alert alert-danger" role="alert"> Error al Borrar <span class="glyphicon glyphicon-remove"></span> </div>');
			}
			setTimeout(function () {
				$("span.msgcoordinacion").html('');
				$(".modal-soportistas-coordinacion").modal("toggle");
				llenarSoportistas();
			}, 1000);
		})
	});
	/* Realiza el registro de la coordinacion para un usuario */
	$("form#form-user-coordinacion").submit(function (e) {
		e.preventDefault();
		var data = $(this).serializeArray();
		data.push({ name: "operation", value: "coordinacionRegistrar" });
		data.push({ name: "token", value: "8" });
		$.ajax({
			url: url+"Ajax/coordinacionRegistrar",
			type: 'POST',
			dataType: 'json',
			data: data,
			beforeSend: function () {
				$("span.msgcoordinacion").html('<div class="alert alert-info" role="alert"> Enviando Datos... <i class="fa fa-spinner fa-pulse fa-fw"></i> </div>');
			}
		})
		.done(function(resul) {
			if (resul == 0) {
				$("span.msgcoordinacion").html('<div class="alert alert-warning text-center" role="alert"> No se pudo realizar el registro <span class="fa fa-close"></span> </div>');
			} else {
				$("span.msgcoordinacion").html('<div class="alert alert-success" role="alert"> Datos Recibidos <span class="glyphicon glyphicon-ok"></span> </div>');
				setTimeout(function () {
					$("span.msgcoordinacion").html('');
					$(".modal-soportistas-coordinacion").modal("toggle");
					llenarSoportistas();
				}, 1000);
			}
			setTimeout(function () {
				$("span.msgcoordinacion").html('');
			}, 5000);
		})
		.fail(function() {
			$("span.msgcoordinacion").html('<div class="alert alert-danger" role="alert"> Error al registrar los datos. <span class="glyphicon glyphicon-remove"></span> </div>');
		});
	});
	// /*ajax para buscar el ticket por el input*/
	// $("form#ticket").submit(function (e) {
	// 	e.preventDefault();
	// 	var data = $(this).serializeArray();
	// 	if (data[0].value == "") {
	// 		alert("Debe ingresar un valor numerico");
	// 	} else {
	// 		buscarTicket(data[0].value);
	// 	}
	// });
	// /*ajax para registrar ticket*/
	// $("form#registro").submit(function (e) {
	// 	e.preventDefault();
	// 	var data = $(this).serializeArray();
	// 	data.push({ name: "operation", value: "registrar" });
	// 	$.ajax({
	// 		url: "resource/procesos/process.php",
	// 		type: "POST",
	// 		dataType: "json",
	// 		data: data,
	// 		beforeSend: function () {
	// 			$('i.fa-spinner').show();
	// 			$('div.message').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><div class="alert alert-info" role="alert">Enviando Datos...</div>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		if (resul.estado == true) {
	// 			$('div.message').html('<div class="alert alert-success" role="alert">Ticket Registrado con Exito<br>n° de ticket: '+resul.lastId+'.</div>');
	// 			$('#tabla').DataTable().ajax.reload();
	// 			setTimeout(function () {
	// 				$('.modal-registrar').modal('toggle');
	// 				$("form#registro")[0].reset();
	// 			}, 5000);
	// 		}
	// 		if (resul.estado == false) {
	// 			$('div.message').html('<div class="alert alert-danger" role="alert">Un Ticket ya se Encuentra Registrado para este Equipo.<br> con el n°: '+resul.ticket+'.</div>');
	// 		}
	// 	})
	// 	.fail(function() {
	// 		$('div.message').html('<div class="alert alert-danger" role="alert">Error al Enviar los datos.<br>Consulte a su programador. </div>');
	// 		$('div.message').addClass('bg-danger');
	// 	})
	// 	.always(function() {
	// 		setTimeout(function () {
	// 			$("form#registro")[0].reset();
	// 			$('div.message').html('');
	// 		}, 15000);
	// 	});
	// });
	// /*llena el combo direccion consus respectivas direcciones y el categoria del problema */
	// $("form#registro select#direccion").ready(function (e) {
	// 	$.ajax({
	// 		url: "resource/procesos/direcciones.php?direccion=direccion",
	// 		type: "POST",
	// 		dataType: "json"
	// 	})
	// 	.done(function(resul) {
	// 		$('form#registro select#direccion').html(resul);
	// 	})
	// 	.fail(function() {
	// 		$('form#registro select#direccion').html('<option>Error al Buscar<option>');
	// 	});
	// 	$.ajax({
	// 		url: "resource/procesos/problemas.php?categoria=categoria",
	// 		type: "POST",
	// 		dataType: "json",
	// 	})
	// 	.done(function(resul) {
	// 		$('form#registro select#categoria').html(resul);
	// 	})
	// 	.fail(function() {
	// 		$('form#registro select#categoria').html('<option>Error al Buscar<option>');
	// 	});
	// });
	// /*llena el combo division buscando con respecto a la direccion seleccionada*/
	// $("form#registro select#direccion").change(function (e) {
	// 	var valor = $(this).val();
	// 	$.ajax({
	// 		url: "resource/procesos/direcciones.php?division="+valor,
	// 		type: "POST",
	// 		dataType: "json",
	// 		beforeSend: function () {
	// 			$('form#registro select#division').html('<option>Buscando division...<option>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		$('form#registro select#division').html(resul);
	// 	})
	// 	.fail(function() {
	// 		$('form#registro select#division').html('<option>Error al Buscar<option>');
	// 	});
	// });
	// /*llena el combo problema_i buscando con respecto a la categoria seleccionada*/
	// $("form#registro select#categoria").change(function (e) {
	// 	var valor = $(this).val();
	// 	$.ajax({
	// 		url: "resource/procesos/problemas.php?problema_i="+valor,
	// 		type: "POST",
	// 		dataType: "json",
	// 		beforeSend: function () {
	// 			$('form#registro select#problema_i').html('<option>Buscando problemas relacionados...<option>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		$('form#registro select#problema_i').html(resul);
	// 	})
	// 	.fail(function() {
	// 		$('form#registro select#problema_i').html('<option>Error al Buscar<option>');
	// 	});
	// });
	// /*llena el combo problema_ii buscando con respecto al problema_i seleccionado*/
	// $("form#registro select#problema_i").change(function (e) {
	// 	var valor = $(this).val();
	// 	$.ajax({
	// 		url: "resource/procesos/problemas.php?problema_ii="+valor,
	// 		type: "POST",
	// 		dataType: "json",
	// 		beforeSend: function () {
	// 			$('form#registro select#problema_ii').html('<option>Buscando problemas relacionados...<option>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		$('form#registro select#problema_ii').html(resul);
	// 	})
	// 	.fail(function() {
	// 		$('form#registro select#problema_ii').html('<option>Error al Buscar<option>');
	// 	});
	// });
	// /*ajax para cerrar tickets*/
	// $("form#cerrar").submit(function (e) {
	// 	e.preventDefault();
	// 	var data = $(this).serializeArray();
	// 	var cond = true;
	// 	if (data[7].value == 'Cerrado') {
	// 		if (data[8].value == '' || data[9].value == '' || data[10].value == '' || data[11].value == '' || data[12].value == '') {
	// 			$("span.msg").html('<span class="alert alert-warning" role="alert">Debe ingresar todos los Datos.</span>');
	// 			cond = false;
	// 		}
	// 		if (data[2].value == '') {
	// 			$("span.msg").html('<span class="alert alert-warning" role="alert">Debe ingresar la solucion.</span>');
	// 			cond = false;
	// 		}
	// 	}
	// 	if (cond) {
	// 		data.push({ name: "operation", value: "cerrar" });
	// 		$.ajax({
	// 			url: "resource/procesos/process.php",
	// 			type: "POST",
	// 			dataType: "json",
	// 			data: data,
	// 			beforeSend: function () {
	// 				$("span.msg").html('<span class="alert alert-info" role="alert">Enviando Datos...<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i> </span>');
	// 			}
	// 		})
	// 		.done(function(resul) {
	// 			$("span.msg").html('<span class="alert alert-success" role="alert">Datos Enviados Exitosamente...</span>');
	// 			$('#tabla').DataTable().ajax.reload();
	// 			setTimeout(function () {
	// 				$(".modal-cerrarTicket").modal("toggle");
	// 				$("form#cerrar")[0].reset();
	// 			}, 1000);
	// 		})
	// 		.fail(function(resul) {
	// 			$("span.msg").html('<span class="alert alert-danger" role="alert">Error al Recibir Datos, Intente mas tarde.</span>');
	// 		})
	// 		.always(function() {
	// 			setTimeout(function () {
	// 				$(".fa-spinner").hide();
	// 			}, 1000);
	// 		});
	// 	}
	// });

	// $("a#abrirTicket").click(function (e) {
	// 	e.preventDefault();
	// 	buscarTicket($(this).attr("ren"));
	// });



	// $("button#abrirModalRegistrar").click(function () {

	// 	$(".modal-soportista-registrar input#usuario").attr('value', '');
	// 	$(".modal-soportista-registrar input#nombre").attr('value', '');
	// 	$(".modal-soportista-registrar input#cedula").attr('value', '');
	// 	$(".modal-soportista-registrar input#id").attr('value', '-1');
	// 	$(".modal-soportista-registrar input#email").attr('value', '');
	// 	$(".modal-soportista-registrar select#privilegio option").removeAttr("selected");
	// 	$(".modal-soportista-registrar").modal("show");
	// });


	// $(".modal-soportistas-coordinacion form select#tipo").change(function () {
	// 	$(".modal-soportistas-coordinacion input#iduc").attr("value", $(this).val());
	// });

	/*
	* Funciones
	*/
	/* Trae por ajax el contenido de la pagina */
	var lastPag = '';
	function content(pag) {
		if (lastPag != pag) {
			$.ajax({
				url: url+"Ajax/paginacion",
				data: {
					modulo: pag,
					operation: "paginacion",
					token: 10
				},
				type: "POST",
				beforeSend: function () {
					$("#page-loader").fadeIn();
				},
				success: function (res) {
					$("div#contenido").html(res);
					lastPag = pag;
					$("#page-loader").fadeOut(500);
					paginas(pag);
				}
			});
		}
	};
	/* funcion que carga el contenido de las vistas que trae el ajax */
	function paginas(pag) {
		/*configuracion del datepicker*/
		$(".input-daterange").datepicker({
			todayBtn: "linked",
			clearBtn: true,
			language: "es",
			orientation: "bottom auto",
			forceParse: false,
			autoclose: true,
			todayHighlight: true
		});
		if (pag == 'inicio') {
			$.ajax({
				url: url+"Ajax/barrasEstadisticas",
				type: 'POST',
				dataType: 'json',
				data: {token: 11}
			})
			.done(function(resul) {
				var total = 0;
				for (var i = 0; i < resul.length; i++) {
					total += JSON.parse(resul[i].tickets);
					$("div."+resul[i].id+" strong").html(resul[i].descripcion+": "+resul[i].tickets);
					if (resul[i].id == 3) {cerrados = JSON.parse(resul[i].tickets);}
				}
				if ($("div.1 strong").html() == "") {$("div.1 strong").html("Abierto: 0");}
				if ($("div.2 strong").html() == "") {$("div.2 strong").html("En proceso: 0");}
				if ($("div.3 strong").html() == "") {$("div.3 strong").html("Cerrado: 0");}
				efectividad = (total != 0) ? ((cerrados*100)/total) : 0;
				$("div.total strong").html("Total de solicitudes: "+total);
				$("div.efectividad strong").html("Efectividad: "+efectividad.toFixed(2)+"%");
			});
			$.ajax({
				url: url+"Ajax/ticketsAbiertos",
				dataType: 'json',
				type: 'POST',
				data: {token: 23},
				success: function (res) {
					$(".modal-abiertos .datos").html(res.abiertos);
					$(".modal-enproceso .datos").html(res.enproceso);
				}
			});
			$.ajax({
				url: url+"Ajax/graphic_cerrados",
				type: "POST",
				dataType: "json",
				data: {
					token: 23
				}
			})
			.done(function(resul) {
				let options = {
					chart: {
						renderTo: 'graphic-cerrados',
						type: 'column',
						zoomType: 'xy'
					},
					title: {
						text: 'Total de solicitudes:'
					},

					lang: {
						downloadJPEG: "descargar imagen JPEG"
					},
					subtitle: {
						text: 'OTIC'
					},
					xAxis: {
						title: {
							text: 'Total de Solicitudes Realizadas a la OTIC'
						}
					},
					yAxis: {
						title: {
							text: 'Numero de Tickets Registrados'
						}
					},
					series: [{
						colorByPoint: true,
						showInLegend: false
					}],
					credits: {
						enabled: true,
						href: "http://www.highcharts.com",
						style: { "cursor": "pointer", "color": "#555", "fontSize": "10px" },
						text: "RennySuarez.com"
					}
				};
				options.xAxis.categories = resul.nombre;
				options.series[0].data = resul.tickets;
				var chart = Highcharts.chart(options);
			})
			.fail(function() {
				$('#graphic-cerrados').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
			});
			$.ajax({
				url: url+"Ajax/ticketsdepartamentos",
				type: "POST",
				dataType: "json",
				data: {
					token: 24,
				},
			})
			.done(function(resul) {
				let option = {
					chart: {
						renderTo: 'graphic-porcentaje_departamentos',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: 'Porcentaje de tickets Cerrados por Departamento'
					},
					tooltip: {
						pointFormat: '{series.name}: {series.y} <b>{point.percentage:.2f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f} %)',
								style: {
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								},
								connectorColor: '#337ab7'
							}
						}
					},
					series: [{
						name: 'Porcentaje Cerrados',
						data: []
					}]
				};
				for (var i = 0; i < resul.length; i++) {
					if (i == 0) {
						option.series[0].data.push({
							name: resul[i].departamento,
							y: JSON.parse(resul[i].tickets),
							sliced: true,
							selected: true
						});
					} else {
						option.series[0].data.push({
							name: resul[i].departamento,
							y: JSON.parse(resul[i].tickets)
						});
					}
				}
				var chart = Highcharts.chart(option);
			})
			.fail(function() {
				$('#graphic-porcentaje_departamentos').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
			});
		} else if (pag == 'tickets') {
			// $("#tabla").DataTable({
			// 	"order": [ 0, "desc" ],
			// 	"language": {
			// 		"sProcessing": "",
			// 		"sLengthMenu": "Mostrar _MENU_ registros",
			// 		"sZeroRecords": "No se encontraron resultados",
			// 		"sEmptyTable": "Ningún dato disponible en esta tabla",
			// 		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			// 		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			// 		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			// 		"sInfoPostFix": "",
			// 		"sSearch": "Buscar:",
			// 		"sUrl": "",
			// 		"sInfoThousands": ",",
			// 		"sLoadingRecords": "Cargando...",
			// 		"oPaginate": {
			// 			"sFirst": "Primero",
			// 			"sLast": "ultimo",
			// 			"sNext": "Siguiente",
			// 			"sPrevious": "Anterior"
			// 		},
			// 		"oAria": {
			// 			"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
			// 			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			// 		}
			// 	},
			// 	"processing": true,
			// 	"serverSide": true,
			// 	"ajax": {
			// 		url: 'resource/procesos/server_side_processing.php',
			// 		complete: function(data){
			// 			$("a#abrirTicket2").click(function (e) {
			// 				e.preventDefault();
			// 				buscarTicket($(this).attr("ren"));
			// 			});
			// 			$("a#editTicket").click(function (e) {
			// 				e.preventDefault();
			// 				$("span.msg").html('');
			// 				cerrarTicket($(this).attr("ren"));
			// 			});
			// 		}
			// 	}
			// });
		} else if (pag == 'departamentos') {
			$("form#formDepartamentos").submit(function (e) {
				e.preventDefault();
				var data = $(this).serializeArray();
				data.push({ name: "token", value: 26 });
				$.ajax({
					url: url+"Ajax/tablaEstDepartamentos",
					type: "POST",
					dataType: "json",
					data: data,
					beforeSend:function () {
						$("#page-loader").fadeIn();
					},
					success: function (resul) {
						var options = {
							chart: {
								renderTo: 'graphic',
								type: 'column'
							},
							title: {
								text: 'Numero de Registros'
							},
							subtitle: {
								text: ''
							},
							xAxis: {
								categories: [],
								title: {
									text: ''
								},
								crosshair: true
							},
							yAxis: {
								min: 0,
								title: {
									text: ''
								}
							},
							tooltip: {
								headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
								'<td style="padding:0"><b>{point.y} </b></td></tr>',
								footerFormat: '</table>',
								shared: true,
								useHTML: true
							},
							plotOptions: {
								column: {
									pointPadding: 0.2,
									borderWidth: 0
								}
							},
							series: [{
								name: "Registros",
								data: []
							}]
						};
						$("div#estadistica").show();
						let name = (data[2].name == 'Total') ? 'Coordinación' : 'Departamento'
						$("div#estadistica h2").html(resul.h2);
						$("div#estadistica table tbody").html("");
						$("div#estadistica table tfoot").html("");
						$("div#estadistica #graphic").html("");
						if (resul.tbody) {
							$("div#estadistica table tbody").html(resul.tbody);
							$("div#estadistica table tfoot").html(resul.tfoot);
							let len = resul.grafica.total.length
							for(i=0; i<=len ;i++){
								options.series[0].data.push(resul.grafica.total[i]);
								options.xAxis.categories.push((i+1)+": "+resul.grafica.coordinacion[i]);
							}
							options.title.text="<h1>Tickets Totales</h1>";
							chart = new Highcharts.Chart(options);
						}
						$("#page-loader").fadeOut(500);
					}
				}).fail(function(resul) {
					$('#graphic').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
				});
			});
		} else if (pag == 'personales') {
			$(".tb_estadistica").hide();
			$.ajax({
				url: url+"Ajax/usuarios",
				dataType: "json",
				type: "POST",
				data: {
					token: 5
				},
				success: function (resul) {
					$("select#responsable").html(resul);
				}
			});
			$("form#form-personales").submit(function (e) {
				e.preventDefault();
				var data = $(this).serializeArray();
				data.push({ name: "token", value: 24 });
				let option = null;
				option = {
					chart: {
						renderTo: 'grafica_soportistas',
						polar: true,
						type: 'line'
					},
					title: {
						text: 'Estatus de Tickets',
						x: -47
					},
					pane: {
						size: '100%'
					},
					xAxis: {
						categories: ['Cerradas', 'En proceso', 'Abiertas'],
						tickmarkPlacement: 'on',
						lineWidth: 0
					},
					yAxis: {
						gridLineInterpolation: 'polygon',
						lineWidth: 0,
						min: 0
					},
					tooltip: {
						shared: true,
						pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y}</b><br/>'
					},
					legend: {
						align: 'right',
						verticalAlign: 'top',
						y: 70,
						layout: 'vertical'
					},
					series: [{
						name: 'Tickets',
						color: '#337ab7',
						pointPlacement: 'on'
					}]
				};
				$('#grafica_soportistas').html('');
				$.ajax({
					url: url+"Ajax/ticketspersonales",
					type: "POST",
					dataType: "json",
					data: data,
					beforeSend: function () {
						$("#page-loader").fadeIn();
					}
				})
				.done(function(resul) {
					$(".tb_estadistica").show();
					option.series[0].data = [
					JSON.parse(resul.Cerrado),
					JSON.parse(resul.Proceso),
					JSON.parse(resul.Abierto)
					];
					var chart = Highcharts.chart(option);
					$('#Abierto').html(resul.Abierto);
					$('#Cerrado').html(resul.Cerrado);
					$('#Proceso').html(resul.Proceso);
					$('#Total').html(resul.Total);
					$('#Efectividad').html(resul.Efectividad.toFixed(2));
					$('h2#nombre').html("Ticket de "+resul.Soportista);
				})
				.fail(function(resul) {
					$('#Abierto').html(0);
					$('#Cerrado').html(0);
					$('#Proceso').html(0);
					$('#Total').html(0);
					$('#Efectividad').html(0);
					$('#grafica_soportistas').html('<h2 class="text-center">No posee ticket´s registrados.</h2>');
				})
				.always(function () {
					$("#page-loader").fadeOut(500);
				});
			});
		} else if (pag == 'mensuales') {
			$.ajax({
				url: url+"Ajax/usuarios",
				dataType: "json",
				type: "POST",
				data: {
					token: 5
				},
				success: function (resul) {
					$("select#responsable").html(resul);
				}
			});
			var options = {
				chart: {
					renderTo: 'container',
				},
				title: {
					text: 'Tickets Registrados Mensualmente (2014-2017)'
				},
				subtitle: {
					text: ''
				},
				yAxis: {
					title: {
						text: 'Numero de Tickets'
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y} Tickets</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					series: {
						pointStart: 1
					}
				},
				series: []
			};
			$.ajax({
				url: url+"Ajax/ticketsMensuales",
				type: "POST",
				dataType: "json",
				data: {
					token: 26,
					"graphic": 3
				},
			})
			.done(function(resul) {
				for (var i = 0; i < resul.length; i++) {
					options.series[i] = {
						name: resul[i][0].a,
						data: []
					};
					var count = 1;
					for (var o = 0; o < resul[i].length; o++) {
						if (count !== JSON.parse(resul[i][o].mes)) {
							for (var z = 1; z <= JSON.parse(resul[i][o].mes)-1; z++) {
								options.series[i].data.push(null);
							}
							o--; count++;
						} else {
							options.series[i].data.push(JSON.parse(resul[i][o].tickets));
							count++;
						}
					}
				};
				Highcharts.chart(options);
			})
			.fail(function() {
				$('#container').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
			});
		}
	}
	function alerta(string, tipo) {
		swal({
			title: string,
			type: tipo,
			timer: 2000
		}).then(
		function () {},
		function (dismiss) {});
	}
	/* Arma la tabla de soportistas en el modal */
	function llenarSoportistas() {
		$.ajax({
			url: url+"Ajax/soportistas",
			type: 'POST',
			dataType: 'html',
			data: {
				operation: "soportistas",
				token: 4
			}
		})
		.done(function(resul) {
			$(".tabla-soportistas").html(resul);
			$("tr#soportista").click(function () {
				var rol = $(this).attr("rol");
				$("tr#soportista").removeClass("activo");
				$(this).addClass("activo");
				$("button.btn#editarU").attr("ren", $(this).attr("ren"));
				$("button.btn#eliminarU").attr("ren", $(this).attr("ren"));
				if (rol == 2 || rol == 3) {
					$("button.btn#coordinacionU").fadeIn('2');
					$("button.btn#coordinacionU").attr("ren", $(this).attr("ren"));
					if ($(this).attr("coord")) {
						$("button.btn#coordinacionU").attr("coord", $(this).attr("coord"));
						$("button.btn#coordinacionU").attr("idcoor", $(this).attr("idcoor"));
					}else{
						$("button.btn#coordinacionU").attr("coord", "");
						$("button.btn#coordinacionU").attr("idcoor", "");
					}
				} else {
					$("button.btn#coordinacionU").fadeOut('2');
				}
			});
		})
		.fail(function() {
			$(".tabla-soportistas").html('<h2 class="text-center">Error al Cargar...<br>Consulte al Programador.</h2>');
		});
	}

	// function buscarTicket(num) {
	// 	if (!isNaN(num)) {
	// 		$.ajax({
	// 			url: "resource/procesos/process.php?operation=ticket",
	// 			type: "POST",
	// 			dataType: "json",
	// 			data: { "ticket": num },
	// 			beforeSend: function () {
	// 				$("#page-loader").show();
	// 			}
	// 		})
	// 		.done(function(resul) {
	// 			$('.modal-abrirTicket span.error').html('');
	// 			$('.modal-abrirTicket .modal-title').html("<h3>Ticket n°: "+resul[0].ide+".</h3>");
	// 			$('.modal-abrirTicket .fecha_apertura').html(resul[0].fecha_apertura);
	// 			$('.modal-abrirTicket .hora').html(resul[0].hora);
	// 			$('.modal-abrirTicket .registrante').html(resul[0].registrante);
	// 			$('.modal-abrirTicket .departamento').html(resul[0].departamento);
	// 			$('.modal-abrirTicket .seccion').html(resul[0].seccion);
	// 			$('.modal-abrirTicket .solicitante').html(resul[0].solicitante);
	// 			$('.modal-abrirTicket .detalles').html(resul[0].detalleF);
	// 			$('.modal-abrirTicket .problema').html(resul[0].problema);
	// 			$('.modal-abrirTicket .problema_especifico').html(resul[0].problema_especifico);
	// 			$('.modal-abrirTicket .solucion').html(resul[0].solucion);
	// 			$('.modal-abrirTicket .estatus').html(resul[0].estatus);
	// 			$('.modal-abrirTicket .estatus').removeClass('bg-danger bg-success bg-info');
	// 			switch (resul[0].estatus){
	// 				case("Abierto"): $('.modal-abrirTicket .estatus').addClass('bg-danger');
	// 				break;
	// 				case("En proceso"): $('.modal-abrirTicket .estatus').addClass('bg-info');
	// 				break;
	// 				case('Cerrado'): $('.modal-abrirTicket .estatus').addClass('bg-success');
	// 			}
	// 			$('.modal-abrirTicket .responsable').html(resul[0].cedula_soporte);
	// 			$('.modal-abrirTicket .ultimo').html(resul[0].transferencia);
	// 			$('.modal-abrirTicket .colaborador').html(resul[0].colaborador);
	// 			$('.modal-abrirTicket .informe').html(resul[0].solucion);
	// 			$('.modal-abrirTicket .serial').html(resul[0].serial);
	// 			$('.modal-abrirTicket .prioridad').html(resul[0].prioridad);
	// 			$('.modal-abrirTicket .print').html('<a id="imprimir" class="btn btn-success" href="reportes/informe.php?num='+resul[0].ide+'"> <span class="glyphicon glyphicon-print"></span> </a> ');
	// 			$('.modal-abrirTicket').modal('show');
	// 		})
	// 		.fail(function() {
	// 			$('.modal-abrirTicketError .modal-title').html("<h3>Error al Buscar.</h3>");
	// 			$('.modal-abrirTicketError div.error').html('<div class="alert alert-danger" role="alert"> <h3 class="text-center"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El ticket n°:'+num+'<br> No se Encuentra Registrado. </h3> </div>');
	// 			$('.modal-abrirTicketError').modal('show');
	// 		})
	// 		.always(function() {
	// 			$("#page-loader").fadeOut(1000);
	// 			$("form#ticket")[0].reset();
	// 		});
	// 	};
	// };

	// function cerrarTicket(num) {
	// 	if (!isNaN(num)) {
	// 		$.ajax({
	// 			url: "resource/procesos/process.php?operation=ticket",
	// 			type: "POST",
	// 			dataType: "json",
	// 			data: { "ticket": num },
	// 			beforeSend: function () {
	// 				$("#page-loader").show();
	// 			}
	// 		})
	// 		.done(function(resul) {
	// 			if (resul[0].estatus == 'Cerrado') {
	// 				$('.modal-abrirTicketError').modal('show');
	// 				$('.modal-abrirTicketError .modal-title').html('<h2>Ticket Cerrado</h2>');
	// 				$('.modal-abrirTicketError .modal-body .error').html('<div class="alert alert-danger" role="alert"> <h3 class="text-center"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> El ticket n°:'+resul[0].ide+'<br> Ya Se Encuentra Cerrado. </h3></div>');
	// 			} else {
	// 				$('.modal-cerrarTicket .modal-title').html("<h3>Resultado del Ticket n°: "+resul[0].ide+".</h3>");
	// 				$('.modal-cerrarTicket .fecha_apertura').html(resul[0].fecha_apertura);
	// 				$('.modal-cerrarTicket .registrante').html(resul[0].registrante);
	// 				$('.modal-cerrarTicket .responsable').html(resul[0].cedula_soporte);
	// 				$('.modal-cerrarTicket .departamento').html(resul[0].departamento);
	// 				$('.modal-cerrarTicket .seccion').html(resul[0].seccion);
	// 				$('.modal-cerrarTicket .solicitante').html(resul[0].solicitante);
	// 				$('.modal-cerrarTicket .estatus').html(resul[0].estatus);
	// 				$('.modal-cerrarTicket .colaborador').html(resul[0].colaborador);
	// 				$('.modal-cerrarTicket input#id').attr('value', resul[0].ide);
	// 				$('.modal-cerrarTicket input#solucion').attr('value', resul[0].solucion);
	// 				$('.modal-cerrarTicket .print').html('<a id="imprimir" class="btn btn-success" href="reportes/informe.php?num='+resul[0].ide+'"> <span class="glyphicon glyphicon-print"></span> </a> ');
	// 				as = $('.modal-cerrarTicket select#responsable option');
	// 				for (var i = 0; i < as.length; i++) {
	// 					if (resul[0].cedula_soporte == as[i].text) {
	// 						as[i].setAttribute("selected", "");
	// 					}
	// 				}
	// 				if (resul[0].serial != '') {
	// 					$('.modal-cerrarTicket #serial').attr("value", resul[0].serial);
	// 				}
	// 				$('input#radioEstatus').removeAttr("checked");
	// 				$('select#prioridad2 option').removeAttr("selected");
	// 				r = $('input#radioEstatus');
	// 				as = $('select#prioridad2 option');
	// 				for (var i = 0; i < 3; i++) {
	// 					if (resul[0].estatus == r[i].value) {
	// 						r[i].setAttribute("checked", "");
	// 					}
	// 					if (resul[0].prioridad == as[i].value) {
	// 						as[i].setAttribute("selected", "");
	// 					}
	// 				}
	// 				if (resul[1]) {
	// 					$('.modal-cerrarTicket input#modelo').attr('value', resul[1].modelo);
	// 					$('.modal-cerrarTicket input#disco').attr('value', resul[1].disco);
	// 					$('.modal-cerrarTicket input#memoria').attr('value', resul[1].memoria);
	// 					$('.modal-cerrarTicket input#procesador').attr('value', resul[1].procesador);
	// 					$('.modal-cerrarTicket input#observaciones').attr('value', resul[1].observaciones);
	// 					$('.modal-cerrarTicket input#idserial').attr('value', resul[1].id);
	// 				}
	// 				$('.modal-cerrarTicket').modal('show');
	// 			}
	// 		})
	// 		.fail(function() {
	// 			$('.modal-abrirTicketError .modal-title').html("<h3>Error al Buscar.</h3>");
	// 			$('.modal-abrirTicketError div.error').html('<div class="alert alert-danger" role="alert"> <h3 class="text-center"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> El ticket n°:'+num+'<br> No se Encuentra Registrado </h3></div>');
	// 			$('.modal-abrirTicketError').modal('show');
	// 		})
	// 		.always(function() {
	// 			$("#page-loader").fadeOut(1000);
	// 		});
	// 	};
	// };

});
