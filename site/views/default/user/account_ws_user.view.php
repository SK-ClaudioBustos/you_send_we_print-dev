<h4 id="ws_user_id"><?= $lng->text('wholesaler:user_id') ?></h4>

<?= $tpl->get_view('_input/text', array(
	'field' => 'username', 'label' => 'register:username', 'val' => $object->get_username(), 'required' => true,
	'width' => 'full', 'readonly' => false, 'class' => 'short'
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'user_password', 'label' => 'register:password', 'val' => $object->get_password(),
	'type' => 'password', 'required' => true, 'error' => $object->is_missing('password'),
	'width' => 'full', 'class' => 'short',
	'help_text' => $lng->text('register:password_tip', $app->user_password_len_min, $app->user_password_len_max)
)) ?>
<?=/*$tpl->get_view('_input/text', array('field' => 'email', 'label' => 'register:email', 'val' => $object->get_email(),
		'width' => 'full', 'readonly' => true))*/ '' ?>
<?=/*$tpl->get_view('_input/text', array('field' => 'first_name', 'label' => 'wholesaler:first_name', 'val' => $wholesaler->get_first_name(),
		'required' => true, 'error' => $wholesaler->is_missing('first_name'), 'attr' => 'maxlength="60"', 'width' => 'full'))*/ '' ?>
<?=/*$tpl->get_view('_input/text', array('field' => 'last_name', 'label' => 'wholesaler:last_name', 'val' => $wholesaler->get_last_name(),
		/*'required' => true, 'error' => $wholesaler->is_missing('last_name'), 'attr' => 'maxlength="60"', 'width' => 'full'))*/ '' ?>