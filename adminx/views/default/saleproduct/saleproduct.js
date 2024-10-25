function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'sale_id', index: 'sale_id', label: lng_text('saleproduct:sale_id'), width: 160, fixed: true },
						{ name: 'sale_product_id', index: 'sale_product_id', label: lng_text('saleproduct:sale_product_id'), width: 160, fixed: true },
						{ name: 'job_name', index: 'job_name', label: lng_text('saleproduct:job_name'), width: 200, hidden: true },
						{ name: 'product', index: 'product', label: lng_text('saleproduct:product_id'), width: 360, formatter: render_link },
						{ name: 'quantity', index: 'quantity', label: lng_text('saleproduct:quantity'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'total_sqft', index: 'total_sqft', label: lng_text('saleproduct:total_sqft'), width: 90, align: 'right', sorttype: 'float' },
						{ name: 'product_subtotal', index: 'product_subtotal', label: lng_text('saleproduct:product_subtotal'), width: 90, align: 'right', sorttype: 'float' },
		   		],
				sortname: 'job_name',
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
