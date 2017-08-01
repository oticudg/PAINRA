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
	url: "resource/procesos/process.php",
	type: "POST",
	dataType: "json",
	data: {
		"operation": "ticketsMensuales",
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