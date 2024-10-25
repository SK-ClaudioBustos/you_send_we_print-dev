<?php
$has_max = $item_list->get_has_max();
$date = date_create($object->get_price_date());
$date_f = date_format($date, "m/d/Y") == '11/30/-0001' ? '00-00-0000' : date_format($date, "m/d/Y");
?>
<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'item:title', 'val' => $object->get_title(),
		'required' => true, 'error' => $object->is_missing('title')))?>
<?=$tpl->get_view('_input/text', array('field' => 'item_code', 'label' => 'item:item_code', 'val' => $object->get_item_code(),
		'required' => true, 'error' => $object->is_missing('item_code'), 'width' => 'small'))?>
<div class="form-group"></div>

<?=$tpl->get_view('_input/select', array('field' => 'item_list_key', 'label' => 'item:item_list_key', 'val' => $object->get_item_list_key(),
		'required' => true, 'error' => $object->is_missing('item_list_key'), 'width' => 4,
		'options' => $item_lists, 'val_prop' => 'item_list_key', 'none_val' => '', 'none_text' => ''))?>
<?=$tpl->get_view('_input/text', array('field' => 'filter_word', 'label' => 'item:filter_word', 'val' => $object->get_filter_word(), 'error' => $object->is_missing('filter_word'), 'width' => 'small'))?>


<?=$tpl->get_view('_input/select', array('field' => 'calc_by', 'label' => 'item:calc_by', 'val' => $object->get_calc_by(),
		'required' => true, 'error' => $object->is_missing('calc_by'), 'width' => 4,
		'options' => $calc_bys, 'none_val' => '', 'none_text' => '',
		'disabled' => ($object->get_list_calc_by() != 'variable')))?>
<div class="form-group"></div>

<?='';//$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'item:description', 'val' => $object->get_description(), 'required' => true, 'error' => $object->is_missing('description'), 'ta_class' => 'tinymce'))?>

<?=$tpl->get_view('_input/text', array('field' => 'price', 'label' => 'item:price', 'val' => $object->get_price(),
		'required' => true, 'error' => $object->is_missing('price'), 'width' => 'small', 'class' => 'number', 'help' => 'item:price:inch'))?>
<?=$tpl->get_view('_input/text', array('field' => 'price_date', 'label' => 'item:date', 'val' => $date_f,
		'required' => false, 'width' => 'small', 'readonly' => true, 'disabled' => true, 'class' => 'number'))?>
<?=$tpl->get_view('_input/text', array('field' => 'weight', 'label' => 'item:weight', 'val' => $object->get_weight(),
		'required' => false, 'error' => $object->is_missing('weight'), 'width' => 'small', 'class' => 'number'))?>
<div class="form-group"></div>

<?=$tpl->get_view('_input/text', array('field' => 'max_width', 'label' => 'item:max_width', 'val' => $object->get_max_width(),
		'required' => false, 'error' => $object->is_missing('max_width'), 'width' => 'small', 'class' => 'number', 'disabled' => !$has_max))?>
<?=$tpl->get_view('_input/text', array('field' => 'max_length', 'label' => 'item:max_length', 'val' => $object->get_max_length(),
		'required' => false, 'error' => $object->is_missing('max_length'), 'width' => 'small', 'class' => 'number', 'disabled' => !$has_max))?>
<?=$tpl->get_view('_input/check', array('field' => 'max_absolute', 'label' => 'item:max_absolute', 'val' => 1, 
		'checked' => $object->get_max_absolute(), 'disabled' => !$has_max))?>
<div class="form-group"></div>

<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'item:active', 'val' => 1, 'checked' => $object->get_active()))?>
