function init_multiple() {
	$(function() {
		var options = {
			colModel: [
					{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

					{ name: 'country', index: 'country', label: lng_text('country:country'), width: 480, formatter: render_link  },
					{ name: 'country_key', index: 'country_key', label: lng_text('country:country_key'), width: 160 },
		   		],
				sortname: 'country',
			   	sortorder: 'asc',

				shrinkToFit: false,
			};

		var grid = init_grid(options);
		init_grid_search(grid);
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
