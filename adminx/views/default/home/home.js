var Home = function(){
	var map;

		
 	var load_tiles = function(info){
		$('#cp_total .number').text(info['total']['val']);

		$('#cp_done .number').text(info['done']['val']);
		var perc = (info['total']['val'] > 0) ? parseInt(info['done']['val'] * 100 / info['total']['val']) : 0; //.toFixed(2);
		$('#cp_done .desc span').text(perc);
		
		$('#cp_cancelled .number').text(info['cancelled']['val']);
		var perc = (info['total']['val'] > 0) ? parseInt(info['cancelled']['val'] * 100 / info['total']['val']) : 0; //.toFixed(2);
		$('#cp_cancelled .desc span').text(perc);

		$('#cp_due .number').text(info['due']['val']);
		var perc = (info['total']['val'] > 0) ? parseInt(info['due']['val'] * 100 / info['total']['val']) : 0; //.toFixed(2);
		$('#cp_due .desc span').text(perc);
	}
	
	var load_info = function(period) {
		var parent = $('.content');
		Metronic.blockUI({target: parent, iconOnly: true});

		var scope, id, text, category;
		
//		if (id =  $('#consultant').select2('val')) {
//			scope  = 'consultant';
//			category = $('#category').select2('val'); 
//			
//		} else if (id =  $('#manager').select2('val')) {
//			scope  = 'manager';
//			
//		} else {
			scope  = 'global';
			id = null;  
//		}	
		
		$.ajax({
			type: 'POST',
			url: url_info,
			data: { 
					scope: scope, 
					id: id,
					period: period,
					category: category, 
					table: 1
				},
			dataType: 'json',
			error: function(jqXHR, textStatus, errorThrown) {
					Metronic.unblockUI(parent);
				},
			success: function(data) {
					load_tiles(data['main']);
					update_table(data['table']);
					update_chart(data['chart']);

					// unblock at update_chart()
				}
		});
	};
	
	var period_menu = function() {
		$('#dashboard-period .action').on('click', function() {
			if (!$(this).find('i').hasClass('fa-check')) {
				var period = $(this).data('action');
				$('#dashboard-period span').text(period);
				
				load_info(period);			

				$('#dashboard-period .action i')
						.removeClass('fa-check')
						.addClass('fa-empty');
				$(this).find('i').addClass('fa-check');
			} 
		});
		
	};
	
	
	var update_table = function(table){
		if ($('.table-consultants table').length) {
			$('.table-consultants table').slideUp('slow', function(){
				$(this).remove();
				$('.table-consultants').append(table);
				$('.table-consultants table').slideDown();
			});
		} else {
			$('.table-consultants').append(table);
			$('.table-consultants table').slideDown('slow');
		}
	}
	
	var update_chart = function(chart_vals){
		var chart = $('#full_chart').highcharts();
		
		chart.series[0].update({
			pointStart: Date.UTC(chart_vals['start']['year'], chart_vals['start']['month'] - 1, 1)
		});
		chart.series[0].setData(chart_vals['planned'], false);
		
		chart.series[1].update({
			pointStart: Date.UTC(chart_vals['start']['year'], chart_vals['start']['month'] - 1, 1)
		});
		chart.series[1].setData(chart_vals['done'], false);
		
		chart.series[2].update({
			pointStart: Date.UTC(chart_vals['start']['year'], chart_vals['start']['month'] - 1, 1)
		})
		chart.series[2].setData(chart_vals['cancelled'], false);
		
		chart.series[3].update({
			pointStart: Date.UTC(chart_vals['start']['year'], chart_vals['start']['month'] - 1, 1)
		})
		chart.series[3].setData(chart_vals['due'], false);
		
		chart.redraw();

		Metronic.unblockUI($('.content'));
	}
	
	var init_chart = function() {
		init_chart_options();
		
	    $('#full_chart').highcharts({
	        title: {
	            text: ' '
	        },
	        xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: {
					day: '%b-%e'
				},
                breaks: [{ // Weekends
                    from: Date.UTC(2016, 0, 2, 0),
                    to: Date.UTC(2016, 0, 3, 24),
                    repeat: 7 * 24 * 36e5,
					breakSize: 0
                }]
	        },
	        yAxis: {
	            title: {
	                text: lng_text('report:contacts')
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        plotOptions: {
	            series: {
	                marker: {
	                    enabled: true
	                }
	            }
	        },
	        tooltip: {
	            useHTML: true,
	            headerFormat: '<small><b>{point.key}</b></small><table>',
	            pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td><td style="text-align: right">{point.y}</td></tr>',
	            footerFormat: '</table>',
				shared: true,
				crosshairs: true
	        },
	        chart: {
				backgroundColor: '#f4f4f4',
	            zoomType: 'xy'
	        },
	        legend: {
	            layout: 'horizontal',
	            align: 'center',
	            verticalAlign: 'bottom',
	            borderWidth: 0
	        },
            series: [
					{
		                name: lng_text('report:planned'),
		                color: '#999999',
		                type: 'line',
			            pointStart: Date.UTC(2016, 0, 1),
			            pointInterval: 24 * 3600 * 1000 // one day
		            }, 
					{
		                name: lng_text('report:done'),
		                color: '#44b6ae',
		                type: 'line',
			            pointStart: Date.UTC(2016, 0, 1),
			            pointInterval: 24 * 3600 * 1000 // one day
		            }, 
					{
		                name: lng_text('report:cancelled'),
		                color: '#e35b5a',
		                type: 'line',
			            pointStart: Date.UTC(2016, 0, 1),
			            pointInterval: 24 * 3600 * 1000 // one day
		            },
					{
		                name: lng_text('report:due'),
		                color: '#f1c40f',
		                type: 'line',
			            pointStart: Date.UTC(2016, 0, 1),
			            pointInterval: 24 * 3600 * 1000 // one day
		            }
				]
			
	    });
		
	};
	

	return {
		initPeriod: function(period) {
			load_info(period);			
			period_menu();
			init_chart();
		},
		
	};
	
}();
