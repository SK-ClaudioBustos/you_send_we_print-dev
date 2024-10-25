<div class="col-md-12" id="<?= $user_id ? 'b_logged' : 'b_guest' . $pos ?>">
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	<div class="info_top <?= ($banner['url']) ? "banner_link" : "" ?>" <?= ($banner['url']) ? "data-link='{$banner['url']}'" : "" ?>>
		<div class="banner_header_div">
			<h2><?= ($user_id) ? $banner['user_welcome'] . " " . $app->username . ". " . $banner['user_following'] : $banner['signup_text'] ?></h2>
		</div>
		<div class="clearfix">
			<div class="info_full">
				<h2 id="info_full_1_h2"><?= ($user_id) ? $banner['user_welcome'] . " " . $app->username . ". " . $banner['user_following'] : $banner['signup_text'] ?></h2>
				<p><?= ($user_id) ? $banner['user_subtitle'] : $banner['signup_subtitle'] ?></p>
				<div class="banner-signup">
					<p class="<?= ($user_id) ? 'full_banner_text' : '' ?>">
						<span><?= $banner['banner_title'] ?></span><br>
						<?= $banner['banner_text'] ?>
					</p>

					<form class="register-form <?= ($user_id) ? 'oculto' : '' ?>" action="<?= $app->go('User', false, '/save') ?>" method="post">
						<div class="home-signup">
							<?= $tpl->get_view('_input/text', [
								'field' => 'first_name',
								'label' => 'form:first_name',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
							]) ?>
							<?= $tpl->get_view('_input/text', [
								'field' => 'last_name',
								'id' => 'last_name_1',
								'label'	=> 'form:last_name2',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
								'class' => 'last_name_1',
							]) ?>
							<?= $tpl->get_view('_input/text', [
								'field' => 'company',
								'label' => 'wholesaler:company',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
							]) ?>
							<?= $tpl->get_view('_input/text', [
								'field' => 'last_name',
								'id' => 'last_name_2',
								'label'	=> 'form:last_name2',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
								'class' => 'last_name_2',
							]) ?>
							<?= $tpl->get_view('_input/text', [
								'field' => 'phone',
								'label'	=> 'wholesaler:phone',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
							]) ?>
							<?= $tpl->get_view('_input/text', [
								'field' => 'email',
								'label' => 'form:mail',
								'width'	=> 7,
								'lbl_width'	=> 4,
								'required' => true,
							]) ?>
							<input type="hidden" name="agreed" value="1" />
							<input type="hidden" name="action" value="register" />
							<div class="register-buttons clearfix form-group">
								<span class="col-sm-4"></span>
								<button type="button" class="btn yswp-red btn-outline pull-right g-recaptcha" data-sitekey="<?= $app->captcha_public ?>" data-callback="cb_submit"><?= $lng->text('login:retail') ?> <i class="fa fa-arrow-circle-right"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>