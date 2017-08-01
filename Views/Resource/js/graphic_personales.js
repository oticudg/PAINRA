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

$.ajax({
	url: "resource/procesos/graphic_tabla.php",
	type: "POST",
	dataType: "json",
	data: {
		'operation': 'graphic_tabla'
	}
})
.done(function(resul) {
	for(i=0; i<=resul.coordinacion.length ;i++){
		options.series[0].data.push(resul.total[i]);
		options.xAxis.categories.push((i+1)+": "+resul.coordinacion[i]);
	}
	options.title.text="<h1>Tickets Totales</h1>";
	chart = new Highcharts.Chart(options);
})
.fail(function(resul) {
	$('#graphic').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
})

var option = {
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

$.ajax({
	url: "resource/procesos/process.php",
	type: "POST",
	dataType: "json",
	data: {
		"operation": "ticketspersonales",
		"graphic": 2
	},
})
.done(function(resul) {
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
	$('#nombre').html("Ticket de "+resul.Soportista);
})
.fail(function() {
	$('#grafica_soportistas').html('<h2 class="text-center">Error al cargar la tabla :(</h2>');
});