<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<?php if ($superadmin) { ?>
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view('_input/search_new')?>
		</div>
	</div>
	<?php } ?>
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
		init_multiple(<?=($superadmin) ? 'true' : 'false'?>);
	</script>
</view>
