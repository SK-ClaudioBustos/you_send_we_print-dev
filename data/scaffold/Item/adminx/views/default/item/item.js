function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'title', index: 'title', label: lng_text('item:title'), width: 200, formatter: render_link_act },
						{ name: 'item_code', index: 'item_code', label: lng_text('item:item_code'), width: 160 },
						{ name: 'item_list_key', index: 'item_list_key', label: lng_text('item:item_list_key'), width: 160 },
						{ name: 'price', index: 'price', label: lng_text('item:price'), width: 90, align: 'right', sorttype: 'float' },
						{ name: 'calc_by', index: 'calc_by', label: lng_text('item:calc_by'), width: 160 },
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
