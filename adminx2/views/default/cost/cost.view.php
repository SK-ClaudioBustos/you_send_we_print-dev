<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<form id="edit_form" name="edit_form" method="post" action="<?=$app->go($app->module_key, false, '/save')?>">
		<fieldset>
			<ol>
				<li>
					<?=$tpl->get_view('_input/text', array('object' => $object, 'id' => 'title', 'label' => $lng->text('cost:title'), 'required' => true));?>
				</li>
				<li class="small" style="width: 600px;">
					<label class="required<?=$object->is_missing('cost_key')?>" for="cost_key"><?=$lng->text('cost:cost_key')?></label>
					<input type="text" name="cost_key" id="cost_key" maxlength="100"
							<?=($object->get_id()) ? ' readonly="readonly"' : ''?>
							value="<?=$object->get_cost_key()?>" />
				</li>

				<li class="small" style="width: 600px;">
					<label class="required<?=$object->is_missing('value')?>" for="value"><?=$lng->text('cost:value')?></label>
					<input type="text" name="value" id="value" maxlength="10" class="small number" value="<?=$object->get_value()?>" />
					<div class="clear_float"></div>
				</li>

				<li>
					<input type="submit" id="submit" name="submit" class="submit_form" value="<?=$lng->text('form:save')?>" />
					<input type="button" id="cancel" name="cancel" class="cancel_form" value="<?=$lng->text('form:cancel')?>" />
				</li>

			</ol>
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="id" value="<?=$object->get_id()?>" />
		</fieldset>
	</form>
</div>
