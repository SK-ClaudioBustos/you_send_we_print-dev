<fieldset>
	<ol>
		<li class="medium">
			<label for="sizes"><?=$lng->text('product:sizes_list')?></label>
			<select name="sizes" id="sizes" size="20">
				<option value="" selected="selected">[ New Size ]</option>
				<?php
				$size_arr = array();
				while ($sizes->list_paged()) {
					$size_arr[$sizes->get_id()] = $sizes->to_array();
					$value = strtoupper($sizes->get_format())
							. '&nbsp;&nbsp;|&nbsp;&nbsp;' . (($sizes->get_width() < 10) ? '&nbsp;&nbsp;' : '') . $sizes->get_width()
							. ' x ' . (($sizes->get_height() < 10) ? '&nbsp;&nbsp;' : '') . $sizes->get_height() . '"'
							. (($sizes->get_price_a() > 0)
									? '&nbsp;&nbsp;|&nbsp;&nbsp;' . (($sizes->get_price_a() < 100) ? '&nbsp;&nbsp;' : '') . $sizes->get_price_a()
									: ''
						);
					echo '<option value="' . $sizes->get_id() . '">' . $value . '</option>';
				}
				?>
			</select>
			<input type="hidden" name="sizes_str" id="sizes_str" value="" />
		</li>
		<li class="medium">
			<label for="format" class="required"><?=$lng->text('product:format')?></label>
			<select name="format" id="format">
				<option value="s" selected="selected"><?=$lng->text('product:square')?></option>
				<option value="r"><?=$lng->text('product:rectangular')?></option>
				<option value="p"><?=$lng->text('product:panoramic')?></option>
			</select>
		</li>
		<li class="tiny">
			<label for="size_width" class="required"><?=$lng->text('product:width')?></label>
			<input type="text" name="size_width" id="size_width" maxlength="10" class="number" value="" />
		</li>
		<li class="tiny">
			<label for="size_height" class="required"><?=$lng->text('product:height')?></label>
			<input type="text" name="size_height" id="size_height" maxlength="10" class="number" value="" />
		</li>
		
		<li class="tiny<?=($provider_id || $fineart) ? '' : ' hidden'?>">
			<label for="price_a" class="required"><?=$lng->text('product:price')?></label>
			<input type="text" name="price_a" id="price_a" maxlength="10" class="number" value="" />
		</li>
		<li class="tiny" style="height: 48px;">
		</li>

		<li class="tiny<?=($provider_id) ? '' : ' hidden'?>">
			<label for="provider_price" class="required"><?=$lng->text('product:provider_price')?></label>
			<input type="text" name="provider_price" id="provider_price" maxlength="10" class="number" value="" />
		</li>
		<li class="tiny<?=($provider_id) ? '' : ' hidden'?>">
			<label for="provider_weight" class="required"><?=$lng->text('product:provider_weight')?></label>
			<input type="text" name="provider_weight" id="provider_weight" maxlength="10" class="number" value="" />
		</li>

		<li class="tiny<?=($fineart) ? '' : ' hidden'?>">
			<label for="price_b" class="required"><?=$lng->text('product:price_b')?></label>
			<input type="text" name="price_b" id="price_b" maxlength="10" class="number" value="" />
		</li>
		<li class="tiny<?=($fineart) ? '' : ' hidden'?>">
			<label for="price_c" class="required"><?=$lng->text('product:price_c')?></label>
			<input type="text" name="price_c" id="price_c" maxlength="10" class="number" value="" />
		</li>

		<li class="medium">
			<input type="button" id="update" name="update" class="submit_form" value="<?=$lng->text('form:update')?>" />
			<input type="button" id="delete" name="delete" class="submit_form" value="<?=$lng->text('form:delete')?>" disabled="disabled" />
		</li>
	</ol>
</fieldset>

<script type="text/javascript">
	var $sizes = <?=json_encode($size_arr)?>;
	var $sizes_mod = {};
	var $delete_msg = '<?=$lng->text('form:delete_msg')?>';
</script>
