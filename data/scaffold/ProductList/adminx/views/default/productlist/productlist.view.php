<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal productlist-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/select', array('field' => 'product_id', 'label' => 'productlist:product_id', 'val' => $object->get_product_id(),
									'required' => true, 'error' => $object->is_missing('product_id'),
									'options' => $products, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'product_key', 'label' => 'productlist:product_key', 'val' => $object->get_product_key(),
									'required' => true, 'error' => $object->is_missing('product_key')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'item_list_key', 'label' => 'productlist:item_list_key', 'val' => $object->get_item_list_key(),
									'required' => true, 'error' => $object->is_missing('item_list_key')))?>
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
