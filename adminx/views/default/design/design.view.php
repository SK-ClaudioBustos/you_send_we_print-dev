<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal design-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'contact', 'label' => 'design:contact', 'val' => $object->get_contact(),
									'required' => true, 'error' => $object->is_missing('contact')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'email', 'label' => 'design:email', 'val' => $object->get_email(),
									'required' => true, 'error' => $object->is_missing('email'), 'width' => 5))?>
							<?=$tpl->get_view('_input/text', array('field' => 'phone', 'label' => 'design:phone', 'val' => $object->get_phone(),
									'required' => true, 'error' => $object->is_missing('phone'), 'width' => 5))?>
							<?=$tpl->get_view('_input/text', array('field' => 'website', 'label' => 'design:website', 'val' => $object->get_website(),
									'required' => false, 'error' => $object->is_missing('website')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'restaurant', 'label' => 'design:restaurant', 'val' => $object->get_restaurant(),
									'required' => false, 'error' => $object->is_missing('restaurant')))?>
							<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'design:description', 'val' => $object->get_description(),
									'required' => true, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'filename', 'label' => 'design:filename', 'val' => $object->get_filename(),
									'required' => true, 'error' => $object->is_missing('filename')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'original_name', 'label' => 'design:original_name', 'val' => $object->get_original_name(),
									'required' => true, 'error' => $object->is_missing('original_name')))?>
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
