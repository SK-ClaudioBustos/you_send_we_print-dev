<?php
$info_title = $info['measures']['title'];
$info_text = html_entity_decode($info['measures']['info']);

// TODO: move this to controller
$shapes = array();

$size_list = array();
if (isset($sizes['r'])) {
	$shapes['r'] = $lng->text('product:shape_rectangular');

	foreach($sizes['r'] as $size) {
		$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
	}
	$width = $sizes['r'][0]['width'];
	$height = $sizes['r'][0]['height'];

	if (isset($sizes['s'])) {
		$shapes['s'] = $lng->text('product:shape_square');
	}

	if (isset($sizes['o'])) {
		$shapes['o'] = $lng->text('product:shape_rounded');
	}
	if (isset($sizes['p'])) {
		$shapes['p'] = $lng->text('product:shape_panoramic');
	}

} else if (isset($sizes['s'])) {
	// s only
	$shapes['s'] = $lng->text('product:shape_square');

	foreach($sizes['s'] as $size) {
		$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
	}
	$width = $sizes['s'][0]['width'];
	$height = $sizes['s'][0]['height'];

	if (isset($sizes['o'])) {
		$shapes['o'] = $lng->text('product:shape_rounded');
	}
	if (isset($sizes['p'])) {
		$shapes['p'] = $lng->text('product:shape_panoramic');
	}

} else if (isset($sizes['o'])) {
	// o only
	$shapes['o'] = $lng->text('product:shape_rounded');

	foreach($sizes['o'] as $size) {
		$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
	}
	$width = $sizes['o'][0]['width'];
	$height = $sizes['o'][0]['height'];

	if (isset($sizes['p'])) {
		$shapes['p'] = $lng->text('product:shape_panoramic');
	}
} else if (isset($sizes['p'])) {
	// o only
	$shapes['p'] = $lng->text('product:shape_panoramic');

	foreach($sizes['p'] as $size) {
		$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
	}
	$width = $sizes['p'][0]['width'];
	$height = $sizes['p'][0]['height'];
}

if (strpos($product->get_title(), 'Coasters')) {
	$order = array('o', 's', 'r');

	uksort($shapes, function ($a, $b) use ($order) {
		$pos_a = array_search($a, $order);
		$pos_b = array_search($b, $order);
		return $pos_a - $pos_b;
	});

	if (isset($sizes['o'])) {
		$width = $sizes['o'][0]['width'];
		$height = $sizes['o'][0]['height'];
	} else if (isset($sizes['s'])) {
		$width = $sizes['s'][0]['width'];
		$height = $sizes['s'][0]['height'];
	} else if (isset($sizes['r'])) {
		$width = $sizes['r'][0]['width'];
		$height = $sizes['r'][0]['height'];
	}
}

?>

<div class="form-group">
    <label class="col-sm-4">
		<?=$lng->text('product:size')?>&nbsp;<a href="#" class="info" data-target="measures"><span class="badge badge-green">i</span></a>
    </label>
    <div class="col-xs-6 col-sm-4">
		<?=$tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'shape',
				'options' => $shapes,
			))?>
    </div>
    <div class="col-xs-6 col-sm-4">
		<?=$tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'size',
				'options' => $size_list,
				'is_assoc' => true,
			))?>
    </div>
</div>

<div class="info info-measures">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>

<input type="hidden" name="hwidth" id="hwidth" value="<?=$width?>" />
<input type="hidden" name="hheight" id="hheight" value="<?=$height?>" />
<input type="hidden" name="measure_type" id="measure_type" value="<?=$measure_type?>" />
<input type="hidden" name="measure_unit" id="measure_unit" value="std">

<script type="text/javascript">
	var $sizes = <?=json_encode($sizes)?>;
</script>
