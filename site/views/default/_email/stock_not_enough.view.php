<view key="subject" value="Not enough stock of '<?=$product?>' for Sale <?=sprintf('%08s', $sale_id)?>" />


<view key="body">
	<h2 style="font: 18px Arial, Helvetica, sans-serif;">Hello <?=$recipient_name?>,</h2>

	<p style="font: 14px Arial, Helvetica, sans-serif;">The available stock of '<?=$product?>' was not enough for the sale
			#<?=sprintf('%08s', $sale_id)?> / Item #<?=sprintf('%08s', $item_id)?>, additional <?=$diff?> unit/s are required.</p>
</view>
