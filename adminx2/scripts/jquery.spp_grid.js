function update_paging() {
	if ($page > 1) {
		$('#spp_grid_frst, #spp_grid_prev').removeClass('disabled');
	} else {
		$('#spp_grid_frst, #spp_grid_prev').addClass('disabled');
	}
	if ($page < $last_page) {
		$('#spp_grid_next, #spp_grid_last').removeClass('disabled');
	} else {
		$('#spp_grid_next, #spp_grid_last').addClass('disabled');
	}
}

function update_scroll() {
	if ($('#spp_grid_rows').height() > $('#grid_scroll').height()) {
		$('#spp_grid_rows').css('border-right', 0).width( $('#grid_scroll').width() - scrollbarWidth() );
	} else {
		$('#spp_grid_rows').width($('#grid_scroll').width());
	}
}

function get_rows($new_page) {
	$('.grid_scroll').addClass('loader').html('');
	$.post(
		$url, { grid_setup: $grid_setup, page: $new_page, limit: $limit, sort_field: $sort_field, sort_order: $sort_order, filter: $filter, page_args: $page_args },
		function(data){ $('.grid_scroll').removeClass('loader').html(data); }, 
		'html'
	);
}

$(function() {
	$('#' + $sort_field).addClass(($sort_order == 'ASC') ? 'order_asc' : 'order_desc');
	
	if ($load_rows) {
		get_rows(1);
	}
					 
	$('#spp_grid_frst').click(function() { if (!$(this).hasClass('disabled')) { get_rows(1); } });
	$('#spp_grid_prev').click(function() { if (!$(this).hasClass('disabled')) { $page--; get_rows($page); } });
	$('#spp_grid_next').click(function() { if (!$(this).hasClass('disabled')) { $page++; get_rows($page); } });
	$('#spp_grid_last').click(function() { if (!$(this).hasClass('disabled')) { get_rows(-1); } });

	$('.spp_grid_header th').click(function() { 
		if ($(this).attr('id') != 'spp_grid_tools') {
			if ($sort_field == $(this).attr('id')) {
				if ($sort_order == 'ASC') {
					$sort_order = 'DESC';
					$(this).removeClass('order_asc').addClass('order_desc');
				} else {
					$sort_order = 'ASC';
					$(this).removeClass('order_desc').addClass('order_asc');
				}
			} else {
				$('#' + $sort_field).removeClass('order_asc').removeClass('order_desc');
				$sort_field = $(this).attr('id');
				$sort_order = 'ASC';
				$(this).addClass('order_asc');
			}
			get_rows(1);
		}
	});

	$('.tool_del').live('click', function() { 
		$row = $(this).parents('tr');
		$row.addClass('row_delete');
		if ($row.next().hasClass('full_row')) {
			$row.next().addClass('row_delete');
		}
		if (confirm($confirm_del)) {
			$this = $(this);
			$this.addClass('loader');
			$.ajax({
				type: "GET", url: $(this).attr('href') + '/ajax', data: '',
				success: function(msg) { 
					if (msg) { 
						if ($row.next().hasClass('full_row')) {
						$row.next().remove();
						}
						$row.remove();
						$.sppNotify('', $form_deleted, 'ntf_success');
					} else { 
						$.sppNotify('', $form_not_deleted, 'ntf_error');
					}
				}
			});
							
		} else {
			$row.removeClass('row_delete').removeClass('row_hover'); 
			if ($row.next().hasClass('full_row')) {
				$row.next().removeClass('row_delete').removeClass('row_hover'); 
			}
		}
		return false;
	});
	
	$('.tool_act').live('click', function() {
		$this = $(this);
		$this.addClass('loader').removeClass('active');
		$.ajax({
			type: "GET", 
			url: $(this).attr('href') + '/ajax', 
			data: '',
			success: function(active) { 
				$this.removeClass('loader');
				if (parseInt(active)) { 
					$this.addClass('active');
					$this.parents('tr').find('.text_edt').addClass('active');
				} else { 
					$this.parents('tr').find('.text_edt').removeClass('active');
				}
			}
		});
		return false;
	});
	
	$('.tool_edt, .text_edt').live('click', function() {
		$row = $(this).parents('tr'); 
		$row.removeClass('row_hover').addClass('row_select'); 
		if ($row.next().hasClass('full_row')) {
			$row.next().removeClass('row_hover').addClass('row_select');
		} 
	});
	
	$('.spp_grid tr, .row_new').live('mouseover', function() { 
		$(this).addClass('row_hover');
		if ($(this).next().hasClass('full_row')) {
			$(this).next().addClass('row_hover');
		} else if ($(this).hasClass('full_row')) {
			$(this).prev().addClass('row_hover');
		}
	});
	
	$('.spp_grid tr, .row_new').live('mouseout', function() { 
		$(this).removeClass('row_hover'); 
		if ($(this).next().hasClass('full_row')) {
			$(this).next().removeClass('row_hover');
		} else if ($(this).hasClass('full_row')) {
			$(this).prev().removeClass('row_hover');
		} 
	});

});
