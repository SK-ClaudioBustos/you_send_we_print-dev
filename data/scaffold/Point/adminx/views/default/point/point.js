function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'point', index: 'point', label: lng_text('point:point'), width: 200, formatter: render_link },
						{ name: 'chain', index: 'chain', label: lng_text('point:chain_id'), width: 160 },
						{ name: 'manager', index: 'manager', label: lng_text('point:manager_id'), width: 160 },
						{ name: 'leader', index: 'leader', label: lng_text('point:leader_id'), width: 160 },
						{ name: 'state', index: 'state', label: lng_text('point:state_id'), width: 160 },
		   		],
				sortname: 'point',
			   	sortorder: 'ASC'

			};

		_grid = init_grid(options);
		init_grid_search(_grid);
	});
}

function init_single() {
	$(function() {
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
	});
}
