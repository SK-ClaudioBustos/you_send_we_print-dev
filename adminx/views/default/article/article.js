function init_multiple() {
	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 90, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },
	
						{ name: 'title', index: 'title', label: lng_text('article:title'), width: 200, formatter: render_link },
						{ name: 'date_begin', index: 'date_begin', label: lng_text('article:date_begin'), width: 120, fixed: true, 
								align: 'center', sorttype: 'date', formatter : 'date', formatoptions : { srcformat: 'Y-m-d', newformat : 'm/d/Y' } },
			   		],
				sortname: 'title',
			   	sortorder: 'asc'

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
			language: 'es',
		});
	});
}
