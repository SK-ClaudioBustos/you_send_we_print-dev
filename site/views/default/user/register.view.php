<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
		<form class="form register-form" action="<?= $app->go($app->module_key, false, '/save') ?>" method="post">
			<div class="col-sm-6 clearfix">
				<div class="form-group">
					<label><b><?= $lng->text('register:text') ?></b></label>
					<label><?= $lng->text('register:text1') ?></label>
				</div>

				<?= $tpl->get_view('_input/text', array(
					'field' => 'first_name', 'label' => 'form:first_name', 'val' => $object->get_first_name(),
					'required' => true, 'error' => $object->is_missing('first_name'), 'attr' => 'maxlength="60"', 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'last_name', 'label' => 'form:last_name2', 'val' => $object->get_last_name(),
					'required' => true, 'error' => $object->is_missing('last_name'), 'attr' => 'maxlength="60"', 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'email', 'label' => 'register:email', 'val' => $object->get_email(),
					'required' => true, 'error' => $object->is_missing('email'), 'attr' => 'maxlength="100"', 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'company', 'label' => 'wholesaler:company', 'val' => $_SESSION['user_company'],
					'required' => true, 'error' => $object->is_missing('company'), 'attr' => 'maxlength="100"', 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'phone', 'label' => 'wholesaler:phone', 'val' => $_SESSION['user_phone'] ?: '',
					'required' => true, 'error' => $object->is_missing('phone'), 'attr' => 'maxlength="100"', 'width' => 'full'
				)) ?>
				<div class="form-group clearfix"></div>

				<?=/*$tpl->get_view('_input/text', array('field' => 'username', 'label' => 'register:username', 'val' => $object->get_username(),
						'required' => true, 'error' => $object->is_missing('username'), 'attr' => 'maxlength="' . $app->username_len_max . '"',
						'width' => 'full', 'class' => 'short',
						'help_text' => $lng->text('register:user_tip', $app->username_len_min, $app->username_len_max)))*/ '' ?>
				<?=/*$tpl->get_view('_input/text', array('field' => 'user_password', 'label' => 'register:password', 'val' => '',
						'type' => 'password','required' => true, 'error' => $object->is_missing('password'),
						'width' => 'full', 'class' => 'short',
						'help_text' => $lng->text('register:password_tip', $app->user_password_len_min, $app->user_password_len_max)))*/ '' ?>

				<div class="form-group<?= ($object->is_missing('agreed')) ? ' has-error' : '' ?>">
					<label class="checkbox" for="agreed">
						<input type="checkbox" id="agreed" name="agreed" class="checkbox" value="1" <?=/*($object->get_agreed() == 1) ? 'checked="checked"' : ''*/ '' ?> checked="checked" required />
						<?= sprintf(
							$lng->text('register:agree'),
							'<a target="_blank" href="' . $app->go('Section/terms') . '">',
							'</a>',
							'<a target="_blank" href="' . $app->go('Section/privacy') . '">',
							'</a>'
						) ?>
					</label>
				</div>
				<div class="form-group">
					<label class="checkbox" for="newsletter">
						<input type="checkbox" id="newsletter" name="newsletter" class="checkbox" value="1" <?= /*($object->get_newsletter() == 1) ? 'checked="checked"' : '' */ 'checked="checked"' ?> />
						<?= $lng->text('register:newsletter') ?>
					</label>
				</div>

				<div class="form-group">
					<button type="submit" class="btn yswp-red btn-outline pull-right"  data-callback="cb_submit">
						<?= $lng->text('register:next') ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</div>

			<div class="hidden-xs col-sm-6 picture">
				<div class="form-group" style="min-height: 560px; background: url(/data/site/back_register.jpg) top right no-repeat;">
				</div>
			</div>

			<?= $tpl->get_view('_elements/token', array('token' => $token)) ?>
			<input type="hidden" name="action" value="register" />
			<input type="hidden" name="tz" id="tz" value="" />
			<input type="hidden" name="dst" id="dst" value="" />
		</form>
	</div>
</view>


<view key="page_scripts">
	<script>
		init_register();
	</script>
</view>