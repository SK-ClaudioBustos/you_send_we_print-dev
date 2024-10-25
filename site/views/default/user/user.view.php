<view key="page_metas">
</view>


<view key="breadcrumb">
	<?php if ($profile) { ?>
	{ "<?=$title?>": "<?=$app->page_full?>" }
	<?php } else { ?>
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
	<?php } ?>
</view>


<view key="body">
<?php
$pw_help = ($object->get_id()) ? 'user:pw_help_option' : 'user:pw_help';
?>

	<form method="post" action="<?=$app->go($app->module_key, false, ($profile) ? '/prof_save' : '/save')?>" class="form form-horizontal user-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-user"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body form">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'username', 'label' => 'user:username', 'val' => $object->get_username(),
									'required' => true, 'error' => $object->is_missing('username'), 'width' => 3,
									'attr' => ' maxlength="20"' . (($profile) ? ' readonly="readonly"' : '')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'password', 'label' => 'user:password', 'val' => '',
									'required' => !$object->get_id(), 'error' => $object->is_missing('password'), 'width' => 3,
									'attr' => ' maxlength="' . $app->user_password_len_max . '"', 'help' => $pw_help))?>

							<?=$tpl->get_view('_input/text', array('field' => 'first_name', 'label' => 'form:first_name', 'val' => $object->get_first_name(),
									'required' => false, 'error' => $object->is_missing('first_name'), 'width' => 3))?>
							<?=$tpl->get_view('_input/text', array('field' => 'last_name', 'label' => 'form:last_name', 'val' => $object->get_last_name(),
									'required' => false, 'error' => $object->is_missing('last_name'), 'width' => 3))?>
							<div class="form-group"></div>

							<?=$tpl->get_view('_input/text', array('field' => 'email', 'label' => 'form:email', 'val' => $object->get_email(),
									'required' => true, 'error' => $object->is_missing('email'), 'attr' => ' maxlength="80"'))?>

							<?php if (!$profile) { ?>
							<?=$tpl->get_view('user/user_role', array('field' => 'role_id', 'label' => 'user:role', 'val' => $object->get_role_id(),
									'options' => $roles, 'none_val' => '', 'none_text' => '', 'required' => true, 'error' => $object->is_missing('role_id')))?>
							<?=$tpl->get_view('_input/check', array('field' => 'remote_access', 'label' => 'user:remote_access', 'val' => 1,
									'checked' => $object->get_remote_access()))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'form:active', 'val' => 1, 'checked' => $object->get_active()))?>

							<?php } else if ($logged_by_remember) { ?>
							<?=$tpl->get_view('_input/text', array('field' => 'cur_password', 'label' => 'user:cur_password', 'val' => '',
									'required' => true, 'error' => $object->is_missing('cur_password'),
									'attr' => ' maxlength="' . $app->user_password_len_max . '"', 'help' => 'user:cur_pw_help'))?>
							<?php } ?>
						</div>

						<div class="form-actions">
							<?=$tpl->get_view('_input/submit')?>
						</div>
					</div>
				</div>

			</div>

		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		init_single(<?=json_encode($require_client)?>);
	</script>
</view>



