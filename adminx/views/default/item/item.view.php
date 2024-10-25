<?php
$has_cut = $item_list->get_has_cut();
?>

<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=htmlentities($title, ENT_COMPAT, 'UTF-8')?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal item-form">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_main" data-toggle="tab"><?=$lng->text('item:tab:main')?></a></li>
			<li><a href="#tab_description" data-toggle="tab"><?=$lng->text('item:tab:description')?></a></li>
			<li <?=(!$has_cut) ? 'class="disabled"' : ''?>>
				<a <?=($has_cut) ? 'href="#tab_cut" data-toggle="tab"' : ''?> data-href="#tab_cut"><?=$lng->text('item:tab:cut')?></a>
			</li>
		</ul>

		<div class="form-body">
			<div class="tab-content">
				<div class="tab-pane active in" id="tab_main">
					<?=$tpl->get_view('item/item_main', array(
							'object' => $object, 
							'item_list' => $item_list, 
							'item_lists' => $item_lists, 
							'calc_bys' => $calc_bys,
						));?>
				</div>

				<div class="tab-pane" id="tab_description">
					<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'item:description', 'val' => $object->get_description(),
							'required' => true, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce'))?>
				</div>

				<div class="tab-pane" id="tab_cut">
					<?=$tpl->get_view('item/item_cut', array(
							'object' => $object, 
							'cut_items' => $cut_items, 
							'item_cuts' => $item_cuts,
						));?>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
					<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></a>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script>
		var lists = <?=json_encode($item_lists->list_paged_array())?>;
		var url_upload = '<?=$app->go($app->module_key, false, '/ajax_upload/')?>';
		
		init_single();
	</script>
</view>
