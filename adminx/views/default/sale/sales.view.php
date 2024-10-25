<view key="page_metas">
</view>


<view key="breadcrumb">
	<? if ($user_id) { ?>
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
	<? } else { ?>
	{ "<?=$title?>": "<?=$app->page_full?>" }
	<? } ?>
</view>


<view key="body">
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view('sale/sales_selection', array(
					'user_id' => $user_id,
					'wholesaler' => $wholesaler,
					'status' => $status,
					'date_from' => $date_from,
					'date_to' => $date_to,
					'sources' => $sources,
				))?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-table"></i><?=$lng->text('form:grid')?></div>
				</div>
				<div class="portlet-body form" style="min-height: 580px;">
					<?=$tpl->get_view('_output/jqgrid')?>
				</div>
			</div>
		</div>
	</div>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var url_data = '<?=$app->go($app->module_key, false, '/ajax_jqgr/')?>';
		var url_edt = '<?=$app->go($app->module_key, false, '/edit/')?>';
		var url_del = '<?=$app->go($app->module_key, false, '/delete/')?>';

		var url_customers = '<?=$app->go($app->module_key, false, '/customers/')?>';
		var status_def = <?=json_encode($status)?>;

		var date_from = '<?=$date_from?>';
		var date_to = '<?=$date_to?>';
		var user_id = <?=$user_id?>;

		init_multiple();
	</script>
</view>

