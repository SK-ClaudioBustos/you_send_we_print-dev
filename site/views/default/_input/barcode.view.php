<div class="control-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="control-label" for="<?=$field?>"><?=$lng->text($label)?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="controls">
		<div class="input-append">
			<input type="text" class="m-wrap" name="<?=$field?>" id="<?=$field?>" maxlength="13" value="<?=$val?>">
			<span class="add-on" id="<?=$field?>_btn" title="<?=$lng->text('form:verify')?>"><i class="fa fa-ok"></i></span>
		</div>
		<span class="help-inline hide"><?=$lng->text('form:invalid_bar')?></span>
	</div>
</div>
