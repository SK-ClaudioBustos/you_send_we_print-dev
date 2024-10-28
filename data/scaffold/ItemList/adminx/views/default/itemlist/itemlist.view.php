<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal itemlist-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'item_list_key', 'label' => 'itemlist:item_list_key', 'val' => $object->get_item_list_key(),
									'required' => true, 'error' => $object->is_missing('item_list_key')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'itemlist:title', 'val' => $object->get_title(),
									'required' => true, 'error' => $object->is_missing('title')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'calc_by', 'label' => 'itemlist:calc_by', 'val' => $object->get_calc_by(),
									'required' => true, 'error' => $object->is_missing('calc_by')))?>
							<?=$tpl->get_view('_input/check', array('field' => 'has_cut', 'label' => 'itemlist:has_cut', 'val' => 1, 'checked' => $object->get_has_cut()))?>
							<?=$tpl->get_view('_input/check', array('field' => 'has_max', 'label' => 'itemlist:has_max', 'val' => 1, 'checked' => $object->get_has_max()))?>
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
