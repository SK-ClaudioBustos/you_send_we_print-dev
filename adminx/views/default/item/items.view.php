<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view('item/items_search_new', array(
					'item_lists' => $item_lists,
					'item_list_key' => $item_list_key,
				))?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view('_output/jqgrid')?>
		</div>
	</div>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var url_data = '<?=$app->go($app->module_key, false, '/ajax_jqgr/')?>';
		var url_edt = '<?=$app->go($app->module_key, false, '/edit/')?>';
		var url_del = '<?=$app->go($app->module_key, false, '/delete/')?>';
		var url_act = '<?=$app->go($app->module_key, false, '/activate/')?>';

		init_multiple('<?=$item_list_key?>');
	</script>
</view>
