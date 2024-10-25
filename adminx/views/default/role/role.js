function init_multiple(edit) {
	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 36, fixed: true, align: 'center', classes: 'tools', formatter: render_tool_edt },
						{ name: 'role', label: lang['role:role'], index: 'role', width: 160, fixed: true, formatter: render_link },
						{ name: 'permissions', label: lang['role:permissions'], index: 'permissions', width: 360 }
				   	],
				sortname: 'role',
			   	sortorder: 'asc',
			   	sortable: true
			};
			
		var grid = init_grid(options);
	});
}

function init_single() {
	$(function() {
		$('#role_id').select2({
			placeholder: lang['form:select'] + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
	});
}
	

