<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($error)) ? ' has-error' : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width) && $width != 'small') ? $width : '8'?><?=($width == 'small') ? ' input-small' : ''?>">

		<?=$tpl->get_view('_input/select_control', array(
				'label' => $label,
				'field' => $field,
				'name' => $name,
				'val' => $val,
				'required' => $required,
				'error' => $error,

				'options' => $options,
				'is_assoc' => $is_assoc,
				'none_val' => $none_val,
				'none_text' => $none_text,

				'val_prop' => $val_prop,
				'txt_prop' => $txt_prop,
				'iterator' => $iterator,
				'active_only' => $active_only,

				'disabled' => $disabled,
				'readonly' => $readonly,
				'multiple' => $multiple,
				'attr' => $attr,
				'select2' => $select2,
			))?>

		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } ?>
	</div>
</div>
