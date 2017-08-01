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
});
