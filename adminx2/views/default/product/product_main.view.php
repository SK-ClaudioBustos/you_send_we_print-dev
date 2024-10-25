<?php
$measure_type = ($parent) ? $parent->get_measure_type() : $object->get_measure_type();
$disabled = ($parent) ? ' disabled="disabled"' : '';
?>
<fieldset>
	<ol>
		<li>
			<label class="required<?=$object->is_missing('title')?>" for="title"><?=$lng->text('product:title')?></label>
			<input type="text" name="title" id="title" maxlength="255" value="<?=$object->get_title()?>" />
		</li>

		<li class="medium">
			<label class="required<?=$object->is_missing('product_key')?>" for="product_key"><?=$lng->text('product:document_key')?></label>
			<input type="text" name="product_key" id="product_key" maxlength="255"
					<?=($object->get_id()) ? ' readonly="readonly"' : ''?>
					value="<?=$object->get_product_key()?>" />
		</li>
		<li class="tiny">
			<label for="product_code"><?=$lng->text('product:product_code')?></label>
			<input type="text" name="product_code" id="product_code" maxlength="16" value="<?=$object->get_product_code()?>" />
		</li>
		<?php //if ($is_parent || !$children) { ?>
		<li class="tiny">
			<label for="measure_type"><?=$lng->text('product:measure_type')?></label>
			<select name="measure_type" id="measure_type"<?=$disabled?>>
				<option value=""></option>
				<?php
				foreach($measure_types as $key => $text) {
					$selected = (($key == $measure_type) ? ' selected="selected"' : '');
					echo '<option value="' . $key . '"' . $selected . '>' . $text . '</option>';
				}
				?>
			</select>
		</li>
		<?php //} ?>

		<li>
			<label class="required<?=$object->is_missing('parent_key')?>" for="parent_path"><?=$lng->text('product:parent_key')?></label>
			<select name="parent_path" id="parent_path">
				<option value=""></option>
				<?php
				foreach($parents as $key => $value) {
					if (substr_count($key, '/') < 4) {
						$selected = (($object->get_parent_path() == $key) ? ' selected="selected"' : '');
						echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
					}
				}
				?>
			</select>
		</li>

		<li>
			<label class="" for="disclaimer_id"><?=$lng->text('product:disclaimer')?></label>
			<select name="disclaimer_id" id="disclaimer_id">
				<option value=""></option>
				<?php
				while($disclaimers->list_paged()) {
					$selected = (($object->get_disclaimer_id() == $disclaimers->get_id()) ? ' selected="selected"' : '');
					echo '<option value="' . $disclaimers->get_id() . '"' . $selected . '>' . $disclaimers->get_title() . '</option>';
				}
				?>
			</select>
		</li>

		<li class="tiny check">
			<input name="active" id="active" type="checkbox" value="1" <?=($object->get_active()) ? ' checked="checked"' : ''?> />
			<label for="active" class="checkbox"><?=$lng->text('product:active')?></label>
		</li>
	</ol>
</fieldset>
