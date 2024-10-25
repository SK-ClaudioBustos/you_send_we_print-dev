String.prototype.padLeft = function padLeft(length, leadingChar) {
    if (leadingChar === undefined) leadingChar = "0";
    return this.length < length ? (leadingChar + this).padLeft(length, leadingChar) : this;
};

//Usage ---------------------
//var s = "1";
//alert(s.padLeft(5));
//alert(s.padLeft(5, 'Z'));


var _search = '';
var init_grid_search = function(grid) {

	function search_grid() {
		_search = $('.search-grid input').val();
		grid.jqGrid('setGridParam', { postData: { search: _search, update_search: 1 } });
		grid.trigger('reloadGrid', { page: 1 });
		
		if (_search) {
			$('.search-grid .remove').show();
		} else {
			$('.search-grid .remove').hide();
		}
	}
	
	$('.search-grid input').keypress(function(e) {
		if (e.which == 13) {
			search_grid();
			return false;
		}
	});
	
	$('.search-grid .search').click(function(e) {
		search_grid();
	});
	
	$('.search-grid .remove').click(function(e) {
		$('.search-grid input').val('');
		search_grid();
	});
};

var preg_quote = function(str) {
    // http://kevin.vanzonneveld.net
    // +   original by: booeyOH
    // +   improved by: Ates Goral (http://magnetiq.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: preg_quote("$40");
    // *     returns 1: '\$40'
    // *     example 2: preg_quote("*RRRING* Hello?");
    // *     returns 2: '\*RRRING\* Hello\?'
    // *     example 3: preg_quote("\\.+*?[^]$(){}=!<>|:");
    // *     returns 3: '\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:'

    return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
}

var highlight = function(data) {
	if (data) {
		return data.toString().replace(new RegExp("(" + preg_quote(_search) + ")", 'gi'), "<b>$1</b>");
	}
	return '';
}

var render_link = function (cellvalue, options, rowObject) {
	var label = cellvalue;
	if (_search) {
		label = highlight(label);
	}
	return '<a class="text_edt" href="' + url_edt + options.rowId + '">' + label + '</a>';
}

var render_main = function (cellvalue, options, rowObject) {
	// like render_link but without link
	var label = cellvalue;
	if (_search) {
		label = highlight(label);
	}
	return label;
}

var render_link_act = function (cellvalue, options, rowObject) {
	// rowObject[1] active must be sent as (int)
	var label = cellvalue;
	if (_search) {
		label = highlight(label);
	}
	var active = parseInt(rowObject[1]);
	return '<a class="text_edt' + ((active) ? '' : ' inactive') + '" href="' + url_edt + options.rowId + '">' + label + '</a>';
}

var render_tool = function (cellvalue, options, rowObject) {
	return '<a class="tool_edt" href="' + url_edt + options.rowId + '"><i class="fa fa-edit" title="' + lng_text('form:edit') + '"></i></a>'
			+ ' <a class="tool_del" href="#"><i class="fa fa-trash-o" title="' + lng_text('form:delete') + '"></i></a>';
};

var render_tool_edt = function (cellvalue, options, rowObject) {
	return '<a class="tool_edt" href="' + url_edt + options.rowId + '"><i class="fa fa-edit" title="' + lng_text('tool:edit') + '"></i></a>';
};

var render_tool_act = function (cellvalue, options, rowObject) {
	var active = parseInt(rowObject[1]);
	return '<a class="tool_edt" href="' + url_edt + options.rowId + '"><i class="fa fa-edit" title="' + lng_text('form:edit') + '"></i></a>'
			+ ' <a class="tool_del" href="#"><i class="fa fa-trash-o" title="' + lng_text('form:delete') + '"></i></a>'
			+ ' <a class="tool_act' + ((active) ? '' : ' inactive') + '" href="' + url_act + options.rowId + '"><i class="fa ' + ((active) ? 'fa-circle' : 'fa-circle-thin') + '" title="' + lng_text('form:act_deact') + '"></i></a>';
};

var before_processing = function(data, status, xhr) {
//console.log(status);
//console.log(xhr);
	if (typeof data['search'] !== 'undefined') {
		_search = data['search'];
	}
}

var load_error = function(xhr, status, error) {
//console.log(status);
//console.log(xhr);	
//console.log(error);	
	process_expired(xhr);
}

var load_before_send = function(xhr, settings) {
	xhr.setRequestHeader('SMVC_AJAX_REQUEST', '1');
}

var process_expired = function(xhr) {
	if (xhr.status == 401) {
		bootbox.alert(lng_text('session:login'), function(result) {
			location.reload();
		});
			
	} else if (xhr.status == 403) {
		bootbox.alert(lng_text('session:remember'), function(result) {
			location.reload();
		});
	} else {
		// ?
		console.log('xhr.status: ' + xhr.status);
	}
};


function init_grid_tools() {
	bootbox.setDefaults({
		locale: 'es',
	}); 

	$('#jqg-list').on('click', '.tool_edt', function() {
	});

	$('#jqg-list').on('click', '.tool_del', function() {
		var parent = $(this).parents('tr');
		parent.addClass('deleting');
		
		bootbox.confirm(lng_text('form:confirm_del'), function(result) {
			if (result) {
				var rowId = parent.attr('id');
				
				App.blockUI({ target: $('#gbox_jqg-list'), iconOnly: true });
		
				$.ajax({
					type: 'POST',
					url: url_del,
					data: {
						id: rowId 
					},
					error: function(jqXHR, textStatus, errorThrown) {
							process_expired(jqXHR);
							App.unblockUI($('#gbox_jqg-list'));
						},
					success: function(data) {
							$('#jqg-list').jqGrid('delRowData', rowId); 
							App.unblockUI($('#gbox_jqg-list'));
						}
				});
	
			} else {
				parent.removeClass('deleting');
			}
		});
		
		return false;
	});
	
	$('#jqg-list').on('click', '.tool_act', function() {
		var $this = $(this);
		var $parent = $this.parents('tr');
		var $link = $parent.find('.text_edt');
		
		App.blockUI({ target: $('#gbox_jqg-list'), iconOnly: true });
		
		$.ajax({
			type: "GET", 
			url: $this.attr('href') + '/ajax', 
			error: function(jqXHR, textStatus, errorThrown) {
					process_expired(jqXHR);
					App.unblockUI($('#gbox_jqg-list'));
				},
			success: function(active) { 
					$this.toggleClass('inactive', !parseInt(active));
						$this.children('i').toggleClass('fa-circle', parseInt(active));
						$this.children('i').toggleClass('fa-circle-thin', !parseInt(active));
					$link.toggleClass('inactive', !parseInt(active));
					App.unblockUI($('#gbox_jqg-list'));
				}
		});
		return false;
	});
	
}


function init_grid(options, grid_id, url_rows){
	$.jgrid.no_legacy_api = true;
	
	var grid_id = (!grid_id) ? 'jqg-list' : grid_id;
	
	var shrink = false;
	if ($(window).width() >= 1400){
		shrink = true;
	};
	
	var setup = $.extend({
		url: (!url_rows) ? url_data : url_rows,
		datatype: 'json',
		mtype: 'POST',
		
		autowidth: true,
		shrinkToFit: shrink,
		height: 480,
		
		rowNum: 100,
		rowList: [50, 100, 200],
		pager: "#jqg-pager",
		pagerpos: 'left',
		
		viewrecords: true,
		sortable: true,
		initTools: true,
		
		onSelectRow: function(rowid, e) {
			$('#' + rowid).parents('table').jqGrid('resetSelection');
		},
		
		loadBeforeSend: load_before_send,
		beforeProcessing: before_processing,
		loadError: load_error,
		
	}, options);

	if (setup.initTools) { 
		init_grid_tools();
	}
		
	var jqgrid = $('#' + grid_id).jqGrid(setup);
	
	$(window).resize(function(){
		var width = $('#gbox_' + grid_id).parent().width();
		jqgrid.jqGrid('setGridWidth', width);
	});
	
	return jqgrid;
}


function init_tree(options){
	$.jgrid.no_legacy_api = true;
	
	var setup = $.extend({
		treeGrid: true,
		treeGridModel: 'adjacency',
		ExpandColumn: 'product',
		ExpandColClick: true,
		
		url: url_data,
		datatype: 'json',
		
		autowidth: true,
		height: 540,
		
		rowNum: 100,
		rowList: [50, 100, 200],
		pager: "#jqg-pager",
		pagerpos: 'left',
		
		viewrecords: true,
		sortable: true,
	}, options);
	
	var grid = $("#jqg-list").jqGrid(setup);
	
	$(window).resize(function(){
		var width = $("#gbox_jqg-list").parent().width();
		grid.jqGrid('setGridWidth', width);
	});
}
