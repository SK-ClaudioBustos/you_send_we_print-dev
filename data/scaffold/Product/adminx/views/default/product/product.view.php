<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal product-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'product_code', 'label' => 'product:product_code', 'val' => $object->get_product_code(),
									'required' => true, 'error' => $object->is_missing('product_code')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'product_key', 'label' => 'product:product_key', 'val' => $object->get_product_key(),
									'required' => true, 'error' => $object->is_missing('product_key')))?>
							<?=$tpl->get_view('_input/select', array('field' => 'parent_id', 'label' => 'product:parent_id', 'val' => $object->get_parent_id(),
									'required' => true, 'error' => $object->is_missing('parent_id'),
									'options' => $parents, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'parent_key', 'label' => 'product:parent_key', 'val' => $object->get_parent_key(),
									'required' => true, 'error' => $object->is_missing('parent_key')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'product:title', 'val' => $object->get_title(),
									'required' => true, 'error' => $object->is_missing('title')))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'form', 'label' => 'product:form', 'val' => $object->get_form(),
									'required' => true, 'error' => $object->is_missing('form'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'short_description', 'label' => 'product:short_description', 'val' => $object->get_short_description(),
									'required' => true, 'error' => $object->is_missing('short_description'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'product:description', 'val' => $object->get_description(),
									'required' => true, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'details', 'label' => 'product:details', 'val' => $object->get_details(),
									'required' => true, 'error' => $object->is_missing('details'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'specs', 'label' => 'product:specs', 'val' => $object->get_specs(),
									'required' => true, 'error' => $object->is_missing('specs'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'meta_title', 'label' => 'product:meta_title', 'val' => $object->get_meta_title(),
									'required' => true, 'error' => $object->is_missing('meta_title')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'meta_description', 'label' => 'product:meta_description', 'val' => $object->get_meta_description(),
									'required' => true, 'error' => $object->is_missing('meta_description')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'meta_keywords', 'label' => 'product:meta_keywords', 'val' => $object->get_meta_keywords(),
									'required' => true, 'error' => $object->is_missing('meta_keywords')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'product_order', 'label' => 'product:product_order', 'val' => $object->get_product_order(),
									'required' => true, 'error' => $object->is_missing('product_order'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'measure_type', 'label' => 'product:measure_type', 'val' => $object->get_measure_type(),
									'required' => true, 'error' => $object->is_missing('measure_type')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'standard_type', 'label' => 'product:standard_type', 'val' => $object->get_standard_type(),
									'required' => true, 'error' => $object->is_missing('standard_type')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'base_price', 'label' => 'product:base_price', 'val' => $object->get_base_price(),
									'required' => true, 'error' => $object->is_missing('base_price'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'width', 'label' => 'product:width', 'val' => $object->get_width(),
									'required' => true, 'error' => $object->is_missing('width'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'height', 'label' => 'product:height', 'val' => $object->get_height(),
									'required' => true, 'error' => $object->is_missing('height'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'weight', 'label' => 'product:weight', 'val' => $object->get_weight(),
									'required' => true, 'error' => $object->is_missing('weight'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'volume', 'label' => 'product:volume', 'val' => $object->get_volume(),
									'required' => true, 'error' => $object->is_missing('volume'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'discounts', 'label' => 'product:discounts', 'val' => $object->get_discounts(),
									'required' => true, 'error' => $object->is_missing('discounts')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'turnarounds', 'label' => 'product:turnarounds', 'val' => $object->get_turnarounds(),
									'required' => true, 'error' => $object->is_missing('turnarounds')))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'attachment', 'label' => 'product:attachment', 'val' => $object->get_attachment(),
									'required' => true, 'error' => $object->is_missing('attachment'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'minimum', 'label' => 'product:minimum', 'val' => $object->get_minimum(),
									'required' => true, 'error' => $object->is_missing('minimum'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'price_from', 'label' => 'product:price_from', 'val' => $object->get_price_from(),
									'required' => true, 'error' => $object->is_missing('price_from'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/check', array('field' => 'use_stock', 'label' => 'product:use_stock', 'val' => 1, 'checked' => $object->get_use_stock()))?>
							<?=$tpl->get_view('_input/text', array('field' => 'stock_min', 'label' => 'product:stock_min', 'val' => $object->get_stock_min(),
									'required' => true, 'error' => $object->is_missing('stock_min'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/select', array('field' => 'disclaimer_id', 'label' => 'product:disclaimer_id', 'val' => $object->get_disclaimer_id(),
									'required' => true, 'error' => $object->is_missing('disclaimer_id'),
									'options' => $disclaimers, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/select', array('field' => 'provider_id', 'label' => 'product:provider_id', 'val' => $object->get_provider_id(),
									'required' => true, 'error' => $object->is_missing('provider_id'),
									'options' => $providers, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'provider_code', 'label' => 'product:provider_code', 'val' => $object->get_provider_code(),
									'required' => true, 'error' => $object->is_missing('provider_code')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'provider_name', 'label' => 'product:provider_name', 'val' => $object->get_provider_name(),
									'required' => true, 'error' => $object->is_missing('provider_name')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'provider_url', 'label' => 'product:provider_url', 'val' => $object->get_provider_url(),
									'required' => true, 'error' => $object->is_missing('provider_url')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'featured', 'label' => 'product:featured', 'val' => $object->get_featured(),
									'required' => true, 'error' => $object->is_missing('featured')))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'product:active', 'val' => 1, 'checked' => $object->get_active()))?>
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
