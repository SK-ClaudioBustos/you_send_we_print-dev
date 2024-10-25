<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label label-checkbox lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?>">
		<div class="checkbox-list">
			<label class="checkbox-inline">
				<?php if (!empty($readonly)) { ?>
				<input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=($checked) ? $val : ''?>" />
				<input type="checkbox" value="<?=$val?>"<?=($checked) ? ' checked="checked"' : ''?><?=(!empty($attr)) ? ' ' . $attr : ''?> disabled="disabled" />
				<?=(!empty($text)) ? $lng->text($text) : ''?>
				<?php } else { ?>
				<input type="checkbox" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"<?=($checked) ? ' checked="checked"' : ''?><?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?> />
				<?=(!empty($text)) ? $lng->text($text) : ''?>
				<?php } ?>
			</label>
		</div>
	</div>
</div>
