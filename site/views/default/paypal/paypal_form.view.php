<form action="<?=$app->go('Paypal')?>" method="post" id="paypal_form">
	<p>
		<input type="hidden" name="charset" value="utf-8">
		<input type="hidden" name="cmd" value="_xclick">

		<input type="hidden" name="item_number" id="item_number" value="" />
		<input type="hidden" name="quantity" id="quantity" value="" />
		<input type="hidden" name="custom" id="custom" value="" />

		<? if (!$shipping) { ?>
		<input type="hidden" name="no_shipping" id="no_shipping" value="1" />
		<? } ?>

		<input type="hidden" name="business" id="business" value="" />
		<input type="hidden" name="return" id="return" value="" />
		<input type="hidden" name="rm" id="rm" value="2" />
		<input type="hidden" name="cancel_return" id="cancel_return" value="">
		<input type="hidden" name="notify_url" id="notify_url" value="" />

		<input type="hidden" name="item_name" id="item_name" value="<?=$lng->text('checkout:pp_name', $sale->get_id())?>" />
		<input type="hidden" name="amount" id="amount" value="" />
		<input type="hidden" name="currency_code" id="currency_code" value="" />
	</p>
</form>

<script type="text/javascript">
	//init_paypal(<?=$item_number?>, <?=$quantity?>, '<?=$token?>')
</script>