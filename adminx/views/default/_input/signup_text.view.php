<div class="form-group"<?=(!empty($error)) ? ' error' : ''?>>
	<label class="control-label visible-ie8 visible-ie9" for="<?=$field?>"><?=$lng->text($label)?></label>
	<div class="input-icon">
		<i class="fa <?=$icon?>"></i>
		<input class="form-control placeholder-no-fix" type="text" placeholder="<?=$lng->text($label)?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>" <?=(!empty($attr) ? ' ' . $attr : '')?> />
	</div>
</div>
