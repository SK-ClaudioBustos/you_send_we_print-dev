<?php
$info_title = $info['measures']['title'];
$info_text = html_entity_decode($info['measures']['info']);

// TODO: move this to controller
$shapes = array();

$size_list = array();

if ($sizes) {
	foreach ($sizes as $key => $value) {
		$shapes[$key] = $lng->text('product:shirt_' . $key);

		foreach ($value as $size) {
			$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
		}
	}

	if ($shapes['n']) {
		$tmp = $shapes['n'];
		unset($shapes['n']);

		$order = array('h', 's', 'm', 'l', 'xl');

		uksort($shapes, function ($a, $b) use ($order) {
			$pos_a = array_search($a, $order);
			$pos_b = array_search($b, $order);
			return $pos_a - $pos_b;
		});

		$shapes = array_merge(['n' => $tmp], $shapes);
	}

	$width = array_values($sizes)[0][0]['width'];
	$height = array_values($sizes)[0][0]['height'];
	/* $width = $sizes['small'][0]['width'];
	$height = $sizes['small'][0]['height']; */
} else {
	$width = 0;
	$height = 0;
}


?>

<div class="form-group">
	<label class="col-xs-12 col-sm-4" style="white-space: nowrap;">
		<?= $lng->text('product:size_shirt_front') ?><a href="#" class="info" data-target="measures" style="margin-left: 4px;"><span class="badge badge-green">i</span></a>
	</label>
	<div class="col-xs-6 col-sm-4">
		<?= $tpl->get_view('_input/select_control', array(
			'label' => false,
			'field' => 'shape_front',
			'options' => $shapes,
			'none_val' => ""
		)) ?>
	</div>
	<div class="col-xs-6 col-sm-4">
		<div id="size_front_div">
			<?= $tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'size_front',
				'options' => $size_list,
				'is_assoc' => true,
				'none_val' => ""
			)) ?>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-4" style="white-space: nowrap;">
		<?= $lng->text('product:size_shirt_back') ?><a href="#" class="info" data-target="measures" style="margin-left: 4px;"><span class="badge badge-green">i</span></a>
	</label>
	<div class="col-xs-6 col-sm-4">
		<?= $tpl->get_view('_input/select_control', array(
			'label' => false,
			'field' => 'shape_back',
			'options' => $shapes,
			'none_val' => ""
		)) ?>
	</div>
	<div class="col-xs-6 col-sm-4">
		<div id="size_back_div">
			<?= $tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'size_back',
				'options' => $size_list,
				'is_assoc' => true,
				'none_val' => ""
			)) ?>
		</div>
	</div>
</div>

<div class="info info-measures">
	<div class="info-title"><?= $info_title ?></div>
	<div class="info-text"><?= $info_text ?></div>
</div>

<input type="hidden" name="hwidth" id="hwidth" value="<?= $width ?>" />
<input type="hidden" name="hheight" id="hheight" value="<?= $height ?>" />
<input type="hidden" name="measure_type" id="measure_type" value="<?= $measure_type ?>" />
<input type="hidden" name="measure_unit" id="measure_unit" value="std">

<script type="text/javascript">
	var $sizes = <?= json_encode($sizes) ?>;
</script>