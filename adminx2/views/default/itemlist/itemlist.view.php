<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<form id="edit_form" name="edit_form" method="post" action="<?=$app->go($app->module_key, false, '/save')?>">
		<fieldset>
			<ol>
				<li>
					<label class="required<?=$object->is_missing('title')?>" for="title"><?=$lng->text('itemlist:title')?></label>
					<input type="text" name="title" id="title" value="<?=$object->get_title()?>" />
				</li>
				<li class="medium">
					<label class="required<?=$object->is_missing('item_list_key')?>" for="item_list_key"><?=$lng->text('itemlist:item_list_key')?></label>
					<input type="text" name="item_list_key" id="item_list_key" value="<?=$object->get_item_list_key()?>"<?=($object->get_id()) ? ' readonly="readonly"' : ''?> />
				</li>
				<li class="medium">
					<label class="required" for="calc_by"><?=$lng->text('itemlist:calc_by')?></label>
					<select name="calc_by" id="calc_by">
						<?php
						foreach($calc_bys as $key) {
							$selected = ($key == $object->get_calc_by()) ? ' selected="selected"' : '';
							echo '<option value="' . $key . '"' . $selected . '>' . $lng->text('calc:' . $key) . '</option>';
						}
						?>
					</select>
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
