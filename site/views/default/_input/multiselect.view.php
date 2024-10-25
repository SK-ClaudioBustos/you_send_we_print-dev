<?php
$selected = ($selected) ? $selected : array();
?>
<div class="control-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="control-label" for="<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="controls">
		<select multiple="multiple" name="<?=$field?>[]" id="<?=$field?>"<?=(!empty($attr) ? ' ' . $attr : '')?>>
			<?php while($options->list_paged()) { ?>
			<option value="<?=$options->get_id()?>"<?=(in_array($options->get_id(), $selected)) ? ' selected="selected"' : ''?>><?=$options->get_string()?></option>
			<?php } ?>
		</select>
		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } ?>
	</div>
</div>
