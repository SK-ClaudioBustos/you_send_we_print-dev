<?php 
$field = (isset($field) ? $field : 'filename');
$name = (isset($name) ? $name : 'original_name');
$label = (isset($label) ? $label: 'form:' . $name);
?>

<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-11 img_sep"></div>
	</div>
</div>

<?php if ($object->{'get_' . $field}()) { ?>
<?=$tpl->get_view('_input/file_download', array('field' => $name, 'label' => $label, 
		'val' => $object->{'get_' . $name}(), 'readonly' => true,
		'url' => $app->go($app->module_key, false, '/download/' . $object->get_id() . '/' . urlencode($object->{'get_' . $name}()))))?>
<?=$tpl->get_view('_input/file', array('field' => $field, 'label' => 'form:replace', 'val' => '',
		'required' => false, 'error' => $object->is_missing($field), 'class' => 'attach'))?>
<?=$tpl->get_view('_input/check', array('field' => 'remove', 'label' => 'form:remove', 'val' => 1))?>
<?php } else { ?>
<?=$tpl->get_view('_input/file', array('field' => $field, 'label' => 'form:' . $name, 'val' => '',
		'required' => false, 'error' => $object->is_missing($field), ))?>
<?php } ?>

<?php if ($preview) { ?>
<?=$tpl->get_view('_output/image_preview', array('field' => 'preview', 'preview' => $preview))?>
<?php } ?>

