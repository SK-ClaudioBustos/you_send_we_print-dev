<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?>">
		<div class="input-group input-medium">
			<input type="text" class="form-control" name="<?=$field?>" id="<?=$field?>" maxlength="10" value="<?=$val?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<span class="input-group-btn">
				<button class="btn" type="button" id="<?=$field?>_btn"><i class="fa fa-check"></i></button>
			</span>
		</div>
	</div>
</div>

