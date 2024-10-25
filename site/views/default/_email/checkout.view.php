<view key="subject">Your Purchase #<?=sprintf('%08s', $sale_id)?></view>

<view key="body">
	<h2 style="font: 18px Arial, Helvetica, sans-serif;">Hello <?=$recipient_name?></h2>

	<p style="font: 14px Arial, Helvetica, sans-serif;">You can access to the purchase info and upload the artwork by entering the following link:</p>

	<p style="font: 14px Arial, Helvetica, sans-serif;"><a href="<?=$url?>"><?=$url?></a></p>
</view>
