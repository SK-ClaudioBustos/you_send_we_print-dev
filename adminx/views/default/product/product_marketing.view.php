<?=$tpl->get_view('_input/textarea', array('field' => 'attachment', 'label' => 'product:marketing', 'val' => $object->get_attachment(),
		'required' => false, 'error' => $object->is_missing('attachment'), 'ta_class' => 'tinymce'))?>
