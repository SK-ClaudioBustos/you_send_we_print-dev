<fieldset>
	<ol>
		<?php if (!$children) { ?>
		<li class="tiny">
			<label for="base_price"><?=$lng->text('product:base_price')?></label>
			<input type="text" name="base_price" id="base_price" maxlength="10" class="small number" value="<?=$object->get_base_price()?>" />
		</li>
		<li class="tiny">
			<label for="price_from"><?=$lng->text('product:price_from')?></label>
			<input type="text" name="price_from" id="price_from" maxlength="10" class="small number" value="<?=$object->get_price_from()?>" />
		</li>
		<li class="tiny check">
			<input name="use_stock" id="use_stock" type="checkbox" value="1" <?=($object->get_use_stock()) ? ' checked="checked"' : ''?> />
			<label for="use_stock" class="checkbox"><?=$lng->text('product:use_stock')?></label>
		</li>
		<li class="tiny">
			<label for="stock_min"><?=$lng->text('product:stock_min')?></label>
			<input type="text" name="stock_min" id="stock_min" maxlength="16" value="<?=$object->get_stock_min()?>" <?=(!$object->get_use_stock()) ? ' disabled="disabled"' : ''?> />
		</li>


		<li class="tiny">
			<label for="width"><?=$lng->text('product:width')?></label>
			<input type="text" name="width" id="width" maxlength="10" class="small number" value="<?=$object->get_width()?>" />
		</li>
		<li class="tiny">
			<label for="height"><?=$lng->text('product:height')?></label>
			<input type="text" name="height" id="height" maxlength="10" class="small number" value="<?=$object->get_height()?>" />
		</li>

		<li class="tiny">
			<label for="weight"><?=$lng->text('product:weight')?></label>
			<input type="text" name="weight" id="weight" maxlength="10" class="small number" value="<?=$object->get_weight()?>" />
		</li>
		<li class="tiny">
			<label for="featured"><?=$lng->text('product:featured')?></label>
			<select name="featured" id="featured">
				<option value=""></option>
				<?php
				foreach($featureds as $key => $text) {
					$selected = (($key == $object->get_featured()) ? ' selected="selected"' : '');
					echo '<option value="' . $key . '"' . $selected . '>' . $text . '</option>';
				}
				?>
			</select>
		</li>
		<?php } ?>

		<?php if ($parent && (!in_array($parent->get_measure_type(), array('fixd-fixd')))) { //'standard', ?>
		<li class="medium">
			<label for="discounts"><?=$lng->text('product:discounts')?></label>
			<textarea name="discounts" id="discounts" cols="50" rows="5" readonly="readonly"><?=$parent->get_discounts()?></textarea>
		</li>
		<li class="medium">
			<label for="turnarounds"><?=$lng->text('product:turnarounds')?></label>
			<textarea name="turnarounds" id="turnarounds" cols="50" rows="5" readonly="readonly"><?=$parent->get_turnarounds()?></textarea>
		</li>
		<?php } else { ?>
		<li class="medium">
			<label for="discounts"><?=$lng->text('product:discounts')?></label>
			<textarea name="discounts" id="discounts" cols="50" rows="5"><?=$object->get_discounts()?></textarea>
		</li>
		<li class="medium">
			<label for="turnarounds"><?=$lng->text('product:turnarounds')?></label>
			<textarea name="turnarounds" id="turnarounds" cols="50" rows="5"><?=$object->get_turnarounds()?></textarea>
		</li>
		<?php } ?>
	</ol>
</fieldset>
