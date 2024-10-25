<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<ul class="spp_tabs">
		<li><a class="current" href="#">Main</a></li>
		<?php if ($object->get_id() && in_array($object->get_item_list_key(), array('material', 'mounting'))) { ?>
		<li><a href="#">Cut</a></li>
		<?php } ?>
		<li class="clear_float"></li>
	</ul>

	<form id="edit_form" name="edit_form" method="post" action="<?=$app->go($app->module_key, false, '/save')?>">
		<div class="spp_panes" style="min-height: 270px;">
			<div>
				<fieldset>
					<ol class="clear_fix">
						<li>
							<label class="required<?=$object->is_missing('title')?>" for="title"><?=$lng->text('item:title')?></label>
							<input type="text" name="title" id="title" value="<?=$object->get_title()?>" />
						</li>
						<li class="medium">
							<label class="required<?=$object->is_missing('item_list_key')?>" for="item_list_key"><?=$lng->text('item:list')?></label>
							<select name="item_list_key" id="item_list_key">
								<option value=""></option>
								<?php
								$lists = array();
								while($item_lists->list_paged()) {
									$lists[$item_lists->get_item_list_key()] = $item_lists->get_calc_by();

									$selected = (($item_lists->get_item_list_key() == $object->get_item_list_key()) ? ' selected="selected"' : '');
									echo '<option value="' . $item_lists->get_item_list_key() . '"' . $selected . '>' . $item_lists->get_title() . '</option>';
								}
								?>
							</select>
						</li>
						<li class="tiny">
							<label for="item_code"><?=$lng->text('item:item_code')?></label>
							<input type="text" name="item_code" id="item_code" maxlength="16" value="<?=$object->get_item_code()?>" />
						</li>
						<li class="tiny check">
							<input name="active" id="active" type="checkbox" value="1" <?=($object->get_active()) ? ' checked="checked"' : ''?> />
							<label for="active" class="checkbox"><?=$lng->text('form:active')?></label>
						</li>

						<li class="tiny new_row">
							<label class="required<?=$object->is_missing('price')?>" for="price"><?=$lng->text('item:price')?></label>
							<input type="text" name="price" id="price" maxlength="10" class="small number" value="<?=$object->get_price()?>" />
						</li>
						<li class="tiny">
							<label for="price"><?=$lng->text('item:retail_price')?></label>
							<input type="text" name="ws_price" id="ws_price" class="small number" readonly="readonly" value="<?=number_format($object->get_price() * (100 + $app->retail_incr) / 100, 2)?>" />
						</li>
						<li class="tiny">
							<label class="<?=($object->get_list_calc_by() == 'variable') ? 'required' : '' ?><?=$object->is_missing('calc_by')?>" for="calc_by"><?=$lng->text('item:calc_by')?></label>
							<select name="calc_by" id="calc_by"<?=($object->get_list_calc_by() == 'variable') ? '' : ' disabled="disabled"' ?>>
								<option value=""></option>
								<?php
								foreach($calc_bys as $key) {
									$selected = ($key == $object->get_calc_by()) ? ' selected="selected"' : '';
									echo '<option value="' . $key . '"' . $selected . '>' . $lng->text('calc:' . $key) . '</option>';
								}
								?>
							</select>
						</li>
						<li class="tiny">
							<label for="weight"><?=$lng->text('item:weight')?></label>
							<input type="text" name="weight" id="weight" maxlength="10" class="small number" value="<?=$object->get_weight()?>" />
						</li>

						<li>
							<label for="description"><?=$lng->text('item:description')?></label>
							<textarea name="description" id="description" cols="50" rows="5" class="tinymce"><?=$object->get_description()?></textarea>
							<div class="clear_float"></div>
						</li>

						<li class="tiny">
							<label for="max_width"><?=$lng->text('item:max_width')?></label>
							<input type="text" name="max_width" id="max_width" maxlength="10" class="small number" value="<?=$object->get_max_width()?>" />
						</li>
						<li class="tiny">
							<label for="max_length"><?=$lng->text('item:max_length')?></label>
							<input type="text" name="max_length" id="max_length" maxlength="10" class="small number" value="<?=$object->get_max_length()?>" />
						</li>
						<li class="medium check">
							<input name="max_absolute" id="max_absolute" type="checkbox" value="1" <?=($object->get_max_absolute()) ? ' checked="checked"' : ''?> />
							<label for="max_absolute" class="checkbox"><?=$lng->text('item:max_absolute')?></label>
						</li>
					</ol>

				</fieldset>
			</div>

			<div>
				<fieldset>
					<div class="container">
						<div class="check_list">
							<ol>
								<?php
								while($cut_items->list_paged()) {
									$checked = (array_key_exists((string)$cut_items->get_id(), $item_cuts)) ? ' checked="checked"' : '';
									echo '<li><input type="checkbox" value="1" name="itm_' . $cut_items->get_id() . '" id="itm_' . $cut_items->get_id() . '"' . $checked . ' />';
									echo '<label for="itm_' . $cut_items->get_id() . '">' . (($cut_items->get_item_code()) ? '[' . $cut_items->get_item_code() . '] ' : '') . $cut_items->get_title() . '</label></li>';
								}
								?>
							</ol>
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<input type="submit" id="submit" name="submit" class="submit_form" value="<?=$lng->text('form:save')?>" />
		<input type="button" id="cancel" name="cancel" class="cancel_form" value="<?=$lng->text('form:cancel')?>" />

		<input type="hidden" name="lang_iso" value="es" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</div>

<script type="text/javascript" src="<?=$cfg->url->tinymce_folder?>/jquery.tinymce.js"></script>
<script type="text/javascript">
	var lists = <?=json_encode($lists)?>;

	init_single('<?=$cfg->url->tinymce_folder?>', '<?=$lng->get_lang_iso()?>');
</script>

