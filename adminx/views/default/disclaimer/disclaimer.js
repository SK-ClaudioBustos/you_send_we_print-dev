function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

						{ name: 'title', index: 'title', label: lng_text('disclaimer:title'), width: 640, formatter: render_link },
						{ name: 'featured', index: 'featured', label: lng_text('disclaimer:featured'), width: 160, align: 'center', formatter: render_check },
		   			],

				sortname: 'title',
			   	sortorder: 'ASC',
				shrinkToFit: false,
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
