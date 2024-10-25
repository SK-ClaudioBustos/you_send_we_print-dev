<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="col-sm-<?=(!empty($width)) ? $width : '8'?>">
		<span class="form-control" id="<?=$field?>"><?=$val?></span>
	</div>
</div>
