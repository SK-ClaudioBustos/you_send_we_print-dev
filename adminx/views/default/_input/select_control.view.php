<select class="form-control<?=($select2 !== false) ? ' select2' : ''?>" name="<?=($name) ? $name : $field?>" id="<?=str_replace('[]', '', $field)?>" data-placeholder=""<?=(!empty($attr) ? ' ' . $attr : '')?><?=($disabled) ? ' disabled="disabled"' : ''?><?=($readonly) ? ' data-readonly="readonly"' : ''?><?=($multiple) ? ' multiple="multiple"' : ''?>>
	<?php if (isset($none_val)) { ?>
	<option value="<?=$none_val?>"><?=($none_text) ? '[' . $lng->text($none_text) . ']' : ''?></option>
	<?php } ?>
	<?php
	if (is_array($options)) {
		if (((bool)count(array_filter(array_keys($options), 'is_string'))) || $is_assoc) {
			// assoc array
			if (is_array($val)) {
				// multiselect
				foreach($options as $key => $text) {
					?>
					<option value="<?=$key?>"<?=(in_array($key, $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			} else {
				foreach($options as $key => $text) {
					?>
					<option value="<?=$key?>"<?=($val == $key) ? ' selected="selected"' : ''?><?=($readonly && ($val != $key)) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			}

		} else {
			// standar array
			if (is_array($val)) {
				// multiselect
				foreach($options as $text) {
					?>
					<option value="<?=$text?>"<?=(in_array($text, $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			} else {
				foreach($options as $text) {
					?>
					<option value="<?=$text?>"<?=($val == $text) ? ' selected="selected"' : ''?><?=($readonly && ($val != $text)) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			}
		}
	} else if (isset($options)) {
		$val_prop = ($val_prop) ? $val_prop : 'id';
		$txt_prop = ($txt_prop) ? $txt_prop : 'string';
		$iterator = ($iterator) ? $iterator : 'list_paged';
		$active_only = (isset($active_only)) ? $active_only : true;

		if (is_array($val)) {
			// multiselect
			while($options->{$iterator}($active_only)) {
				?>
				<option value="<?=$options->{'get_' . $val_prop}()?>"<?=(in_array($options->{'get_' . $val_prop}(), $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
				<?php
			}

		} else {
			while($options->{$iterator}($active_only)) {
				?>
				<option value="<?=$options->{'get_' . $val_prop}()?>"<?=($val == $options->{'get_' . $val_prop}()) ? ' selected="selected"' : ''?><?=($readonly && ($val != $options->{'get_' . $val_prop}())) ? ' disabled="disabled"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
				<?php
			}
		}
	}
	?>
</select>
