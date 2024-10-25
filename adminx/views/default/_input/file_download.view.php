<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<div class="col-sm-<?=(!empty($width) && !in_array($width, array('small', 'medium'))) ? $width : '8'?>">
		<div class="input-group">
			<input type="text" class="form-control<?=($width == 'small') ? ' input-small' : ''?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<span class="input-group-btn">
				<a href="<?=$url?>" class="btn default" title="<?=$lng->text('form:download')?>"><i class="fa fa-download"></i></a>
			</span>
		</div>
	</div>
</div>
