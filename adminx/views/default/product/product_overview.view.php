<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'product:overview', 'val' => $object->get_description(),
		'required' => false, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce2'))?>

<?=$tpl->get_view('_input/text', array('field' => 'meta_title', 'label' => 'form:meta_title', 'val' => $object->get_meta_title(),
		'required' => false, 'error' => $object->is_missing('meta_title')))?>
<?=$tpl->get_view('_input/text', array('field' => 'meta_description', 'label' => 'form:meta_description', 'val' => $object->get_meta_description(),
		'required' => false, 'error' => $object->is_missing('meta_description')))?>
<?=$tpl->get_view('_input/text', array('field' => 'meta_keywords', 'label' => 'form:meta_keywords', 'val' => $object->get_meta_keywords(),
		'required' => false, 'error' => $object->is_missing('meta_keywords')))?>
