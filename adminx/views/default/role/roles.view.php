<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
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
init_multiple(<?=($app->user->perm('perm:' . strtolower($app->module_key) . '_edit')) ? 'true' : 'false' ?>);
</script>
</view>

