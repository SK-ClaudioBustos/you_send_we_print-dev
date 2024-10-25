function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'contact', index: 'contact', label: lng_text('design:contact'), width: 200, formatter: render_link },
						{ name: 'email', index: 'email', label: lng_text('design:email'), width: 160 },
						{ name: 'phone', index: 'phone', label: lng_text('design:phone'), width: 160 },
						{ name: 'website', index: 'website', label: lng_text('design:website'), width: 160 },
						{ name: 'restaurant', index: 'restaurant', label: lng_text('design:restaurant'), width: 160 },
		   		],
				sortname: 'contact',
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
