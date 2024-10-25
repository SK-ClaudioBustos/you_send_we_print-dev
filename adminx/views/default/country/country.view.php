<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal country-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'country', 'label' => 'country:country', 'val' => $object->get_country(),
									'required' => true, 'error' => $object->is_missing('country')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'country_key', 'label' => 'country:country_key', 'val' => $object->get_country_key(),
									'required' => true, 'error' => $object->is_missing('country_key'), 'width' => 'small'))?>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
									<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></button>
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
