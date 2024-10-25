<?php
$info = '</em>&nbsp;&nbsp;<a href="#" class="info" data-target="list-' . $option . '"><span class="badge badge-green">i</span></a>';
if (isset($em) && $em) {
	$label = '<em>' . $lng->text('product:' . $option) . '</em>' . $info;
} else if (isset($label)) {
	$label = $lng->text($label) . $info;
} else {
	//$label = $lng->text('product:' . $option) . $info;
	$label = $dinamyc_title . $info;
}

$allow_none = (isset($allow_none)) ? $allow_none : false;
$required = ($allow_none) ? '' : ' data-required="required" title="' . $lng->text('product:' . $option) . '"';
$class = ($allow_none) ? ' class="product_list light"' : ' class="product_list"';
$attr = $required . ((isset($attr)) ? ' ' . $attr : '');

$info_text = '';
$options = array();
$filters_word = array();

//print_r($lists);
//exit;
//if (in_array($option, array('material', 'edges'))) {
if ($item_lists[$option]['has_max']) {
	$max = array();
	foreach ($lists[$option] as $item_key => $value) {
		$options[$item_key] = $value['title'];
		$filters_word[$item_key] = $value['filter_word'];
		$info_text .= '<h5>' . $value['title'] . '</h5>';
		$info_text .= '<div>' . html_entity_decode($value['info']) . '</div>';

		$max[(string)$item_key] = $value['max'];
	}
	$json_max = json_encode($max);
} else {
	if (is_array($lists[$option])) {
		foreach ($lists[$option] as $item_key => $value) {
		    $options[$item_key] = $value['title'];
        	$filters_word[$item_key] = $value['filter_word'];
		    $info_text .= '<h5>' . $value['title'] . '</h5>';
			$info_text .= '<div>' . html_entity_decode($value['info']) . '</div>';
		}
	}
}

?>
<?= $tpl->get_view('product/select', array(
	'field' => $option, 'label_text' => $label, 'ctrl_class' => 'product_list',
	'val' => $detail[$option]['id'], 'options' => $options, 'is_assoc' => true, 'allow_none' => $allow_none,
	'attr' => $attr, 'select2' => $select2, 'sep' => $sep, 'filters' => $filters_word
)) ?>

<div class="info info-list-<?= $option ?>">
	<div class="info-title"><?= $dinamyc_title ?></div>
	<div class="info-text"><?= $info_text ?></div>
</div>

<?php
//if (in_array($option, array('material', 'edges'))) {
if ($item_lists[$option]['has_max']) {
?>
	<script type="text/javascript">
		maximums['<?= $option ?>'] = <?= $json_max ?>;
	</script>
<?php } ?>

<?php
if ($option == 'cut-type') { ?>
	<script type="text/javascript">
		let cuttings = new Map( [<?php foreach ($options as $key => $value) {
			echo "['$key', '$value'],";
		} ?>]);
	</script>
<?php } ?>