var init_chart_options = function(){

	Highcharts.setOptions({
		lang: {
			printChart: 'Imprimir gráfico',
			downloadJPEG: 'Descargar como JPG',
			downloadPDF: 'Descargar como PDF',
			downloadPNG: 'Descargar como PNG',
			downloadSVG: 'Descargar como SVG',
			loading: 'Cargando...',
			resetZoom: 'Restaurar zoom',
			resetZoomTitle: 'Restaurar zoom a 1:1',
			thousandsSep: '.',
			decimalPoint: ',',
			noData: 'No hay datos'
		},
		chart: {
			renderTo: 'container',
			type: 'column',
		},
		title: {
			text: '-'
		},
		tooltip: {
			useHTML: true,
			headerFormat: '<small><b>{point.key}</b></small><table>',
			pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td><td style="text-align: right">{point.y}</td></tr>',
			footerFormat: '</table>',
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'horizontal',
			align: 'center',
			verticalAlign: 'bottom',
			borderWidth: 0
		},
		noData: {
			style: {
				fontSize: '15px',
				color: '#999999'
			}
		},
		colors: [
			'#2980b9',
			'#17a589',
			'#d4ac0d',
			'#f39c12',
			'#c0392b',
			'#9b59b6',
		],
		exporting: { 
			sourceWidth: 1200,
			sourceHeight: 600,
			chartOptions: {	
				plotOptions: {
					series: {
						dataLabels: {
							enabled: true,
							rotation: 0
						}
					}
				}
			}

		}
		
	});
	
}
