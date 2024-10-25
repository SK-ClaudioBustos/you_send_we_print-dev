<?
$ws = $address_info['wholesaler'];
//print_r($ws->to_array()); exit;
$sale_bill_address = $address_info['sale_bill_address'];
?>
<ul class="address_block bill_block clearfix">
	<?php if ($ws->get_id()) { ?>
	<li>
		<b><?=$lng->text('wholesaler:company')?>:</b> <?=$ws->get_company()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:last_name')?>:</b> <?=$sale_bill_address->get_last_name()?>
	</li>
	<?php } else  { ?>
	<li>
		<b><?=$lng->text('form:name')?>:</b> <?=$sale_bill_address->get_last_name()?>
	</li>
	<?php } ?>
	<li>
		<b><?=$lng->text('wholesaler:address')?>:</b> <?=$sale_bill_address->get_address()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:zip')?>:</b> <?=$sale_bill_address->get_zip()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:city')?>:</b> <?=$sale_bill_address->get_city()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:state')?>:</b> <?=$sale_bill_address->get_state()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:phone')?>:</b> <?=$sale_bill_address->get_phone()?>
	</li>
	<li>
		<b><?=$lng->text('checkout:email')?>:</b> <?=$ws->get_email()?>
	</li>
	<li>
		<b><?=$lng->text('wholesaler:payment')?>:</b> <?=(($sale->get_payment_type() == 1) ? 'Paypal' : 'CC ' . $sale->get_credit_card())?>
	</li>
</ul>



