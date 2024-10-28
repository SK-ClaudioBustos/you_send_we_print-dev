function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'title', index: 'title', label: lng_text('producttmp:title'), width: 200, formatter: render_link_act },
						{ name: 'product_type', index: 'product_type', label: lng_text('producttmp:product_type'), width: 160 },
						{ name: 'parent', index: 'parent', label: lng_text('producttmp:parent_id'), width: 160 },
						{ name: 'measure_type', index: 'measure_type', label: lng_text('producttmp:measure_type'), width: 160 },
						{ name: 'standard_type', index: 'standard_type', label: lng_text('producttmp:standard_type'), width: 160 },
		   		],
				sortname: 'title',
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
