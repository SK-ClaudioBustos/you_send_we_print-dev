<?php
$info_title = $info['measures']['title'];
$info_text = html_entity_decode($info['measures']['info']);

$shapes = array();

$size_list = array();
if (isset($sizes['r'])) {
	$shapes['r'] = $lng->text('product:shape_rectangular');

	foreach($sizes['r'] as $size) {
		$size_list[(string)$size['id']] = $size['width'] . '" x ' . $size['height'] . '"';
	}
	$width = $sizes['r'][0]['width'];
	$height = $sizes['r'][0]['height'];
}
if (isset($sizes['s'])) {
	$shapes['s'] = $lng->text('product:shape_square');
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
