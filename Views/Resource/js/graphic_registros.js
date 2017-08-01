options = {
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

$.ajax({
	url: "resource/procesos/graphic_cerrados.php",
	type: "POST",
	dataType: "json",
	data: {
		operation: 'graphic_cerrados'
	}
})
.done(function(resul) {
	options.xAxis.categories = resul.nombre;
	options.series[0].data = resul.tickets;
	var chart = Highcharts.chart(options);
})
.fail(function() {
	$('#graphic-cerrados').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
});



option = {
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


$.ajax({
	url: "resource/procesos/process.php",
	type: "POST",
	dataType: "json",
	data: {
		"operation": "ticketsdepartamentos",
		"graphic": 1
	},
})
.done(function(resul) {
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