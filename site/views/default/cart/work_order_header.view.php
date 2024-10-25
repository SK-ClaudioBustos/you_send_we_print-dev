<div class="invoice clearfix<?=(!$first) ? ' hidden_web' : ''?>">
	<div class="wo_info">
		<div>
			<h1><?=$title?></h1>
		</div>
		<div>
			<h2 class="source"><?=strtoupper($sale->get_source())?></h2>
		</div>
		<div>
			<h2><?=sprintf('%08d', $sale->get_id())?></h2>
		</div>
		<div>
			<h2><?=$date_sold?></h2>
		</div>
	</div>

	<div class="wo_to">
		<div>
			<h1><?=$lng->text('cart:client')?></h1>
		</div>
		<?php
		$ws = $address_info['wholesaler'];
		$sale_bill_address = $address_info['sale_bill_address'];
		?>
		<?php if ($ws->get_id()) { ?>
		<div>
			<b><?=$lng->text('wholesaler:company')?>:</b> <?=$ws->get_company()?>
		</div>
		<div>
			<b><?=$lng->text('wholesaler:last_name')?>:</b> <?=$sale_bill_address->get_last_name()?>
		</div>
		<?php } else  { ?>
		<div>
			<b><?=$lng->text('form:name')?>:</b> <?=$sale_bill_address->get_last_name()?>
		</div>
		<?php } ?>
		<div>
			<b><?=$lng->text('wholesaler:phone')?>:</b> <?=$sale_bill_address->get_phone()?>
		</div>
	</div>
</div>
