<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<form method="post" class="form register-form" enctype="multipart/form-data" action="<?= $app->go($app->module_key, false, '/save') ?>">
			<div class="col-sm-12 clearfix">
				<div id='mail_confirmed' class="<?= $returned ? 'oculto' : '' ?>">
					<h2><?= $lng->text('mail:confirmed:header') ?></h2>
				</div>
				<h4><?= $lng->text('mail:confirmed:body1') ?></h4>


				<?= $tpl->get_view('user/account_ws_user', array('object' => $wholesaler, 'wholesaler' => $wholesaler)) ?>

				<?= $tpl->get_view('user/account_ws_company', array('wholesaler' => $wholesaler, 'countries' => $countries, 'states' => $states)) ?>
				<?= /*$tpl->get_view('user/account_ws_files', array('wholesaler' => $wholesaler, 'permit' => $permit, 'certificate' => $certificate, 'fiscal_years' => $fiscal_years))*/ '' ?>

				<div class="additional">
					<?= $tpl->get_view('_input/select', array(
						'field' => 'how_hear', 'label' => 'wholesaler:how_hear', 'val' => $wholesaler->get_how_hear(),
						'none_val' => '',
						'required' => true, 'error' => $wholesaler->is_missing('how_hear'), 'width' => 'full',
						'options' => $how_hears
					)) ?>
					<?= $tpl->get_view('_input/select', array(
						'field' => 'language', 'label' => 'wholesaler:language', 'val' => $wholesaler->get_language(), 'none_val' => '',
						'required' => true, 'error' => $wholesaler->is_missing('language'), 'width' => 'full', 'class' => 'short',
						'options' => $languages
					)) ?>
				</div>

				<!--<div class="validation_error">
					<h5><?= $lng->text('register:fix_first') ?></h5>
				</div>-->

				<div class="form-group group-buttons clearfix">
					<button type="submit" class="btn yswp-red btn-outline pull-right g-recaptcha" data-sitekey="<?= $app->captcha_public ?>" data-callback="cb_submit">
						<?= $lng->text('form:save') ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>

				<input type="hidden" name="maxlength" value="200" />
				<input type="hidden" name="action" value="register_ws" />
			</div>
		</form>
	</div>
</view>


<view key="page_scripts">
	<script>
		init_register_ws();
	</script>
</view>