<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $lng->text('account:ws_go') ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-xs-12 clearfix">
			<?= $tpl->get_view('user/account_tab', array('wholesaler' => $wholesaler)) ?>
		</div>

		<form method="post" id="wholesaler-form" class="register-form" enctype="multipart/form-data" action="<?= $app->go($app->module_key, false, '/save/' . $user_id) ?>">
			<div class="col-sm-6 clearfix">

				<h2><?= $lng->text('account:ws_go') ?></h2>
				<?php if ($wholesaler->get_status() == 'ws_pending') { ?>
					<div class="alert alert-warning">
						<i class="fa fa-warning"></i> <?= $lng->text('wholesaler:pemding') ?>
					</div>
				<?php } ?>

				<?php if ($wholesaler->get_status() == "") { ?>
					<?= $tpl->get_view('user/account_ws_user', array('object' => $object, 'wholesaler' => $wholesaler)) ?>
				<?php } ?>

				<?= $tpl->get_view('user/account_ws_company', array(
					'wholesaler' => $wholesaler,
					'countries' => $countries,
					'states' => $states,
				)) ?>

				<?= $tpl->get_view('user/account_ws_shipping', array(
					'object' => $object,
					'wholesaler' => $wholesaler,
					'countries' => $countries,
					'states' => $states,
				)) ?>
				<?= $tpl->get_view('user/account_ws_files', array(
					'wholesaler' => $wholesaler,
					'permit' => $permit,
					'certificate' => $certificate,
					'fiscal_years' => $fiscal_years,
				)) ?>

				<div class="additional">
					<?= $tpl->get_view('_input/select', array(
						'field' => 'language', 'label' => 'wholesaler:language', 'val' => '',
						'required' => false, 'error' => $wholesaler->is_missing('language'), 'width' => 'full', 'class' => 'short',
						'options' => $languages
					)) ?>
				</div>

				<div class="form-group group-buttons clearfix">
					<button type="submit" class="btn yswp-red btn-outline pull-right">
						<?= $lng->text('form:update') ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>

				<input type="hidden" name="action" value="account_ws" />
			</div>

			<div class="hidden-xs col-sm-6 picture back_orders">
				<div class="form-group">
				</div>
			</div>

		</form>
	</div>
</view>


<view key="page_scripts">
	<script>
		init_account_ws(<?= $active ?>);
	</script>
</view>