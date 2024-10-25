function init_multiple() {

//return;
	var grid;
		
	
	var render_status = function(cellvalue, options, rowObject) {
		return '<span class="label label-sm ' + cellvalue + '">' + lng_text(cellvalue) + '</span>';
	};
	

	var select = function(elem, status) {
		if (status) {
			$(elem + ' > option').prop('selected', 'selected');
			$(elem).trigger('change');
		} else {
			$(elem + ' > option').removeAttr('selected');
			$(elem).trigger('change');
		 }
	}; 
	
	var status_default = function() {
		for (sts in status_def) {
			if (status_def[sts][1]) {
				$('#status > option[value="' + sts + '"]').prop('selected', 'selected');
			} else {
				$('#status > option[value="' + sts + '"]').removeAttr('selected');
			}
		}
		$('#status').trigger('change');
	};
	
	var apply_filter = function() {
		if (sale_id = $('#sale_id').val()) {
			grid.jqGrid('setGridParam', { postData: { sale_id: sale_id } });
		
		} else if (sale_product_id = $('#sale_product_id').val()) {
			grid.jqGrid('setGridParam', { postData: { sale_product_id: sale_product_id, sale_id: 0 } });
			
		} else if (job_id = $('#job_id').val()) {
			grid.jqGrid('setGridParam', { postData: { job_id: job_id, sale_id: 0 } });
			
		} else {
			var client = $('#client').val();
			var date_from = $('#date_from').val();
			var date_to = $('#date_to').val();

			var status = ($('#status').select2('val').length) ? $('#status').select2('val').join('-') : '';
			var source = $('#source').val();

			grid.jqGrid('setGridParam', { postData: { reload: true, client: client, date_from: date_from, date_to: date_to, 
					status: status, source: source, sale_product_id: 0, sale_id: 0, job_id: 0 } });
		}
		
		$('.grid-sel .collapse').trigger('click');
		grid.trigger('reloadGrid', [{ page: 1 }]);
	};
	
	
	$(function() {
		$('.selection .caption').click(function() {
			$('.selection .expand, .selection .collapse').trigger('click');
		});
		
		$('#sel_def').click(function() {
			status_default();
			return false;
		});
		
		$('#sel_all').click(function() {
			select('#status', true);
			return false;
		});
		
		$('#sel_none').click(function() {
			select('#status', false);
			return false;
		});
		
		$('#btn_cancel').click(function() {
			// TODO: set date range, don't clear them
			// There is no way to set the dates in the datepicker popup
			//$('#date_from, #date_to').val('');
			$('#sale_id, #sale_product_id, #job_id, #client').val('');
			status_default();
			return false;
		});
		
		$('#btn_apply').click(function() {
			apply_filter();
			return false;
		});
		
		$('.date-picker').datepicker({
			autoclose: true,
		});

		$('.select2').select2(
		//{
		//	placeholder: lng_text('form:select') + '...',
		//	minimumResultsForSearch: 20,
		//	allowClear: true,
		//	formatSelection: function(object, container) {
		//			$(container).parent().addClass('status-choice ' + object.id);
		//			return object.text;
		//		},
		//}
			);
		
		var status = ($('#status').select2('val').length) ? $('#status').select2('val').join('-') : '';
		var source = $('#source').val();
		
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 30, fixed: true, align: 'center', classes: 'tools', formatter: render_tool_edt },
						{ name: 'sale_id', label: lng_text('sale:sale_id'), index: 'sale_id', width: 120, hidden: true },
						{ name: 'sale_product_id', label: lng_text('sale:sale_product_id'), index: 'sale_product_id', width: 80, fixed: true, align: 'center', title: false },
	
						{ name: 'status', label: lng_text('sale:status'), index: 'status', width: 120, fixed: true, title: false, align: 'center', formatter: render_status },				
						{ name: 'date_due', label: lng_text('sale:date_due'), index: 'date_due', width: 80, fixed: true, align: 'center', 
								formatter: 'date', formatoptions: { srcformat: 'ISO8601Long', newformat: 'm/d/Y' } }, // 'ISO8601Short',
						{ name: 'date_confirm', label: lng_text('sale:date_confirm'), index: 'date_confirm', width: 140, fixed: true, align: 'center', 
								formatter: 'date', formatoptions: { srcformat: 'ISO8601Long', newformat: 'm/d/Y g:i A' } }, // 'ISO8601Long' 

						{ name: 'job_name', label: lng_text('sale:job_name'), index: 'job_name', width: 220, formatter: render_link },
						{ name: 'product', label: lng_text('sale:product'), index: 'product', width: 280 },
	
						{ name: 'quantity', label: lng_text('sale:quantity'), index: 'quantity', width: 80, fixed: true, align: 'right', title: false, summaryType: 'sum' },
						{ name: 'total_sqft', label: lng_text('sale:total_sqft'), index: 'total_sqft', width: 80, fixed: true, align: 'right', formatter: 'number', title: false, summaryType: 'sum' },
						{ name: 'product_total', label: lng_text('sale:product_total'), index: 'product_total', width: 100, fixed: true, align: 'right', 
								formatter: 'currency', formatoptions: { prefix: '$ ' }, title: false, summaryType: 'sum' }
				   	],
				sortname: 'sale_product_id',
			   	sortorder: 'desc',
				shrinkToFit: false,
	
			   	grouping: true,
			   	groupingView : { 
						groupField : [ 'sale_id' ], 
						groupOrder : [ 'desc' ],
						groupSummary: [ true ],
						groupColumnShow : [false]
					},
				
				postData: { user_id: user_id, source: source, status: status, date_from: date_from, date_to: date_to }
			};
			
		grid = init_grid(options);
		init_grid_search(grid);
	});
}
	
function init_single() {
	
	var set_status = function(data) {
		if (st_history.length < data['status_history'].length) {
			
			$('.label.' + status)
				.removeClass(status)
				.addClass(data['status'])
				.text(lng_text(data['status']));
				
			status = data['status'];
			st_history = data['status_history'];
			
			load_history();
			load_menu(data);
		}		
	}  

	var load_menu = function(data) {
		var ul = $('.actions ul.dropdown-menu');
		ul.children().remove();

		var len = data['actions'].length;
		for (var i = 0; i < len; i++) {
			if (data['actions'][i] == 'ac_sep') {
				var li = $('<li></li>').addClass('divider');
			} else {
				var a = $('<a></a>')
					.attr('data-field', data['actions'][i])
					.attr('href', 'javascript:;')
					.text(lng_text(data['actions'][i]));
				var li = $('<li></li>').append(a);
				
			}
			
			ul.append(li);
		}	
	}
	
	var load_history = function(){
		$('#history tr').not('.labels').remove();
			 			
		var len = st_history.length;
		
		for (var i = len - 1; i >= 0; i--) {
			$('<tr></tr>')
				.append($('<th></th>').text(st_history[i]['date']))
				.append($('<td></td>').text(st_history[i]['user']))
				.append($('<td></td>').text(lng_text(st_history[i]['status'])))
				.appendTo('#history thead');
		}
	}
		
	$(function() {

		var hash = window.location.hash;
		hash && $('ul.nav a[href="' + hash + '"]').tab('show');		

		$('.date-picker').datepicker({
			autoclose: true
		}).on('changeDate', function(date){
			var parent = $('.portlet-body');
			Metronic.blockUI({target: parent, iconOnly: true});

			$.ajax({
				type: 'POST',
				url: url_date,
				data: { date_due: date.format('yyyy-mm-dd') },
				error: function(jqXHR, textStatus, errorThrown) {
						// TODO: error message
						Metronic.unblockUI(parent);
					},
				success: function(data) {
						Metronic.unblockUI(parent);
					}
			});
		});

		$('.save_comment').on('click', function() {
			var parent = $('.portlet-body');
			Metronic.blockUI({target: parent, iconOnly: true});

			var field = $(this).data('field');
			var id = $(this).data('id');
			var comment = $('#' + field).val();
			$.ajax({
				type: 'POST',
				url: url_comment,
				data: { field: field, id: id, comment: comment },
				error: function(jqXHR, textStatus, errorThrown) {
						// TODO: error message
						Metronic.unblockUI(parent);
					},
				success: function(data) {
						Metronic.unblockUI(parent);
					}
			});
		});
		
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});

		$('.actions a').live('click', function() {
			var parent = $('.portlet-body');
			Metronic.blockUI({target: parent, iconOnly: true});
			
			var action = $(this).attr('data-field');
			
			$.ajax({
				type: 'POST',
				url: url_action,
				data: { action: action },
				dataType: 'json',
				error: function(jqXHR, textStatus, errorThrown) {
						// TODO: error message
						Metronic.unblockUI(parent);
					},
				success: function(data) {
						set_status(data);
						
						Metronic.unblockUI(parent);
					}
			});
		});

		load_history();

	});
}	


