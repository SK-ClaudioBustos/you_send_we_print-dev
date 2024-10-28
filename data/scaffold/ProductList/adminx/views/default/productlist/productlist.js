function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'product_key', index: 'product_key', label: lng_text('productlist:product_key'), width: 200, formatter: render_link },
						{ name: 'product', index: 'product', label: lng_text('productlist:product_id'), width: 160 },
						{ name: 'item_list_key', index: 'item_list_key', label: lng_text('productlist:item_list_key'), width: 160 },
		   		],
				sortname: 'product_key',
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
