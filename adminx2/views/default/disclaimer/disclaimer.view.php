<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<form id="edit_form" name="edit_form" method="post" action="<?=$app->go($app->module_key, false, '/save')?>">
		<fieldset>
			<ol>
				<li>
					<label class="required<?=$object->is_missing('title')?>" for="title"><?=$lng->text('disclaimer:title')?></label>
					<input type="text" name="title" id="title" value="<?=$object->get_title()?>" />
				</li>
				<li class="check" style="padding-top: 12px;">
					<input name="featured" id="featured" type="checkbox" value="1" <?=($object->get_featured()) ? ' checked="checked"' : ''?>>
					<label for="featured" class="checkbox"><?=$lng->text('disclaimer:featured')?></label>
				</li>

				<li>
					<label class="<?php//= required  $object->is_missing('content')?>" for="scontent"><?=$lng->text('disclaimer:content')?></label>
					<textarea name="content" id="scontent" cols="50" rows="5" class="tall tinymce"><?=$object->get_content()?></textarea>
					<div class="clear_float"></div>
				</li>

				<li>
					<input type="submit" id="submit" name="submit" class="submit_form" value="<?=$lng->text('form:save')?>" />
					<input type="button" id="cancel" name="cancel" class="cancel_form" value="<?=$lng->text('form:cancel')?>" />
				</li>

			</ol>
			<input type="hidden" name="lang_iso" value="es" />
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="id" value="<?=$object->get_id()?>" />
		</fieldset>
	</form>
</div>

<script type="text/javascript" src="<?=$cfg->url->tinymce_folder?>/jquery.tinymce.js"></script>
<script type="text/javascript">
	$(function() { tiny_mce_init('<?=$cfg->url->tinymce_folder?>', '<?=$lng->get_lang_iso()?>'); });
</script>
