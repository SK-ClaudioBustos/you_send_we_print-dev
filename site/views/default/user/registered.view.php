<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<form method="post" class="form register-form" enctype="multipart/form-data" action="<?= $app->go($app->module_key, false, '/save') ?>">
			<div class="col-sm-12 clearfix">
				<div id='mail_confirmed' style="<?= isset($second) ? 'width:205%;text-align:left;padding-left:10px;' : '' ?> ">
					<h2><?= $header ?></h2>
				</div>
				<h4 style="<?= isset($second) ? 'font-size:20px !important' : '' ?>"><?= $subheader1 ?></h4>
				<h4 style=" <?= isset($second) ? 'font-size:20px !important' : '' ?>"><?= $subheader2 ?></h4>


				<?= $tpl->get_view('user/account_ws_files', array('wholesaler' => $wholesaler, 'permit' => $permit, 'certificate' => $certificate, 'fiscal_years' => $fiscal_years)) ?>

				<div class=" form-group group-buttons clearfix">

					<button type="submit" class="btn yswp-red btn-outline pull-right g-recaptcha" data-sitekey="<?= $app->captcha_public ?>" data-callback="cb_submit">
						<?= $lng->text('form:save') ?> <i class="fa fa-arrow-circle-right"></i>
					</button>

					<?php if (isset($second)) { ?>
						<a href="<?= $app->go('Home') ?>" class="<?= ($final) ? 'pull-left' : 'pull-right' ?>" style="margin-right:18px">
							<button type="button" class="btn yswp-red btn-outline pull-right">
								<?= $lng->text('form:shop') ?> <i class="fa fa-home"></i>
							</button>
						</a>
					<?php } ?>
				</div>

				<input type="hidden" name="maxlength" value="200" />
				<input type="hidden" name="action" value="register_ws_files" />
			</div>
		</form>
	</div>
</view>

<view key="page_scripts">
</view>