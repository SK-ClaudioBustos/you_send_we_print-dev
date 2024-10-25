<view key="page_metas">
	<link href="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/styles/jqx.base.css" rel="stylesheet" type="text/css" />
	<link href="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/styles/jqx.metro.css" rel="stylesheet" type="text/css" />
</view>

<view key="breadcrumb">
	{ "<?=$lng->text('menu:sale')?>": "<?=$app->page_full?>" }
</view>

<view key="body">
	<div class="row-fluid">
		<div class="span12">
	        <div id="jqxgrid"></div>
		</div>
	</div>
</view>

<view key="page_scripts">
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxcore.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxbuttons.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxscrollbar.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxmenu.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.grouping.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.sort.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.pager.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.filter.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.selection.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxlistbox.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxgrid.columnsresize.js"></script>
	<script type="text/javascript" src="/adminx/views/default/_themes/metronic/assets/plugins/jqwidgets/jqxdata.js"></script>

	<script type="text/javascript">
		$(function() {
			var url_data = '<?=$app->go($app->module_key, false, '/ajax_json/')?>';
			var url_edt = '<?=$app->go($app->module_key, false, '/edit/')?>';
			var url_del = '<?=$app->go($app->module_key, false, '/delete/')?>';
			var width = $("#jqxgrid").parent().width();

			var source = {
					datatype: "json",
					datafields: [
						{ name: 'sale_id', type: 'string' },
						{ name: 'id', type: 'string' },
						{ name: 'product', type: 'string' },
						{ name: 'quantity', type: 'int' },
						{ name: 'total_sqft', type: 'number' },
						{ name: 'product_total', type: 'number' },
						{ name: 'status', type: 'string' }
					],
					id: 'id',
					url: url_data,
	                root: 'rows',
					pagesize: 100,
					cache: false,
					beforeprocessing: function(data) {
						source.totalrecords = data.row_count;
					},
					sort: function() {
						// update the grid and send a request to the server.
						$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
					},
					filter: function() {
						// update the grid and send a request to the server.
						$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
					}
				};
			var data_adapter = new $.jqx.dataAdapter(source);

			var render_tool = function (row, columnfield, value, defaulthtml, columnproperties, data) {
				return '<div style="text-align: center; margin-top: 5px;">' +
								'<a href="' + url_edt + data.id + '"><i class="icon-edit" title="Edit"><\/i><\/a>&nbsp;&nbsp;' +
								'<a href="' + url_del + data.id + '"><i class="icon-trash" title="Archive"><\/i><\/a>' +
							'<\/div>';
				};

			var render_link = function (row, columnfield, value, defaulthtml, columnproperties, data) {
				return '<div style="margin-top: 5px;">' +
								'<a href="' + url_edt + data.id + '">' + value + '<\/a>' +
							'<\/div>';
			};

			$("#jqxgrid").jqxGrid({
				width: width,
				height: 640,
				theme: 'metro',
				columnsresize: true,
				sortable: true,
				showsortcolumnbackground: false,
				filterable: true,
				pageable: true,
				pagesizeoptions: ['50', '100', '200'],
				groupable: true,

				virtualmode: true,
				source: data_adapter,
				rendergridrows: function() {
					return data_adapter.records;
				},

				columns: [
					{ text: '', width: 60, cellsrenderer: render_tool },
					{ text: 'Order', datafield: 'sale_id', width: 80, cellsalign: 'center' },
					{ text: 'ID', datafield: 'id', width: 80, cellsalign: 'center' },
					{ text: 'Product', datafield: 'product', width: 280, cellsrenderer: render_link },
					{ text: 'Quantity', datafield: 'quantity', width: 90, cellsalign: 'right' },
					{ text: 'SqFt', datafield: 'total_sqft', width: 90, cellsalign: 'right', cellsformat: 'f2' },
					{ text: 'Total', datafield: 'product_total', width: 90, cellsalign: 'right', cellsformat: 'c2' },
					{ text: 'Status', datafield: 'status', minwidth: 120 }
				]
			});


			$(window).resize(function(){
				var width = $("#jqxgrid").parent().width();
				$('#jqxgrid').jqxGrid('width', width);
			});

		});
	</script>
</view>

