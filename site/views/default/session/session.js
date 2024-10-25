function cb_submit() {
	grecaptcha.execute();
	$('.login-form').submit();
}

