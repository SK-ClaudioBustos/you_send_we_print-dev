<?php
$field = (isset($field)) ? $field : $item_list_key;

//$name = (isset($name)) ? $name : $item_list_key;
$info = '</em>&nbsp;&nbsp;<a href="#" class="info" data-target="list-' . $item_list_key . '"><span class="badge badge-green">i</span></a>';
if (isset($em) && $em) {
	$label = '<em>' . $lng->text('product:' . $item_list_key) . '</em>' . $info;
} else if (isset($label)) {
	$label = $lng->text($label) . $info;
} else {
    $temp_product_list = new ItemList();
	$temp_product_list->retrieve_by('item_list_key', $item_list_key);
    $label = $temp_product_list->get_description() . $info;
	//$label = $lng->text('product:' . $item_list_key) . $info;
    $label_quantity = $temp_product_list->get_quantity_label();
    $info_quantity = $temp_product_list->get_quantity_info();
    if (trim($info_quantity) != "") { if($label_quantity != "" and strstr(strtolower($label),"bulk") ) $_SESSION["isbulk"] = "isbulk"; //aviso al shipping que es bulk?>
    <div class="info info-quantity-<?=$item_list_key?>">
    <div class="info-title"><?= $label_quantity ?> </div>
    <div class="info-text"><?=$info_quantity?></div>
    </div>
    <?php
    }
    if(trim($label_quantity) !="")
        echo "<script>document.addEventListener('DOMContentLoaded', function(event) {document.getElementById('label_".$item_list_key."').innerHTML='".$label_quantity.'&nbsp;<a href="#" class="info" data-target="quantity-'.$item_list_key.'"><span class="badge badge-green">i</span></a>'." '; document.getElementById('info_".$item_list_key."').textContent='".$info_quantity."' });</script>";
    
}


$allow_none = (isset($allow_none)) ? $allow_none : false;
$required = ($allow_none) ? '' : ' data-required="required" title="' . $lng->text('product:' . $item_list_key) . '"';
//$none_value = (isset($none_value)) ? $none_value : 'none';
//$none_text = (isset($none_text)) ? $none_text : $lng->text('product:none');
$class = ($allow_none) ? ' class="product_list light"' : ' class="product_list"';
$attr = $required . ((isset($attr)) ? ' ' . $attr : '');

$info_text = '';
$options = array();
//if ($allow_none) {
//        //$options[$none_value] = $none_text;
//        $options[''] = false;
//}
if (in_array($item_list_key, array('material', 'edges'))) {
	$max = array();
	foreach($lists[$item_list_key] as $item_key => $value) {
		$options[$item_key] = $value['title'];

		$info_text .= '<h5>' . $value['title'] . '</h5>';
		$info_text .= '<div>' . html_entity_decode($value['info']) . '</div>';

		$max[(string)$item_key] = $value['max'];
	}
	$json_max = json_encode($max);

} else {
	if (is_array($lists[$item_list_key])) {
		foreach($lists[$item_list_key] as $item_key => $value) {
			$options[$item_key] = $value['title'];

			$info_text .= '<h5>' . $value['title'] . '</h5>';
			$info_text .= '<div>' . html_entity_decode($value['info']) . '</div>';
		}
	}
}
?>

<?=$tpl->get_view('product/select', array('field' => $field, 'label_text' => $label, 'ctrl_class' => 'product_list',
		'val' => $detail[$item_list_key]['id'], 'options' => $options, 'is_assoc' => true, 'allow_none' => $allow_none,
		'attr' => $attr, 'select2' => $select2, 'sep' => $sep))?>

<div class="info info-list-<?=$item_list_key?>">
    <div class="info-title"><?php if($label != "" and $temp_product_list != "" ) echo $temp_product_list->get_description(); else echo $lng->text('product:' . $item_list_key)?></div>
    <div class="info-text"><?=$info_text?></div>
</div>

<?php if (in_array($item_list_key, array('material', 'edges'))) { ?>
<script type="text/javascript">
	var <?=$item_list_key?> = <?=$json_max?>;
</script>
<?php } ?>
