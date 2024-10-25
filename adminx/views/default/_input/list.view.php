<?php
$val_prop = ($val_prop) ? $val_prop : 'id';
$txt_prop = ($txt_prop) ? $txt_prop : 'string';
?>
<div class="control-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="control-label" for="<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="controls">
		<select class="span6 m-wrap" name="<?=$field?>" id="<?=$field?>" size="<?=$size?>">
			<?php if ($options) { ?>
			<?php while($options->list_paged()) { ?>
			<option value="<?=$options->get_id()?>"<?=($val == $options->get_id()) ? ' selected="selected"' : ''?>><?=$options->get_string()?></option>
			<?php } ?>
			<?php } ?>
		</select>
		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } ?>
	</div>
</div>