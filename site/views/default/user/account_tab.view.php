<?php if ($wholesaler->get_id()) { ?>
<div class="tabbable-line">
	<ul class="nav nav-tabs">
		<?php $url = $app->go($app->module_key . '/account', false, '/wholesaler'); ?>
		<li <?=(substr($app->page_full, 0, strlen($url)) == $url) ? ' class="active"' : ''?>>
			<a id="usr_wholesale" href="<?=$url?>"><?=$lng->text('account:ws_go')?></a></li>

		<?php if ($user_id) { // admin editing ?>
		<?php } else { ?>
		<li <?=($app->page_full == $url = $app->go($app->module_key . '/account')) ? ' class="active"' : ''?>>
			<a id="usr_account" href="<?=$url?>"><?=$lng->text('account:user')?></a></li>
		
		<?php if ($wholesaler->get_status() == 'ws_approved') { ?>
		<li <?=($app->page_full == $url = $app->go($app->module_key . '/account', false, '/orders')) ? ' class="active"' : ''?>>
			<a id="usr_orders" href="<?=$url?>"><?=$lng->text('account:orders')?></a></li>
		<?php $url = $app->go($app->module_key . '/account', false, '/addresses'); ?>
		<li <?=(substr($app->page_full, 0, strlen($url)) == $url) ? ' class="active"' : ''?>>
			<a id="usr_addresses" href="<?=$url?>"><?=$lng->text('account:addresses')?></a></li>
		<?php } ?>
		
		<?php } ?>
	</ul>
</div>
<?php } ?>
