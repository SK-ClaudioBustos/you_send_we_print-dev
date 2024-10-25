<?php
$ws = $address_info['wholesaler'];
$sale_bill_address = $address_info['sale_bill_address'];
$new_address = ($sale_bill_address->get_address_ws() == $sale_bill_address->address_ws_enum('new'));
?>
<input type="hidden" name="sale_bill_address_id" id="sale_bill_address_id" value="<?=$sale_bill_address->get_id()?>" />
<input type="hidden" name="zip_default" id="zip_default" value="<?=$ws->get_bill_zip()?>" />
<input type="hidden" name="taxes" id="taxes" value="<?=$sale->get_taxes()?>" />

<div class="form-body">
	<div class="row">

		<div class="col-sm-12">
			<div class="form-group">
				<div class="radio-list">
					<label class="radio-inline">
						<input type="radio" name="billing_address" class="billing_address" id="billing_address" value="1"<?=(!$new_address) ? ' checked="checked"' : ''?> />
						<?=$lng->text('product:ship_default')?></label>
				</div>
				<div class="bill_info bill_default"<?=($new_address) ? ' style="display: none;"' : ''?>>
					<?=$address_info['default_bill_address']?>
				</div>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="form-group">
				<div class="radio-list">
					<label class="radio-inline">
						<input type="radio" name="billing_address" class="billing_address" value="3"<?=($new_address) ? ' checked="checked"' : ''?> />
						<?=$lng->text('product:ship_change')?></label>
				</div>
				<div class="bill_info bill_new"<?=(!$new_address) ? ' style="display: none;"' : ''?>>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_last_name', 'label' => 'form:last_name', 
							'val' => $sale_bill_address->get_last_name(), 'required' => true, 'title' => 'form:last_name'))?>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_address', 'label' => 'form:address', 
							'val' => $sale_bill_address->get_address(), 'required' => true, 'title' => 'form:address'))?>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_city', 'label' => 'form:city', 
							'val' => $sale_bill_address->get_city(), 'required' => true, 'title' => 'form:city'))?>
					<?=$tpl->get_view('cart/checkout_select', array('field' => 'bill_state', 'label' => 'form:state', 
							'val' => $sale_bill_address->get_state(), 'required' => true, 'title' => 'form:state',
							'options' => $app->states_short, 'none_val' => '', 'none_text' => '', 'width' => 'small'))?>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_zip', 'label' => 'form:zip', 'width' => 'small', 
							'val' => $sale_bill_address->get_zip(), 'required' => true, 'title' => 'form:zip', 'attr' => 'autocomplete="off"'))?>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_phone', 'label' => 'form:phone', 
							'val' => $sale_bill_address->get_phone(), 'required' => true, 'title' => 'form:phone', 'width' => 4))?>
					<?=$tpl->get_view('cart/checkout_text', array('field' => 'bill_email', 'label' => 'form:email', 
							'val' => $sale_bill_address->get_email(), 'required' => true, 'title' => 'form:email', 'width' => 4))?>
				</div>
			</div>
		</div>

	</div>
</div>
