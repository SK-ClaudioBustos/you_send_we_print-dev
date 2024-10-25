<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>

	<div class="col-sm-<?=(!empty($width) && !in_array($width, array('small', 'medium'))) ? $width : '8'?>">

		<?php if (isset($icon)) { ?>
		<div class="input-icon">
			<i class="fa fa-<?=$icon?><?=(isset($icon_class) ? ' ' . $icon_class : '')?>"<?=(isset($icon_title) ? ' title="' . $icon_title . '"' : '')?>></i>
			<input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=(in_array($width, array('small', 'medium'))) ? ' input-' . $width : ''?>" name="<?=(!empty($name)) ? $name : $field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
		</div>
		<?php } else { ?>
		<input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=(in_array($width, array('small', 'medium'))) ? ' input-' . $width : ''?><?=(!empty($inline)) ? ' input-inline' : ''?>" name="<?=(!empty($name)) ? $name : $field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
		<?php } ?>

		<?php if (isset($help)) { ?>
		<span class="<?=(!empty($inline)) ? 'help-inline' : 'help-block'?> <?=$help_class?>"><em><?=$lng->text($help)?></em></span>
		<?php } else if (isset($help_text)) { ?>
		<span class="<?=(!empty($inline)) ? 'help-inline' : 'help-block'?> <?=$help_class?>"><em><?=$help_text?></em></span>
		<?php } ?>

	</div>
</div>
