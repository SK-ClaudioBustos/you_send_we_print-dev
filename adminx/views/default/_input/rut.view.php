<?php
$rut_parts = ($val) ? explode('-', $val) : array('', '');
?>
<div class="form-group control-rut<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>_rut" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?>">
		<div class="input-group input-medium">
			<input type="text" class="form-control" style="width: 140px; border-right: none;" name="<?=$field?>_rut" id="<?=$field?>_rut" maxlength="8" placeholder="RUT" value="<?=$rut_parts[0]?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<?php if (strpos($attr, 'readonly') === false && strpos($attr, 'disabled') === false && !$disabled && !$readonly) {?>
			<input type="text" class="form-control" style="width: 58px; border-right: none;" name="<?=$field?>_dv" id="<?=$field?>_dv" maxlength="1" placeholder="DV" autocomplete='off' value="<?=$rut_parts[1]?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<span class="input-group-btn">
				<button class="btn" type="button"><i class="fa fa-check"></i></button>
			</span>
			<?php } else { ?>
			<input type="text" class="form-control" style="width: 58px;" name="<?=$field?>_dv" id="<?=$field?>_dv" maxlength="1" placeholder="DV" autocomplete='off' value="<?=$rut_parts[1]?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<?php } ?>
			<input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>" />
		</div>
		<p class="help-block help-invalid"><?=$lng->text('form:invalid_rut')?></p>
		<p class="help-block help-notfound"><?=$lng->text('form:notfound_rut')?></p>
	</div>
</div>

