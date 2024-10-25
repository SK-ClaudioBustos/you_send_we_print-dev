<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">

		<form id="contact_form" name="contact_form" method="post" action="<?= $app->go('Contact') ?>/save" class="form contact-form">
			<div class="col-lg-6 clearfix">
				<div class="form-group">
					<label><?= $lng->text('contact:text') ?></label>
				</div>

				<?= $tpl->get_view('_input/text', array(
					'field' => 'first_name', 'label' => 'form:name', 'val' => $object->get_first_name(),
					'required' => true, 'error' => $object->is_missing('first_name'), 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/text', array(
					'field' => 'email', 'label' => 'form:email', 'val' => $object->get_email(),
					'required' => true, 'error' => $object->is_missing('email'), 'width' => 'full'
				)) ?>
				<?= $tpl->get_view('_input/textarea', array(
					'field' => 'message', 'label' => 'contact:message', 'val' => $object->get_message(),
					'required' => true, 'error' => $object->is_missing('message'), 'width' => 'full', 'attr' => 'style="height: 240px;"'
				)) ?>

				<div class="form-group">
					<input type="hidden" name="action" value="contact" />
					<button class="g-recaptcha btn yswp-red btn-outline pull-left" data-sitekey="6LeqmDsaAAAAAGHpHVQbSg2UckWh397sZX0r9_z-" data-callback='onSubmit' data-action='submit' type="submit" class="btn yswp-red btn-outline pull-right">
						<?= $lng->text('form:send') ?>
						<i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</div>

			<div class="col-lg-6 map">
				<div class="form-group">
					<label>1352 NW 78th Ave, Doral, FL 33126<br />Customer Service: <a href="tel:3052046455">(305) 204-6455</a>
					</label>
				</div>
				<div class="form-group">
					<a href="<?= $app->go($app->module_key, false, '/map') ?>">
						<img src="/data/contact/yousendweprint_address.jpg" alt="YouSendWePrint Address Map" class="img-responsive" width="100%" title="1352 NW 78th Ave, Doral, FL 33126" />
					</a>
					<a class="go_map pull-right" href="<?= $app->go($app->module_key, false, '/map') ?>"><?= $lng->text('contact:go_map') ?> <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</form>

	</div>
</view>


<view key="page_scripts">
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script>
		function onSubmit(token) {
			document.getElementById("contact_form").submit();
		}
	</script>
</view>