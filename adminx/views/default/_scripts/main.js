/*
$.fn.select2.defaults.set('language', 'es');
*/

var select2 = function(tab_done, tab_current) {
	if (!tab_done[tab_current]) {
		tab_done[tab_current] = true;
		$(tab_current + ' .select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
			language: 'es',
		});
	} 
}

