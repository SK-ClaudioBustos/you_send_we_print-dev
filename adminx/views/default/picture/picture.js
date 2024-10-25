function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

						{ name: 'picture', index: 'picture', label: lng_text('picture:picture'), width: 200, formatter: render_link_act },
						{ name: 'category', index: 'category', label: lng_text('picture:category_id'), width: 160 },
						{ name: 'filename', index: 'filename', label: lng_text('form:filename'), width: 160 },
						{ name: 'original_name', index: 'original_name', label: lng_text('form:original_name'), width: 320 },
		   		],
				sortname: 'picture',
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
