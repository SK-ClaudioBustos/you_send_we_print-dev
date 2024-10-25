<form class="register-form" action="<?=$app->go($app->module_key . '/signup')?>" method="post"<?=($signup) ? ' style="display: block;"' : ''?>>
	<h3><?=$lng->text('signup:title')?></h3>

	<?php if ($signup && $alert) { ?>
	<div class="alert alert-<?=$alert?> alert-fail">
		<button class="close" data-dismiss="alert"></button>
		<span><?=$msg?></span>
	</div>
	<?php } ?>

	<p><?=$lng->text('signup:text')?></p>

	<?=$tpl->get_view('_input/signup_text', array('field' => 'first_name', 'icon' => 'fa-font', 'label' => 'form:first_name', 'val' => $object->get_first_name(),
			'required' => true, 'error' => $object->is_missing('first_name'), 'attr' => ' maxlength="60"'))?>
	<?=$tpl->get_view('_input/signup_text', array('field' => 'last_name', 'icon' => 'fa-bold', 'label' => 'form:last_name', 'val' => $object->get_last_name(),
			'required' => true, 'error' => $object->is_missing('last_name'), 'attr' => ' maxlength="60"'))?>
	<?=$tpl->get_view('_input/signup_text', array('field' => 'email', 'icon' => 'fa-envelope', 'label' => 'form:email', 'val' => $object->get_email(),
			'required' => true, 'error' => $object->is_missing('email'), 'attr' => ' maxlength="100"'))?>
	<?=$tpl->get_view('_input/signup_text', array('field' => 'city', 'icon' => 'fa-location-arrow', 'label' => 'form:city', 'val' => '', //$object->get_city(),
			'required' => true, 'error' => $object->is_missing('city'), 'attr' => ' maxlength="80"'))?>

	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('form:country')?></label>
		<select name="country_id" id="select2_sample4" class="select2 form-control">
			<option value=""></option>
			<?php while ($countries->list_paged()) { ?>
			<option value="<?=$countries->get_country_key()?>"<?=($object->get_country_key() == $countries->get_id())?>><?=$countries->get_country()?></option>
			<?php } ?>
		</select>
	</div>

	<p><?=$lng->text('signup:details')?></p>

	<?=$tpl->get_view('_input/signup_text', array('field' => 'username', 'icon' => 'fa-user', 'label' => 'login:user', 'val' => $object->get_username(),
			'required' => true, 'error' => $object->is_missing('username'), 'attr' => ' maxlength="80" autocomplete="off"'))?>

	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:password')?></label>
		<div class="input-icon">
			<i class="fa fa-lock"></i>
			<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="<?=$lng->text('login:password')?>" name="password"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('signup:retype')?></label>
		<div class="controls">
			<div class="input-icon">
				<i class="fa fa-check"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?=$lng->text('signup:retype')?>" name="rpassword"/>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="agree">
		<input type="checkbox" name="tnc"/> <?=sprintf($lng->text('signup:agree'), '<a href="#">', '</a>', '<a href="#">', '</a>')?>
		</label>
		<div id="register_tnc_error"></div>
	</div>

	<div class="form-actions">
		<?=$tpl->get_view('_elements/token', array('token' => $token))?>
		<input type="hidden" name="action" value="signup" />
		<input type="hidden" name="time_offset" id="time_offset" value="" />
		<input type="hidden" name="dst" id="dst" value="" />

		<?php if (!$signup) { ?>
		<button id="register-back-btn" type="button" class="btn"><i class="m-icon-swapleft"></i> <?=$lng->text('form:back')?></button>
		<?php } ?>
		<button type="submit" id="register-submit-btn" class="btn blue pull-right"><?=$lng->text('form:signup')?> <i class="m-icon-swapright m-icon-white"></i></button>
	</div>
</form>
