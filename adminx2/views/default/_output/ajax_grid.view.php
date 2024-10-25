<?php
$ajax_rows = $cfg->app->go($cfg->app->module_key, false, (isset($ajax_rows)) ? $ajax_rows : '/ajax_rows');
$tools = (isset($grid_setup['row_tools'])) ? sizeof($grid_setup['row_tools']) : 0;
$sort_field = (isset($grid_setup['sort_field'])) ? $grid_setup['sort_field'] : 'id';
$sort_order = (isset($grid_setup['sort_order'])) ? $grid_setup['sort_order'] : 'DESC';
$filter = (isset($grid_setup['filter'])) ? $grid_setup['filter'] : '';
$args = (isset($grid_setup['args'])) ? $grid_setup['args'] : '';
$limit = (isset($grid_setup['limit'])) ? $grid_setup['limit'] : 50;
$load_rows = (isset($grid_setup['load_rows'])) ? $grid_setup['load_rows'] : 1;
$new_link = $cfg->app->go($cfg->app->module_key, false, (isset($new_link)) ? $new_link : '/new');
?>
<div id="grid_container">
	<div id="grid_header">
		<table class="spp_grid_header" width="97%">
			<tr>
				<?php
				if ($tools) {
					?>
					<th width="<?=($tools * 20) - 1?>" id="spp_grid_tools"></th>
					<?php
				}
				foreach($grid_setup['cols'] as $key => $col) {
					if (!isset($col['full_row'])) {
						$col_key = (is_numeric($key)) ? $col['key'] : $key;
						?>
						<th id="<?=$col_key?>" <?=($col['width']) ? ' width="' . $col['width'] . '"' : ''?>><div><?=$lng->text($col['caption'])?></div></th>
						<?php
					}
				}
				?>
			</tr>
		</table>
	</div>

	<?php
	if (array_key_exists('new', $grid_setup) && $grid_setup['new']) {
		?>
		<div class="row_new"><a id="tool_new" href="<?=$new_link?>"><?=$lng->text($grid_setup['new']['text'])?></a></div>
		<?php
	}
	?>

	<div class="grid_scroll" id="grid_scroll" style="height: <?=(array_key_exists('new', $grid_setup)) ? '312px' : '340px' // TODO: height by rows?>">
	</div>

	<div id="grid_footer">
		<div id="spp_grid_paging">
			<span id="spp_grid_frst" class="disabled">&laquo;</span><span id="spp_grid_prev" class="disabled">&lsaquo;</span>
			<span id="spp_grid_next">&rsaquo;</span><span id="spp_grid_last">&raquo;</span>
		</div>
	</div>
</div>

<script type="text/javascript">
	var $page = 1;
	var $last_page = 0;
	var $sort_field = '<?=$sort_field?>';
	var $sort_order = '<?=$sort_order?>';
	var $limit = <?=$limit?>;
	var $filter = "<?=$filter?>";
	var $page_args = '';

	var $grid_setup = JSON.stringify(<?=json_encode($grid_setup)?>);
	var $url = '<?=$ajax_rows?>';
	var $load_rows = <?=$load_rows?>;

	var $confirm_del = '<?=$lng->text('form:confirm_del')?>';
	var $form_deleted = '<?=$lng->text('form:deleted')?>';
	var $form_not_deleted = '<?=$lng->text('form:not_deleted')?>';
	var $form_activated = '<?=$lng->text('form:activated')?>';
	var $form_deactivated = '<?=$lng->text('form:deactivated')?>';
</script>
<script type="text/javascript" src="<?=$cfg->url->scripts?>/jquery.spp_grid.js"></script>
