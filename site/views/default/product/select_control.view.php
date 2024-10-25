<select class="form-control<?=($select2 !== false) ? ' select2' : ''?><?=(!empty($ctrl_class)) ? ' ' . $ctrl_class : ''?>" name="<?=$field?>" id="<?=str_replace('[]', '', $field)?>" <?=(isset($none_val)) ? ' data-allow-clear="true"' : ''?> <?=(!empty($attr) ? ' ' . $attr : '')?><?=($disabled) ? ' disabled="disabled"' : ''?><?=($readonly) ? ' data-readonly="readonly"' : ''?><?=($multiple) ? ' multiple="multiple"' : ''?>>
	<option value="" disabled="disabled" selected="selected" style="display: none;"></option>
	<?php
/*	print_r($options);
	print_r($filters);
	die("aca");*/
	if (is_array($options)) {
		if (((bool)count(array_filter(array_keys($options), 'is_string'))) || $is_assoc) {
			// assoc array
			if (is_array($val)) {
				// multiselect
				foreach($options as $key => $text) {
					?>
					<option value="<?=$key?>" class="<?= $filters[$key]; ?>" <?=(in_array($key, $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			} else {
				foreach($options as $key => $text) {
					?>
					<option value="<?=$key?>" class="<?= $filters[$key]; ?>" <?=($val == $key) ? ' selected="selected"' : ''?><?=($readonly && ($val != $key)) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			}

		} else {
			// standar array
			if (is_array($val)) {
				// multiselect
				foreach($options as $text) {
					?>
					<option value="<?=$text?>" class="<?= $filters[$key]; ?>" <?=(in_array($text, $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			} else {
				foreach($options as $text) {
					?>
					<option value="<?=$text?>" class="<?= $filters[$key]; ?>"  <?=($val == $text) ? ' selected="selected"' : ''?><?=($readonly && ($val != $text)) ? ' disabled="disabled"' : ''?>><?=$text?></option>
					<?php
				}
			}
		}
	} else if (isset($options)) {
		$val_prop = ($val_prop) ? $val_prop : 'id';
		$txt_prop = ($txt_prop) ? $txt_prop : 'string';
		$iterator = ($iterator) ? $iterator : 'list_paged';

		if (is_array($val)) {
			// multiselect
			while($options->{$iterator}()) {
				?>
				<option value="<?=$options->{'get_' . $val_prop}()?>" data-filter="<?= $filter_word; ?>" <?=(in_array($options->{'get_' . $val_prop}(), $val)) ? ' selected="selected"' : ''?><?=($readonly) ? ' disabled="disabled"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
				<?php
			}

		} else {
			while($options->{$iterator}()) {
				?>
				<option value="<?=$options->{'get_' . $val_prop}()?>" data-filter="<?= $filter_word; ?>" <?=($val == $options->{'get_' . $val_prop}()) ? ' selected="selected"' : ''?><?=($readonly && ($val != $options->{'get_' . $val_prop}())) ? ' disabled="disabled"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
				<?php
			}
		}
	}
	?>
</select>
