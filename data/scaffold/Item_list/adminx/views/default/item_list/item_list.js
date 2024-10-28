function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'title', index: 'title', label: lng_text('item_list:title'), width: 200, formatter: render_link },
						{ name: 'item_list_key', index: 'item_list_key', label: lng_text('item_list:item_list_key'), width: 160 },
						{ name: 'calc_by', index: 'calc_by', label: lng_text('item_list:calc_by'), width: 160 },
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
