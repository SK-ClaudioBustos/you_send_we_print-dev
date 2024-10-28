function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'title', index: 'title', label: lng_text('itemlist:title'), width: 200, formatter: render_link },
						{ name: 'item_list_key', index: 'item_list_key', label: lng_text('itemlist:item_list_key'), width: 160 },
						{ name: 'calc_by', index: 'calc_by', label: lng_text('itemlist:calc_by'), width: 160 },
						{ name: 'has_cut', index: 'has_cut', label: lng_text('itemlist:has_cut'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'has_max', index: 'has_max', label: lng_text('itemlist:has_max'), width: 90, align: 'right', sorttype: 'int' },
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
