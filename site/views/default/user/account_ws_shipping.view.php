<div class="ws_shipping"<?=($wholesaler->get_bill_country() != 44 || $wholesaler->get_status() != 'ws_approved') ? ' style="display: none;"' : ''?>>
	<h4><?=$lng->text('wholesaler:shipping_address')?></h4>

	<div class="form-group">
		<label class="checkbox" for="ship_same">
			<input type="checkbox" id="ship_same" name="ship_same" class="checkbox" value="1" <?=($wholesaler->get_ship_same() == 1) ? 'checked="checked"' : ''?> />
			<?=$lng->text('wholesaler:ship_same')?>
		</label>
	</div>

	<div class="shipping-group<?=($wholesaler->get_ship_same() == 1) ? ' disabled' : ''?>">
		<?=$tpl->get_view('_input/text', array('field' => 'ship_company', 'label' => 'wholesaler:company', 'val' => $wholesaler->get_ship_company(),
				'required' => true, 'error' => $wholesaler->is_missing('company'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_first_name', 'label' => 'wholesaler:first_name', 'val' => $wholesaler->get_ship_first_name(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_first_name'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_last_name', 'label' => 'wholesaler:last_name', 'val' => $wholesaler->get_ship_last_name(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_last_name'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>


		<?=$tpl->get_view('_input/text', array('field' => 'ship_address', 'label' => 'wholesaler:address', 'val' => $wholesaler->get_ship_address(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_address'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
		<?=$tpl->get_view('_input/select', array('field' => 'ship_state', 'label' => 'wholesaler:state', 'val' => $wholesaler->get_ship_state(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_state'), 'width' => 'full', 
				'options' => $states))?>

		<?=$tpl->get_view('_input/text', array('field' => 'ship_city', 'label' => 'wholesaler:city', 'val' => $wholesaler->get_ship_city(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_city'), 'attr' => 'maxlength="120"', 'width' => 'full'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_zip', 'label' => 'wholesaler:zip', 'val' => $wholesaler->get_ship_zip(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_zip'), 'attr' => 'maxlength="5"', 'width' => 'full', 'class' => 'short'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_phone', 'label' => 'wholesaler:phone', 'val' => $wholesaler->get_ship_phone(),
				'required' => true, 'error' => $wholesaler->is_missing('ship_phone'), 'attr' => 'maxlength="20"', 'width' => 'full', 'class' => 'short'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_fax', 'label' => 'wholesaler:fax', 'val' => $wholesaler->get_ship_fax(),
				'required' => false, 'error' => $wholesaler->is_missing('ship_fax'), 'attr' => 'maxlength="20"', 'width' => 'full', 'class' => 'short'))?>
	</div>
</div>

<?php 
/*
				<div>
					<dl class="clear_fix ship<?=($wholesaler->get_ship_same()) ? ' disabled' : ''?>">
						<dt><label for="ship_company"><?=$lng->text('wholesale:company')?> *</label></dt>
						<dd><input type="text" name="ship_company" id="ship_company" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:company')?>" value="<?=$wholesaler->get_ship_company()?>" /></dd>

						<dt><label for="ship_first_name"><?=$lng->text('wholesale:first_name')?> *</label></dt>
						<dd><input type="text" name="ship_first_name" id="ship_first_name" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:first_name')?>" value="<?=$wholesaler->get_ship_first_name()?>" /></dd>
						<dt><label for="ship_last_name"><?=$lng->text('wholesale:last_name')?> *</label></dt>
						<dd><input type="text" name="ship_last_name" id="ship_last_name" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:last_name')?>" value="<?=$wholesaler->get_ship_last_name()?>" /></dd>
						<dt><label for="ship_address"><?=$lng->text('wholesale:address')?> *</label></dt>
						<dd><input type="text" name="ship_address" id="ship_address" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:address')?>" value="<?=$wholesaler->get_ship_address()?>" /></dd>
						<dt><label for="ship_city"><?=$lng->text('wholesale:city')?> *</label></dt>
						<dd><input type="text" name="ship_city" id="ship_city" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:city')?>" value="<?=$wholesaler->get_ship_city()?>" /></dd>
						<dt><label for="ship_state"><?=$lng->text('wholesale:state')?> *</label></dt>
						<dd><select name="ship_state" id="ship_state" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:state')?>">
							<option value=""></option>
							<option value="--">[<?=$lng->text('wholesale:outside')?>]</option>
							<?php
							foreach($app->states as $key => $value) {
								$selected = (($wholesaler->get_ship_state() == $key) ? ' selected="selected"' : '');
								echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
							}
							?>
						</select></dd>
						<dt><label for="ship_zip"><?=$lng->text('wholesale:zip')?> *</label></dt>
						<dd><input type="text" name="ship_zip" id="ship_zip" maxlength="5" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:zip')?>" value="<?=$wholesaler->get_ship_zip()?>" /></dd>
						<dt><label for="ship_phone"><?=$lng->text('wholesale:phone')?> *</label></dt>
						<dd><input type="text" name="ship_phone" id="ship_phone" data-required="required" class="required" title="<?=$lng->text('wholesale:ship:phone')?>" value="<?=$wholesaler->get_ship_phone()?>" /></dd>
						<dt><label for="ship_fax"><?=$lng->text('wholesale:fax')?></label></dt>
						<dd><input type="text" name="ship_fax" id="ship_fax" class="light" value="<?=$wholesaler->get_ship_fax()?>" /></dd>
						<dd class="sep"></dd>
					</dl>
				</div>
*/
?>
