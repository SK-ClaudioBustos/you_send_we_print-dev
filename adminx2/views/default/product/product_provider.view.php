<fieldset>
	<ol>
		<li>
			<label class="" for="provider_id"><?=$lng->text('product:provider')?></label>
			<select name="provider_id" id="provider_id">
				<option value=""></option>
				<?php
				while($providers->list_paged()) {
					$selected = (($object->get_provider_id() == $providers->get_id()) ? ' selected="selected"' : '');
					echo '<option value="' . $providers->get_id() . '"' . $selected . '>' . $providers->get_provider() . '</option>';
				}
				?>
			</select>
		</li>
		<li>
			<label for="provider_name"><?=$lng->text('product:provider_name')?></label>
			<input type="text" name="provider_name" id="provider_name" maxlength="200" value="<?=$object->get_provider_name()?>" />
		</li>
		<li class="tiny">
			<label for="provider_code"><?=$lng->text('product:provider_code')?></label>
			<input type="text" name="provider_code" id="provider_code" maxlength="200" value="<?=$object->get_provider_code()?>" />
		</li>
		<li>
			<label for="provider_url"><?=$lng->text('product:provider_url')?></label>
			<input type="text" name="provider_url" id="provider_url" maxlength="200" value="<?=$object->get_provider_url()?>" />
		</li>
	</ol>
</fieldset>
