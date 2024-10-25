<view key="subject" value="Minimum stock reached for '<?=$product?>'" />


<view key="body">
	<h2 style="font: 18px Arial, Helvetica, sans-serif;">Hello <?=$recipient_name?>,</h2>

	<p style="font: 14px Arial, Helvetica, sans-serif;">The stock of '<?=$product?>' reached the minumun of <?=$stock_min?>
			after Sale #<?=sprintf('%08s', $sale_id)?> / Item #<?=sprintf('%08s', $item_id)?>.</p>
</view>
