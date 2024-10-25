<?
$ws = $address_info['wholesaler'];
//print_r($ws->to_array()); exit;
$sale_ship_address = $address_info['sale_ship_address'];
$sale_shipping = $address_info['sale_shipping'];
?>

<ul class="address_block bill_block clear_fix">
	<? if ($ws->get_id()) { ?>
	<li>
		<b><?=$lng->text('wholesale:by_product')?></b>
	</li>
	<? } else if ($sale_ship_address->get_same_address() == $sale_ship_address->same_address_enum('local_pickup')) { ?>
	<li>
		<b><?=$lng->text('product:local_pickup')?></b>
	</li>
	<? } else { ?>
	<li>
		<b><?=$lng->text('wholesale:last_name')?>:</b> <?=$sale_ship_address->get_last_name()?>
	</li>
	<li>
		<b><?=$lng->text('wholesale:address')?>:</b> <?=$sale_ship_address->get_address()?>
	</li>
	<li>
		<b><?=$lng->text('wholesale:zip')?>:</b> <?=$sale_ship_address->get_zip()?>
	</li>
	<li>
		<b><?=$lng->text('wholesale:city')?>:</b> <?=$sale_ship_address->get_city()?>
	</li>
	<li>
		<b><?=$lng->text('wholesale:state')?>:</b> <?=$sale_ship_address->get_state()?>
	</li>
	<li>
		<b><?=$lng->text('wholesale:phone')?></b> <?=$sale_ship_address->get_phone()?>
	</li>
	<li>
		<b><?=$lng->text('checkout:email')?>:</b> <?=$sale_ship_address->get_email()?>
	</li>
	<li>
		<b><?=$lng->text('product:ship_method')?>:</b> <?=$sale_shipping->get_shipping_type()?>
	</li>
	<? } ?>
</ul>
