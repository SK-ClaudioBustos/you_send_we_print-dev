<h4><?=$lng->text('wholesaler:company_info')?></h4>

<?=$tpl->get_view('_input/text', array('field' => 'company', 'label' => 'wholesaler:company', 'val' => $wholesaler->get_company(),
		'required' => true, 'error' => $wholesaler->is_missing('company'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
<?=$tpl->get_view('_input/text', array('field' => 'business_type', 'label' => 'wholesaler:business_type', 'val' => $wholesaler->get_business_type(),
		/*'required' => true, 'error' => $wholesaler->is_missing('business_type'),*/ 'attr' => 'maxlength="60"', 'width' => 'full'))?>
<?=$tpl->get_view('_input/text', array('field' => 'website', 'label' => 'wholesaler:website', 'val' => $wholesaler->get_website(),
		'required' => false, 'error' => $wholesaler->is_missing('website'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>

<h4><?=$lng->text('wholesaler:billing_address')?></h4>

<?=$tpl->get_view('_input/text', array('field' => 'bill_address', 'label' => 'wholesaler:address', 'val' => $wholesaler->get_bill_address(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_address'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>

<?=$tpl->get_view('_input/select', array('field' => 'bill_country', 'label' => 'wholesaler:country', 'val' => $wholesaler->get_bill_country(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_country'),'width' => 'full', 
		'options' => $countries, 'is_assoc' => true))?>
		<span class="country_note" style="display: <?=(!$wholesaler->get_bill_country() || $wholesaler->get_bill_country() == 44) ? 'none' : 'block'; // US?>;"><?=$lng->text('wholesaler:overseas')?></span>
<?=$tpl->get_view('_input/select', array('field' => 'bill_state', 'label' => 'wholesaler:state', 'val' => $wholesaler->get_bill_state(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_state'), 'width' => 'full', 
		'options' => $states))?>

<?=$tpl->get_view('_input/text', array('field' => 'bill_city', 'label' => 'wholesaler:city', 'val' => $wholesaler->get_bill_city(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_city'), 'attr' => 'maxlength="120"', 'width' => 'full'))?>
<?=$tpl->get_view('_input/text', array('field' => 'bill_zip', 'label' => 'wholesaler:zip', 'val' => $wholesaler->get_bill_zip(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_zip'), 'attr' => 'maxlength="5"', 'width' => 'full', 'class' => 'short'))?>
<?=$tpl->get_view('_input/text', array('field' => 'bill_phone', 'label' => 'wholesaler:phone', 'val' => $wholesaler->get_bill_phone(),
		'required' => true, 'error' => $wholesaler->is_missing('bill_phone'), 'attr' => 'maxlength="20"', 'width' => 'full', 'class' => 'short'))?>
<?=/*$tpl->get_view('_input/text', array('field' => 'bill_fax', 'label' => 'wholesaler:fax', 'val' => $wholesaler->get_bill_fax(),
		'required' => false, 'error' => $wholesaler->is_missing('bill_fax'), 'attr' => 'maxlength="20"', 'width' => 'full', 'class' => 'short'))*/""?>


<?php 
/*
	<dt><label for="bill_country"><?=$lng->text('wholesaler:country')?> *</label></dt>
	<dd>
		<select name="bill_country" id="bill_country" data-required="required" title="<?=$lng->text('wholesaler:country')?>">
			<?php
			if ($wholesaler->get_id()) {
				while ($countries->list_paged()) {
					if ($wholesaler->get_bill_country() == $countries->get_id()) {
						echo '<option value="' . $countries->get_id() . '"' . $selected . '>' . $countries->get_country() . '</option>';
						break;
					}
				}
			} else { ?>
			<option value=""></option>
			<option value="44">United States of America</option>
			<?php
			while ($countries->list_paged()) {
				$selected = (($wholesaler->get_bill_country() == $countries->get_id()) ? ' selected="selected"' : '');
				echo '<option value="' . $countries->get_id() . '"' . $selected . '>' . $countries->get_country() . '</option>';
			}
			?>
			<?php } ?>
		</select>
		<span class="country_note" style="display: <?=(!$wholesaler->get_bill_country() || $wholesaler->get_bill_country() == 44) ? 'none' : 'block'; // US?>;"><?=$lng->text('wholesaler:overseas')?></span>
	</dd>

	<dt><label for="bill_state"><?=$lng->text('wholesaler:state')?> *</label></dt>
	<dd><select name="bill_state" id="bill_state" data-required="required" title="<?=$lng->text('wholesaler:state')?>">
		<option value=""></option>
		<option value="--"<?=($wholesaler->get_bill_state() == '--') ? ' selected="selected"' : ''?>>[<?=$lng->text('wholesaler:outside')?>]</option>
		<?php
		foreach($app->states as $key => $value) {
			$selected = (($wholesaler->get_bill_state() == $key) ? ' selected="selected"' : '');
			echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}
		?>
	</select></dd>
*/
?>
