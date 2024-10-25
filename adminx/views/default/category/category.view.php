<?php
//print_r($prod_parents);
//exit;
?>
<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal category-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'category', 'label' => 'category:category', 'val' => $object->get_category(),
									'required' => true, 'error' => $object->is_missing('category')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'category_key', 'label' => 'category:category_key', 'val' => $object->get_category_key(),
									'required' => true, 'error' => $object->is_missing('category_key'), 'readonly' => true))?>
							<?=$tpl->get_view('_input/select', array('field' => 'product_id', 'label' => 'category:product_id', 'val' => $object->get_product_id(),
									'required' => true, 'error' => $object->is_missing('product_id'),
									'options' => $products, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/select', array('field' => 'parent_id', 'label' => 'category:parent_id', 'val' => $object->get_parent_id(),
									'required' => false, 'error' => $object->is_missing('parent_id'), 'is_assoc' => true, 'disabled' => (!$object->get_product_id()),
									'options' => $prod_parents[(string)$object->get_product_id()], 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'category_order', 'label' => 'category:category_order', 'val' => $object->get_category_order(),
									'required' => true, 'error' => $object->is_missing('category_order'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'form:active', 'val' => 1, 'checked' => $object->get_active()))?>
							<div class="form-group"></div>

							<?=$tpl->get_view('_input/file_group', array('object' => $object, 'preview' => $preview))?>
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
	<script>
		var prod_parents = <?=(sizeof($prod_parents)) ? json_encode($prod_parents) : '{}'?>;

		init_single();
	</script>
</view>
