<fieldset>
	<ol class="clear_fix">
		<li>
			<label for="specs"><?=$lng->text('product:specs')?></label>
			<textarea name="specs" id="specs" cols="50" rows="5" class="tinymce tinymce_4"><?=$object->get_specs()?></textarea>
		</li>
	</ol>

	<?=$tpl->get_view('product/product_attach', array('object' => $object, 'folder' => $folder, 'attach' => $attach, 'i' => 1));?>
	<?=$tpl->get_view('product/product_attach', array('object' => $object, 'folder' => $folder, 'attach' => $attach, 'i' => 2));?>
	<?=$tpl->get_view('product/product_attach', array('object' => $object, 'folder' => $folder, 'attach' => $attach, 'i' => 3));?>
	<?=$tpl->get_view('product/product_attach', array('object' => $object, 'folder' => $folder, 'attach' => $attach, 'i' => 4));?>

</fieldset>

