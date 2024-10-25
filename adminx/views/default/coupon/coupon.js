function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'code', index: 'code', label: lng_text('coupon:code'), width: 200, formatter: render_link_act },
						{ name: 'quantity', index: 'quantity', label: lng_text('coupon:quantity'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'discount', index: 'discount', label: lng_text('coupon:discount'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'user', index: 'user', label: lng_text('coupon:user_id'), width: 160 },
						{ name: 'valid_products', index: 'valid_products', label: lng_text('coupon:valid_products'), width: 160 },
						{ name: 'created', index: 'created', label: lng_text('coupon:created'), width: 120, fixed: true,
							align: 'center', sorttype: 'date', formatter : 'date', formatoptions : { srcformat: 'Y-m-d', newformat : 'm/d/Y' } },
						{ name: 'expiration', index: 'expiration', label: lng_text('coupon:expiration'), width: 120, fixed: true,
							align: 'center', sorttype: 'date', formatter : 'date', formatoptions : { srcformat: 'Y-m-d', newformat : 'm/d/Y' } },
						{ name: 'discount_limit', index: 'discount_limit', label: lng_text('coupon:discount_limit'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'use_per_user', index: 'use_per_user', label: lng_text('coupon:use_per_user'), width: 90, align: 'right', sorttype: 'int' },
						{ name: 'active', index: 'active', label: lng_text('coupon:active'), width: 90, align: 'right', sorttype: 'int' },
		   		],
				sortname: 'code',
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
