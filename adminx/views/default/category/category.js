function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'category', index: 'category', label: lng_text('category:category'), width: 270, formatter: render_link_act },
						{ name: 'category_key', index: 'category_key', label: lng_text('category:category_key'), width: 270, formatter: render_link_act },
						{ name: 'product', index: 'product', label: lng_text('category:product_id'), width: 270 },
						{ name: 'parent', index: 'parent', label: lng_text('category:parent_id'), width: 270 },
						{ name: 'category_order', index: 'category_order', label: lng_text('category:category_order'), width: 90, align: 'right', sorttype: 'int' },
			   		],
				sortname: 'category',
			   	sortorder: 'ASC',
				shrinkToFit: false
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


		$('#product_id').on('change', function() {
			$('#parent_id').empty();
			$('#parent_id').val(null).trigger('change');

			if (product_id = $(this).val()) {
				// load options
				var options = prod_parents[product_id];
				for(var option in options) {
					$('<option />')
							.val(option)
							.text(options[option])
							.appendTo('#parent_id');
				}
				$('#parent_id').parents('.form-group').removeClass('disabled');
				$('#parent_id').prop('disabled', false);

			} else {
				$('#parent_id').parents('.form-group').addClass('disabled');
				$('#parent_id').prop('disabled', true);
			}
		});
	});
}
