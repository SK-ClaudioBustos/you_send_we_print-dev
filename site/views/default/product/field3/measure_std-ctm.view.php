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
    <div class="radio-list measure_unit clearfix">
        <label class="col-sm-4">
            <input type="radio" name="measure_unit" id="measure_unit" class="measure_unit <?=$object->get_measure_unit()?>" value="std"<?=($object->get_measure_unit() == 'std') ? ' checked="checked"' : ''?> />
			<?=$lng->text('product:standard')?>&nbsp;<a href="#" class="info" data-target="measures"><span class="badge badge-green">i</span></a>
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
</div>

<div class="form-group measure_unit measure_unit_ctm">
    <div class="radio-list clearfix">
        <label class="col-sm-4">
            <input type="radio" name="measure_unit" class="measure_unit" value="ctm"<?=($object->get_measure_unit() == 'ctm') ? ' checked="checked"' : ''?> /> 
			<?=$lng->text('product:custom')?>
        </label>
        <div class="col-xs-6 col-sm-4">
            <input type="text" name="width" id="width" class="form-control right" title="<?=$lng->text('product:width')?>" placeholder="<?=$lng->text('product:width')?>" maxlength="10" min="1" disabled="disabled" value="<?=($object->get_measure_unit() == 'ft') ? $object->get_width() / 12 : $object->get_width()?>" />
        </div>
        <div class="col-xs-6 col-sm-4">
            <input type="text" name="height" id="height" class="form-control right" title="<?=$lng->text('product:height')?>" placeholder="<?=$lng->text('product:height')?>" maxlength="10" min="1" disabled="disabled" value="<?=($object->get_measure_unit() == 'ft') ? $object->get_height() / 12 : $object->get_height()?>" />
        </div>
    </div>
    <span class="col-sm-offset-4 col-sm-8 help right"><?=$lng->text('product:std_discount')?></span>
</div>

<div class="info info-measures">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>

<input type="hidden" name="hwidth" id="hwidth" value="<?=$width?>" />
<input type="hidden" name="hheight" id="hheight" value="<?=$height?>" />

<script type="text/javascript">
	var $sizes = <?=json_encode($sizes)?>;
</script>
