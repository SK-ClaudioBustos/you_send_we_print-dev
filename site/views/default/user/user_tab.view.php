<div class="tabbable-line">
    <ul class="nav nav-tabs ">
		<?php if ($wholesaler->get_id()) { ?>
        <li class="active">
            <a id="usr_wholesale" href="<?=$app->go($app->module_key . '/account', false, '/wholesaler')?>"><?=$lng->text('account:ws_go')?></a>
        </li>
		<?php } ?>
		<?php if ($user_id) { // admin editing ?>
		<?php } else { ?>
		<li <?=($wholesaler->get_id() ? '' : ' class="active"')?>><a id="usr_account" href="<?=$app->go($app->module_key . '/account', false, '/account')?>"><?=$lng->text('account:user')?></a></li>
		<?php if ($wholesaler->get_status() == 'ws_approved') { ?>
		<li><a id="usr_orders" href="<?=$app->go($app->module_key . '/account', false, '/orders')?>"><?=$lng->text('account:orders')?></a></li>
		<li><a id="usr_addresses" href="<?=$app->go($app->module_key . '/account', false, '/addresses')?>"><?=$lng->text('account:addresses')?></a></li>
		<?php } ?>
		<?php } ?>
    </ul>
</div>



<ul class="spp_tabs clear_fix hidden">
	<?php if ($wholesaler->get_id()) { ?>
	<li class="first"><a id="usr_wholesale" href="<?=$app->go($app->module_key . '/account', false, '/wholesaler')?>"><?=$lng->text('account:ws_go')?></a></li>
	<?php } ?>


	<?php if ($user_id) { // admin editing ?>
	<?php } else { ?>
	<li<?=($wholesaler->get_id() ? '' : ' class="first"')?>><a id="usr_account" href="<?=$app->go($app->module_key . '/account', false, '/account')?>"><?=$lng->text('account:user')?></a></li>

	<?php if ($wholesaler->get_status() == 'ws_approved') { ?>
	<li><a id="usr_orders" href="<?=$app->go($app->module_key . '/account', false, '/orders')?>"><?=$lng->text('account:orders')?></a></li>
	<li><a id="usr_addresses" href="<?=$app->go($app->module_key . '/account', false, '/addresses')?>"><?=$lng->text('account:addresses')?></a></li>
	<?php } ?>
	<?php } ?>
</ul>
