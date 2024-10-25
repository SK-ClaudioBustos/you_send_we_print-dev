<?php
if ($label_text) {
	$label = $label_text;
} else if ($label) {
	$label = $lng->text($label);
} else {
	$label = ' ';
}
?>
<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($error)) ? ' has-error' : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?>">

	<?php if ($sep === true) { ?>
	<div class="col-sm-12"><div class="sep-top"></div></div>
	<?php } ?>


	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '4'?> lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=$label?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width) && $width != 'small') ? $width : '8'?><?=($width == 'small') ? ' input-small' : ''?>">

		<?=$tpl->get_view('product/select_control', array(
				'label' => $label,
				'field' => $field,
				'val' => $val,
				'filters' => $filters,
				'required' => $required,
				'error' => $error,
				'options' => $options,
				'is_assoc' => $is_assoc,
				'allow_none' => $allow_none,
				'val_prop' => $val_prop,
				'txt_prop' => $txt_prop,
				'iterator' => $iterator,
				'disabled' => $disabled,
				'readonly' => $readonly,
				'multiple' => $multiple,
				'attr' => $attr,
				'select2' => $select2,
				'ctrl_class' => $ctrl_class,
			))?>

		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } ?>
	</div>
</div>
