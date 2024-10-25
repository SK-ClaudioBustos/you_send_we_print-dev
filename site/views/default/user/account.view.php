<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-xs-12 clearfix">
			<?= $tpl->get_view('user/account_tab', array('wholesaler' => $wholesaler)) ?>
		</div>

		<form class="form register-form" action="<?= $app->go($app->module_key, false, '/save') ?>" method="post">
			<div class="col-sm-6 clearfix">
				<h2><?= $lng->text('account:user') ?></h2>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'username', 'label' => 'register:username', 'val' => $object->get_username(),
					'width' => 'full', 'class' => 'short', 'readonly' => true
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'user_password', 'label' => 'register:password', 'val' => '````````````',
					'type' => 'password', 'required' => true, 'error' => $object->is_missing('password'),
					'width' => 'full', 'class' => 'short',
					'help_text' => '<b>' . $lng->text('account:password_tip1') . '</b><br />' .
						$lng->text('register:password_tip', $app->user_password_len_min, $app->user_password_len_max)
				)) ?>

				<?= $tpl->get_view('_input/text', array(
					'field' => 'email', 'label' => 'register:email', 'val' => $object->get_email(),
					'required' => true, 'error' => $object->is_missing('email'), 'attr' => 'maxlength="60"', 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'email2', 'label' => 'register:email2', 'val' => $object->get_email_repeat(),
					'required' => true, 'error' => $object->is_missing('email'), 'attr' => 'maxlength="60"', 'width' => 'full'
				)) ?>

				<?php if (!$object->get_confirmed()) { ?>
					<?= $tpl->get_view('_input/link', array('field' => 'email_confirm', 'label' => 'user:confirm_email', 'val' => $lng->text('user:click_to_confirm'), 'width' => 'full')) ?>
				<?php } ?>


				<div class="form-group">
					<label class="checkbox" for="newsletter">
						<input type="checkbox" id="newsletter" name="newsletter" class="checkbox" value="1" <?= ($object->get_newsletter() == 1) ? 'checked="checked"' : '' ?> />
						<?= $lng->text('register:newsletter') ?>
					</label>
				</div>

				<div class="form-group">
					<button type="submit" class="btn yswp-red btn-outline pull-right">
						<?= $lng->text(($wholesaler->get_id()) ? 'form:update' : 'register:next') ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</div>

			<div class="col-sm-6 picture back_orders">
				<div class="form-group">
				</div>
			</div>

			<?= $tpl->get_view('_elements/token', array('token' => $token)) ?>
			<input type="hidden" name="action" value="account" />
			<input type="hidden" name="id" value="<?= $object->get_id() ?>" />
		</form>
	</div>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		let ajax_confirm_url = '<?= $app->go($app->module_key, false, '/ajax_confirm') ?>';
		init_confirm();
	</script>
</view>