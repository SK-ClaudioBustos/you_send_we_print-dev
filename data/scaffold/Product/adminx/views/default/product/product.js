function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'title', index: 'title', label: lng_text('product:title'), width: 200, formatter: render_link_act },
						{ name: 'product_key', index: 'product_key', label: lng_text('product:product_key'), width: 160 },
						{ name: 'parent_key', index: 'parent_key', label: lng_text('product:parent_key'), width: 160 },
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
