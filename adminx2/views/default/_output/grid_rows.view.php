<?php
$tools_size = sizeof($grid_setup['row_tools']);
$col_count = sizeof($grid_setup['cols']) + (($tools_size) ? 1 : 0);
$full_row = (isset($grid_setup['cols'][sizeof($grid_setup['cols']) - 1]['full_row'])) ? 1 : 0;
$get_key = 'get_' . ((array_key_exists('key_method', $grid_setup)) ? $grid_setup['key'] : 'id'); // TODO: verify why key_method/key
$del_url = (array_key_exists('del_url', $grid_setup)) ? $grid_setup['del_url'] : $cfg->app->go($cfg->app->module_key, false, '/delete/');
$edt_url = (array_key_exists('edt_url', $grid_setup)) ? $grid_setup['edt_url'] : $cfg->app->go($cfg->app->module_key, false, '/edit/');
$act_url = (array_key_exists('act_url', $grid_setup)) ? $grid_setup['act_url'] : $cfg->app->go($cfg->app->module_key, false, '/activate/');
$show_active = (array_key_exists('show_active', $grid_setup) && $grid_setup['show_active']);
$list_method = (array_key_exists('list_method', $grid_setup)) ? $grid_setup['list_method'] : 'list_paged';
?>
<table class="spp_grid" width="97%" id="spp_grid_rows">
	<tbody>
		<?php
		for ($row = 0; $collection->$list_method(false); $row++) { // TODO: check duplicate $i counter
			$active = ($show_active && $collection->get_active()) ? ' active' : '';
			?>
			<tr id="id_<?=$collection->$get_key()?>">
				<?php
				$col = 0;
				if ($tools_size) {
					$col++;
					?>
					<td class="tools16" style="width: <?=$tools_size * 20?>px;<?=($full_row) ? ' border-bottom: none;' : ''?>"><div style="width: <?=$tools_size * 20?>px;">
						<?php
						if (array_key_exists('del', $grid_setup['row_tools']) && $grid_setup['row_tools']['del'] == true) {
							?>
							<a class="tool_del" href="<?=$del_url . $collection->$get_key()?>" title="<?=$lng->text('tool:delete')?>"> </a>
							<?php
						}
						if (array_key_exists('edt', $grid_setup['row_tools']) && $grid_setup['row_tools']['edt'] == true) {
							?>
							<a class="tool_edt" href="<?=$edt_url . $collection->$get_key()?>" title="<?=$lng->text('tool:edit')?>"> </a>
							<?php
						}
						if (array_key_exists('act', $grid_setup['row_tools']) && $grid_setup['row_tools']['act'] == true) {
							?>
							<a class="tool_act<?=$active?>" href="<?=$act_url . $collection->$get_key()?>" title="<?=$lng->text(($active) ? 'tool:deactivate' : 'tool:activate')?>"> </a>
							<?php
						}
						?>
					</div></td>
					<?php
				}
				// TODO: add style attribute always. add width to internal div for chrome bug
				foreach($grid_setup['cols'] as $key => $column) {
					$get_field = 'get_' . ((is_numeric($key)) ? $column['key'] : $key); 
					
					if (isset($column['full_row']) && $column['full_row']) {
						// full row column (must be the last column)
						$colspan = ($tools_size) ? $col - 1 : $col;
						echo ($tools_size) ? '<tr class="full_row"><td></td>' : '<tr>';
						?>
						<td style="border-right: none" colspan="<?=$colspan?>">
							<div><?=$collection->{$get_field}()?></div></td></tr>
						<?php
					
					} else {
						// standar column
						$col++;
						
						$col_width = ($column['width']) ? ' style="width: ' . $column['width'] . 'px;"' : '';
						$border = ($col == $col_count || ($col == $col_count - 1 && $full_row)) ? ' style="border-right: none"' : '';
						$tooltip = (isset($column['tooltip']) && $column['tooltip']) ? ' title="' . $collection->{$get_field}() . '"' : '';
						$align = (isset($column['align'])) ? ' style="text-align: ' . $column['align'] . '"' : '';
						
						if (isset($column['edit']) && $column['edit']) {
							$edit = $edt_url . $collection->$get_key(); 
							?>
							<td<?=$col_width . $border?>>
								<div<?=$tooltip?><?=$align?>>
									<a class="text_edt<?=$active?>" href="<?=$edit?>"><?=$collection->{$get_field}()?></a></div></td>
							<?php
						} else {
							?>
							<td<?=$col_width . $border?>>
								<div<?=$tooltip?><?=$align?>>
									<?=$collection->{$get_field}()?></div></td>
							<?php
						}
					}
				}
				?>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
	$page = <?=$page?>;
	$last_page = <?=$last_page?>;

	$(function() {
		update_scroll();
		update_paging();
	});
</script>
