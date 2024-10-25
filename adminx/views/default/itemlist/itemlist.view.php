<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>
<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal itemlist-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'itemlist:title', 'val' => $object->get_title(),
							'required' => true, 'error' => $object->is_missing('title')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'description', 'label' => 'itemlist:description', 'val' => $object->get_description(),
							'required' => true, 'error' => $object->is_missing('description')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'quantity_label', 'label' => 'itemlist:quantity_label', 'val' => $object->get_quantity_label(),
							'required' => false, 'error' => $object->is_missing('quantity_label')))?>
				    <?=$tpl->get_view('_input/textarea', array('field' => 'quantity_info', 'label' => 'itemlist:quantity_info', 'val' => $object->get_quantity_info(),
		'required' => false, 'error' => $object->is_missing('quantity_info'), 'ta_class' => 'tinymce2'))?>	
		            <?=''//$tpl->get_view('_input/text', array('field' => 'item_list_key', 'label' => 'itemlist:item_list_key', 'val' => $object->get_item_list_key(), 'required' => true, 'error' => $object->is_missing('item_list_key'), 'width' => 4, 'readonly' => ($object->get_id())))?>
					<?=$tpl->get_view('_input/select', array('field' => 'calc_by', 'label' => 'itemlist:calc_by', 'val' => $object->get_calc_by(),
							'required' => true, 'error' => $object->is_missing('calc_by'), 'width' => 4,
							'options' => $calc_bys, 'none_val' => '', 'none_text' => ''))?>
					<?=$tpl->get_view('_input/check', array('field' => 'has_cut', 'label' => 'itemlist:has_cut', 'val' => 1, 'checked' => $object->get_has_cut()))?>
					<?=$tpl->get_view('_input/check', array('field' => 'has_max', 'label' => 'itemlist:has_max', 'val' => 1, 'checked' => $object->get_has_max()))?>
				</div>

				<div class="form-actions">
					<?=$tpl->get_view('_input/submit')?>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var url_upload = '<?=$app->go($app->module_key, false, '/ajax_upload/')?>';
		init_single();
	</script>
</view>
