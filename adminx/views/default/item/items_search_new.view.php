<div class="form-group clearfix">
	<?php if ($app->user->perm('perm:' . strtolower($app->module_key) . '_edit') && $new !== false) { ?>
	<a class="btn default pull-left" href="<?=$app->go($app->module_key, false, '/new/' . $token)?>"><i class="fa fa-plus"></i> <?=$lng->text('object:new')?></a>
	<?php } ?>

	<div class="pull-left item_list">
		<?=$tpl->get_view('_input/select', array('field' => 'item_list', 'label' => false, 'val' => $item_list_key,
				'width' => 12, 'options' => $item_lists, 'val_prop' => 'item_list_key', 'none_val' => '', 'none_text' => ''))?>
	</div>

	<div class="btn-group pull-right export">
		<button data-toggle="dropdown" type="button" class="btn default dropdown-toggle">
			<?=$lng->text('tool:export')?> <i class="fa fa-angle-down"></i>
		</button>
		<ul role="menu" class="dropdown-menu pull-right">
			<li><a id="export_xls" href="<?=$app->go($app->module_key, false, '/export/xls/' . $token)?>" data-href="<?=$app->go($app->module_key, false, '/export/xls')?>"><?=$lng->text('tool:export_xls')?></a></li>
			<li><a id="export_xlsx" href="<?=$app->go($app->module_key, false, '/export/xlsx/' . $token)?>" data-href="<?=$app->go($app->module_key, false, '/export/xlsx')?>"><?=$lng->text('tool:export_xlsx')?></a></li>
		</ul>
	</div>

	<div class="input-group input-medium pull-right search-grid">
		<input type="text" class="form-control" placeholder="<?=$lng->text('form:search')?>&hellip;" value="<?=$search?>">
		<span class="input-group-btn">
			<button type="button" class="btn default remove"<?=($search) ? ' style="display: inline-block;"' : ''?>><i class="fa fa-remove"></i></button>
			<button type="submit" class="btn default search"><i class="fa fa-search"></i></button>
		</span>
	</div>
</div>
