<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-8" style="height: 20px; border-top: 1px solid #dddddd;"></div>
	</div>
</div>

<?php if ($object->get_filename_sq()) { ?>
<?=$tpl->get_view('_input/file_download', array('field' => 'original_name_sq', 'label' => 'form:original_name_sq', 
		'val' => $object->get_original_name_sq(), 'readonly' => true,
		'url' => $app->go($app->module_key, false, '/download/' . $object->get_id() . '/' . urlencode($object->get_original_name_sq()))))?>
<?=$tpl->get_view('_input/file', array('field' => 'filename_sq', 'label' => 'form:replace', 'val' => '',
		'required' => false, 'error' => $object->is_missing('filename_sq'), 'class' => 'attach'))?>
<?=$tpl->get_view('_input/check', array('field' => 'remove_sq', 'label' => 'form:remove', 'val' => 1))?>
<?php } else { ?>
<?=$tpl->get_view('_input/file', array('field' => 'filename_sq', 'label' => 'form:original_name_sq', 'val' => '',
		'required' => false, 'error' => $object->is_missing('filename_sq'), ))?>
<?php } ?>

<?php if ($preview) { ?>
<?=$tpl->get_view('_output/image_preview', array('field' => 'preview', 'preview' => $preview))?>
<?php } ?>

