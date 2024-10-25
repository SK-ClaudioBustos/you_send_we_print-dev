<?=$tpl->get_view('_input/textarea', array('field' => 'specs', 'label' => 'product:specs', 'val' => $object->get_specs(),
		'required' => false, 'error' => $object->is_missing('specs'), 'ta_class' => 'tinymce'))?>
