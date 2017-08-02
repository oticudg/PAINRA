$(document).ready(function () {
	var url = 'http://localhost/PAINRA/';
	/*
	* Configuraciones
	*/
	/*el preload circular*/
	$("#page-loader").fadeOut(1000);
	// /*aplicando el metodo datatable al menu.php*/
	$("#tabla").DataTable({
		"order": [ 0, "desc" ],
		"language": {
			"sProcessing": "",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "ultimo",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"processing": true,
		"serverSide": true,
		"ajax": {
			url: 'resource/procesos/server_side_processing.php',
			complete: function(data){
				$("a#abrirTicket2").click(function (e) {
					e.preventDefault();
					buscarTicket($(this).attr("ren"));
				});
				$("a#editTicket").click(function (e) {
					e.preventDefault();
					$("span.msg").html('');
					cerrarTicket($(this).attr("ren"));
				});
			}
		}
	});
	// /*configuracion del datepicker*/
	// $(".input-daterange").datepicker({
	// 	todayBtn: "linked",
	// 	clearBtn: true,
	// 	language: "es",
	// 	orientation: "bottom auto",
	// 	forceParse: false,
	// 	autoclose: true,
	// 	todayHighlight: true
	// });
	// /*
	// * Eventos
	// */
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
	// /*ajax para cambiar el pass*/
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

	// $("#registrar-soportista").submit(function(e){
	// 	e.preventDefault();
	// 	var data = $(this).serializeArray();
	// 	data.push({ name: "operation", value: "soportistasRegistrar" });
	// 	data.push({ name: "token", value: "7" });
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: data,
	// 		beforeSend: function () {
	// 			$(".msg").html('<div class="alert alert-info" role="alert">Enviando Datos...<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><div>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		if (resul == false) {
	// 			$(".msg").html('<div class="alert alert-danger" role="alert"> <span class="fa fa-exclamation-triangle"></span> Ya existe este usuario o cedula.<div>');
	// 		} else {
	// 			$(".msg").html('<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Datos Recibidos Exitosamente...<div>');
	// 			setTimeout(function () {
	// 				$('.modal-soportista-registrar').modal('toggle');
	// 				$("form#registrar-soportista")[0].reset();
	// 				$(".msg").html('');
	// 				llenarSoportistas();
	// 			}, 1000);
	// 			setTimeout(function () {
	// 				$(".msg").html('');
	// 			}, 5000);
	// 		}
	// 	})
	// 	.fail(function(resul) {
	// 		$(".msg").html('<div class="alert alert-danger" role="alert">Error al enviar Datos...<div>');
	// 	});
	// });

	// $("form#form-user-coordinacion").submit(function (e) {
	// 	e.preventDefault();
	// 	var data = $(this).serializeArray();
	// 	data.push({ name: "operation", value: "coordinacionRegistrar" });
	// 	data.push({ name: "token", value: "10" });
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: data,
	// 		beforeSend: function () {
	// 			$("span.msgcoordinacion").html('<div class="alert alert-info" role="alert"> Enviando Datos... <i class="fa fa-spinner fa-pulse fa-fw"></i> </div>');
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		if (resul.estado == false) {
	// 			$("span.msgcoordinacion").html('<div class="alert alert-warning" role="alert"> '+resul.msg+' <span class="glyphicon glyphicon-ok"></span> </div>');
	// 		}
	// 		if (resul === true) {
	// 			$("span.msgcoordinacion").html('<div class="alert alert-success" role="alert"> Datos Recibidos <span class="glyphicon glyphicon-ok"></span> </div>');
	// 			setTimeout(function () {
	// 				$("span.msgcoordinacion").html('');
	// 				$(".modal-soportistas-coordinacion").modal("toggle");
	// 				llenarSoportistas();
	// 			}, 1000);
	// 		}
	// 		setTimeout(function () {
	// 			$("span.msgcoordinacion").html('');
	// 		}, 5000);
	// 	})
	// 	.fail(function() {
	// 		$("span.msgcoordinacion").html('<div class="alert alert-danger" role="alert"> Error al procesar los datos <span class="glyphicon glyphicon-remove"></span> </div>');
	// 	});
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

	// $(".modal-soportistas-coordinacion .deleteUC").click(function (e) {
	// 	e.preventDefault();
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			operation: "deleteUserCoordinacion",
	// 			token: 11,
	// 			id: $(this).attr("ren")
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		if (resul == true) {
	// 			$("span.msgcoordinacion").html('<div class="alert alert-success" role="alert"> Borrado Exitoso <span class="glyphicon glyphicon-remove"></span> </div>');
	// 		} else {
	// 			$("span.msgcoordinacion").html('<div class="alert alert-danger" role="alert"> Error al Realizar la Acción <span class="glyphicon glyphicon-remove"></span> </div>');
	// 		}
	// 		setTimeout(function () {
	// 			$("span.msgcoordinacion").html('');
	// 			$(".modal-soportistas-coordinacion").modal("toggle");
	// 			llenarSoportistas();
	// 		}, 1000);
	// 	})
	// });

	// /*
	// * Funciones
	// */
	// llenarSoportistas();
	// $(".modal-soportistas").modal("show");
	// function llenarSoportistas() {
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'html',
	// 		data: {
	// 			operation: "soportistas",
	// 			token: 6
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		$(".tabla-soportistas").html(resul);
	// 		$("a#editarSoportista").click(function (e) {
	// 			e.preventDefault();
	// 			editarSoportista($(this).attr("ren"));
	// 		});
	// 		$("a#deleteSoportista").click(function (e) {
	// 			e.preventDefault();
	// 			$(".modal-abrirTicketError").css("z-index", 999999);
	// 			$(".modal-abrirTicketError").modal("show");
	// 			$(".modal-abrirTicketError .modal-title").html("<h4><span class='glyphicon glyphicon-remove'></span> Eliminar Soportista</h4>");
	// 			$(".modal-abrirTicketError .modal-body .error").html('<div class="row"> <h4>Esta Seguro de Eliminar a '+$(this).attr("name")+'?</h4> </div> <label for="usuario">Usuario:</label> <input type="text" class="form-control" name="usuario" value="'+$(this).attr("usuario")+'" disabled> <label for="cedula">Cedula:</label> <input type="text" class="form-control" name="cedula" value="'+$(this).attr("cedula")+'" disabled> <br>');
	// 			$(".modal-abrirTicketError .modal-footer span.btnn").html('<button type="button" class="btn btn-primary" id="confirmacionSoportista" ren="'+$(this).attr("ren")+'"><span class="glyphicon glyphicon-ok"></span> Confirmar</button>');
	// 			$("#confirmacionSoportista").click(function () {
	// 				deleteSoportista($(this).attr("ren"));
	// 			});
	// 		});
	// 		$("a#coordinacion").click(function(e) {
	// 			e.preventDefault();
	// 			$(".modal-soportistas-coordinacion input#iduser").attr("value", $(this).attr("ren"));
	// 			if ($(this).attr("coordinacion") == '') {
	// 				$(".modal-soportistas-coordinacion select#tipo").html("<option value='-1' selected>Nuevo</option>");
	// 				$(".modal-soportistas-coordinacion input#iduc").attr("value", "-1");
	// 			} else {
	// 				$(".modal-soportistas-coordinacion select#tipo").html("<option value='-1'>Nuevo</option> <option value='"+$(this).attr("iduc")+"' selected>Actualización</option>");
	// 				$(".modal-soportistas-coordinacion input#iduc").attr("value", $(this).attr("coordinacion"));
	// 				var coordinacion = $(this).attr("coordinacion");
	// 				var options = $(".modal-soportistas-coordinacion select#coordinacion option");
	// 				console.log(coordinacion);
	// 				console.log("adsdasklp");

	// 				for (var i = 0; i < options.length; i++) {
	// 					// if (options[i].attr("value") == coordinacion) {

	// 					// }
	// 				}
	// 			}
	// 			console.log("adsdasklp");
	// 			$(".modal-soportistas-coordinacion").modal("show");
	// 			// $(".modal-soportistas-coordinacion .deleteUC").attr("ren", $(this).attr("coordinacion"));
	// 		});
	// 	})
	// 	.fail(function() {
	// 		$(".tabla-soportistas").html("Error al Cargar...<br>Consulte al Programador.");
	// 	});
	// };

	// function deleteSoportista(num) {
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			operation: "deleteSoportista",
	// 			token: 9,
	// 			id: num
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		if (resul == true) {
	// 			$(".modal-abrirTicketError .modal-footer span.msg").html('<div class="alert alert-success" role="alert">Datos Enviados Exitosamente...</div>');
	// 			llenarSoportistas();
	// 			setTimeout(function () {
	// 				$(".modal-abrirTicketError .modal-footer span.msg").html('');
	// 				$(".modal-abrirTicketError .modal-footer span.btnn").html('');
	// 				$(".modal-abrirTicketError").modal("toggle");
	// 			}, 1000);
	// 		} else {
	// 			$(".modal-abrirTicketError .modal-footer span.msg").html('<div class="alert alert-danger" role="alert">Error al Ingresar Datos.</div>');
	// 		}
	// 	})
	// 	.fail(function() {
	// 		$(".modal-abrirTicketError .modal-footer span.msg").html('<div class="alert alert-danger" role="alert">Error al Ingresar Datos, Consulte a Su Programador.</div>');
	// 	});
	// };

	// function editarSoportista(num) {
	// 	$.ajax({
	// 		url: 'resource/procesos/process.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			operation: "editarSoportista",
	// 			token: 8,
	// 			id: num
	// 		}
	// 	})
	// 	.done(function(resul) {
	// 		$(".modal-soportista-registrar input#usuario").attr('value', resul[0].usuario);
	// 		$(".modal-soportista-registrar input#nombre").attr('value', resul[0].nombre);
	// 		$(".modal-soportista-registrar input#cedula").attr('value', resul[0].cedula);
	// 		$(".modal-soportista-registrar input#id").attr('value', resul[0].id);
	// 		$(".modal-soportista-registrar input#email").attr('value', resul[0].email);
	// 		var option = $(".modal-soportista-registrar select#privilegio option");
	// 		for (var i = 0; i < option.length; i++) {
	// 			if (resul[0].privilegio == option[i].text) {
	// 				option[i].setAttribute("selected", "");
	// 			}
	// 		}
	// 		$(".modal-soportista-registrar").modal("show");
	// 	})
	// };

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








	// content("inicio");
	// $("a#enlace").click(function (e) {
	// 	e.preventDefault();
	// 	content({modulo: $(this).attr("href"), token: 12});
	// });
	// function content(data) {
	// 	$.ajax({
	// 		url: url+"paginacion",
	// 		data: data,
	// 		type: "POST",
	// 		success: function (res) {
	// 			console.log(res);
	// 			$("div#contenido").html(res);
	// 		}
	// 	});
	// };







});
