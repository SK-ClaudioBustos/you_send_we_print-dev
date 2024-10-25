<?=$tpl->get_view('_input/textarea', array('field' => 'details', 'label' => 'product:datasheets', 'val' => $object->get_details(),
		'required' => false, 'error' => $object->is_missing('details'), 'ta_class' => 'tinymce'))?>
