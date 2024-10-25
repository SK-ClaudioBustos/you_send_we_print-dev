<fieldset>
	<ol>
		<li>
			<label for="description"><?=$lng->text('product:details')?></label>
			<textarea name="description" id="description" cols="50" rows="5" class="tinymce tinymce_2"><?=$object->get_description()?></textarea>
			<div class="clear_float"></div>
		</li>
		<li>
			<label for="meta_description"><?=$lng->text('form:meta_description')?></label>
			<input type="text" name="meta_description" id="meta_description" maxlength="200" value="<?=$object->get_meta_description()?>" />
		</li>
		<li>
			<label for="meta_keywords"><?=$lng->text('form:meta_keywords')?></label>
			<input type="text" name="meta_keywords" id="meta_keywords" maxlength="200" value="<?=$object->get_meta_keywords()?>" />
		</li>
	</ol>
</fieldset>
