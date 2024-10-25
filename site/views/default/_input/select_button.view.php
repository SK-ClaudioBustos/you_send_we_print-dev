<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width) && $width != 'small') ? $width : '6'?>">
		<div class="input-group<?=($width == 'small') ? ' input-small' : ''?>">
			<?=$tpl->get_view('_input/select_control', array(
					'label' => $label,
					'field' => $field,
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

					'disabled' => $disabled,
					'readonly' => $readonly,
					'multiple' => $multiple,
					'attr' => $attr,
					'select2' => $select2,
				))?>

			<span class="input-group-btn">
				<?php if ($href) { ?>
				<a href="<?=$href?>" id="btn_<?=$field?>" class="btn <?=($btn_color) ? $btn_color : 'default'?>" title="<?=$lng->text($btn_title)?>"><i class="fa fa-<?=$btn_icon?>"></i></a>
				<?php } else { ?>
				<button type="button" id="btn_<?=$field?>" class="btn <?=($btn_color) ? $btn_color : 'default'?>" title="<?=$lng->text($btn_title)?>"<?=(!empty($btn_attr)) ? ' ' . $btn_attr : ''?><?=(!empty($disabled) || !empty($btn_disabled)) ? ' disabled="disabled"' : ''?>><i class="fa fa-<?=$btn_icon?>"></i></button>
				<?php } ?>
			</span>
		</div>
		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } else if (isset($help_text)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$help_text?></em></p>
		<?php } ?>
	</div>
</div>
