$(document).ready(function () {
	var url = 'http://localhost/PAINRA/';
	$('#page-loader').fadeOut(1000);
	$('form').submit(function (e) {
		e.preventDefault();
		var data = $(this).serializeArray();
		data.push({ name: "operation", value: "login" });
		$.ajax({
			url: url + 'Ajax/login',
			type: 'POST',
			dataType: 'json',
			data: data,
			beforeSend: function () {
				$('div.bottom').removeClass('text-danger');
				$('#ingresar').html('Validando <i class="fa fa-spinner fa-pulse fa-1x fa-fw">');
				$('.fa-spinner').css('display','inline-block');
				$('#page-loader').show();
			}
		})
		.done(function(resul) {
			$('div.bottom').addClass('text-success');
			$('div.bottom').css("background-color", "#dff0d8");
			$('#menssage').html("<b> <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span> correcto</b>");
			window.location.reload();
		})
		.fail(function() {
			$('div.bottom').addClass('text-danger');
			$('div.bottom').css("background-color", "#f2dede");
			$('#menssage').html("<b> <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> Error al Iniciar Sesion</b>");
			$('#page-loader').fadeOut(500);
			setTimeout(function () {
				$('.fa-spinner').hide();
				$('#ingresar').html('<span class="fa fa-sign-in"></span> Iniciar Sesion');
			}, 500);
		});
	});
});
