<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal coupon-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'quantity', 'label' => 'coupon:quantity', 'val' => $object->get_quantity(),
									'required' => true, 'error' => $object->is_missing('quantity'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'code', 'label' => 'coupon:code', 'val' => $object->get_code(),
									'required' => true, 'error' => $object->is_missing('code')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'discount', 'label' => 'coupon:discount', 'val' => $object->get_discount(),
									'required' => true, 'error' => $object->is_missing('discount'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/select', array('field' => 'user_id', 'label' => 'coupon:user_id', 'val' => $object->get_user_id(),
									'required' => true, 'error' => $object->is_missing('user_id'),
									'options' => $users, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/text', array('field' => 'valid_products', 'label' => 'coupon:valid_products', 'val' => $object->get_valid_products(),
									'required' => true, 'error' => $object->is_missing('valid_products')))?>
							<?=$tpl->get_view('_input/date', array('field' => 'created', 'label' => 'coupon:created', 'val' => $object->get_created(),
									'required' => true, 'error' => $object->is_missing('created')))?>
							<?=$tpl->get_view('_input/date', array('field' => 'expiration', 'label' => 'coupon:expiration', 'val' => $object->get_expiration(),
									'required' => true, 'error' => $object->is_missing('expiration')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'discount_limit', 'label' => 'coupon:discount_limit', 'val' => $object->get_discount_limit(),
									'required' => true, 'error' => $object->is_missing('discount_limit'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'use_per_user', 'label' => 'coupon:use_per_user', 'val' => $object->get_use_per_user(),
									'required' => true, 'error' => $object->is_missing('use_per_user'), 'width' => 'small', 'class' => 'number'))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'coupon:active', 'val' => 1, 'checked' => $object->get_active()))?>
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
