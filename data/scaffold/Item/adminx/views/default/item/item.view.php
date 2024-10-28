<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal item-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'item_code', 'label' => 'item:item_code', 'val' => $object->get_item_code(),
									'required' => true, 'error' => $object->is_missing('item_code')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'item_list_key', 'label' => 'item:item_list_key', 'val' => $object->get_item_list_key(),
									'required' => true, 'error' => $object->is_missing('item_list_key')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'item:title', 'val' => $object->get_title(),
									'required' => true, 'error' => $object->is_missing('title')))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'item:description', 'val' => $object->get_description(),
									'required' => true, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'price', 'label' => 'item:price', 'val' => $object->get_price(),
									'required' => true, 'error' => $object->is_missing('price'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'order', 'label' => 'item:order', 'val' => $object->get_order(),
									'required' => true, 'error' => $object->is_missing('order'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'max_width', 'label' => 'item:max_width', 'val' => $object->get_max_width(),
									'required' => true, 'error' => $object->is_missing('max_width'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'max_length', 'label' => 'item:max_length', 'val' => $object->get_max_length(),
									'required' => true, 'error' => $object->is_missing('max_length'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/check', array('field' => 'max_absolute', 'label' => 'item:max_absolute', 'val' => 1, 'checked' => $object->get_max_absolute()))?>
							<?=$tpl->get_view('_input/text', array('field' => 'calc_by', 'label' => 'item:calc_by', 'val' => $object->get_calc_by(),
									'required' => true, 'error' => $object->is_missing('calc_by')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'weight', 'label' => 'item:weight', 'val' => $object->get_weight(),
									'required' => true, 'error' => $object->is_missing('weight'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'item:active', 'val' => 1, 'checked' => $object->get_active()))?>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
									<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></a>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		init_single();
	</script>
</view>
