<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>

	<div class="col-sm-<?=(!empty($width)) ? $width : '8'?>">

		<textarea name="<?=$field?>" id="<?=$field?>" cols="50" rows="5" class="form-control<?=(!empty($ta_class) ? ' ' . $ta_class : '')?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?>><?=$val?></textarea>

		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } else if (isset($help_text)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$help_text?></em></p>
		<?php } ?>

	</div>
</div>
