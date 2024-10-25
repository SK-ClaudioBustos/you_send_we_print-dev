<div class="control-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="control-label" for="<?=$field?>"><?=$lng->text($label)?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="controls">
		<input type="text" class="span6 m-wrap" autocomplete="off" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"
				data-provide="typeahead" data-items="6" data-source="<?=$source?>" />
		<p class="help-block"><em><?=$lng->text(($help) ? $help : 'form:auto_help')?></em></p>
	</div>
</div>
