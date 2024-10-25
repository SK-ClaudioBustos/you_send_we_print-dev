<?=$tpl->get_view('_input/textarea', array('field' => 'short_description', 'label' => 'product:short_description', 
		'val' => $object->get_short_description(), 'required' => true, 'error' => $object->is_missing('short_description'), 
		'ta_class' => 'tinymce'))?>
