function init_multiple(edit) {
	var render_yesno = function (cellvalue, options, rowObject) {
		return (parseInt(cellvalue)) ? '<i class="fa fa-check"></i>' : '';
	}


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 81, fixed: true, align: 'center', classes: 'tools', formatter: render_tool_act, hidden: !edit },
						{ name: 'active', index: 'active', label: lng_text('form:active'), width: 30, hidden: true },
						
						{ name: 'username', index: 'username', label: lng_text('user:username'), width: 120, formatter: (edit) ? render_link_act : '' },
						{ name: 'role', index: 'role', label: lng_text('user:role'), width: 200 },
						{ name: 'email', index: 'email', label: lng_text('form:email'), width: 240 },
						{ name: 'name', index: 'name', label: lng_text('form:name'), width: 160 },
						{ name: 'last_time', index: 'last_time', label: lng_text('user:last_time'), width: 140, align: 'center', fixed: true, 
								formatter: 'date', formatoptions: { srcformat: 'ISO8601Long', newformat: 'd/m/Y H:i' } },
						{ name: 'last_ip', index: 'last_ip', label: lng_text('user:last_ip'), width: 140, align: 'center', fixed: true }
				   	],
				sortname: 'username',
			   	sortorder: 'asc'
			};
			
		var grid = init_grid(options);
		init_grid_search(grid);
	});
}
	

function init_single(require_client) {
	$(function() {
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
	});
}