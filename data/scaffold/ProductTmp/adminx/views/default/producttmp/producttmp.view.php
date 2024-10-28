<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal producttmp-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'product_type', 'label' => 'producttmp:product_type', 'val' => $object->get_product_type(),
									'required' => true, 'error' => $object->is_missing('product_type')))?>
							<?=$tpl->get_view('_input/select', array('field' => 'parent_id', 'label' => 'producttmp:parent_id', 'val' => $object->get_parent_id(),
									'required' => true, 'error' => $object->is_missing('parent_id'),
									'options' => $parents, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'producttmp:title', 'val' => $object->get_title(),
									'required' => true, 'error' => $object->is_missing('title')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'measure_type', 'label' => 'producttmp:measure_type', 'val' => $object->get_measure_type(),
									'required' => true, 'error' => $object->is_missing('measure_type')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'standard_type', 'label' => 'producttmp:standard_type', 'val' => $object->get_standard_type(),
									'required' => true, 'error' => $object->is_missing('standard_type')))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'producttmp:active', 'val' => 1, 'checked' => $object->get_active()))?>
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
