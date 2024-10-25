<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" action="<?=$app->go($app->module_key, false, ($profile) ? '/prof_save' : '/save')?>" class="form form-horizontal user-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?=$tpl->get_view('_input/text', array('field' => 'role', 'label' => 'role:role', 'val' => $object->get_role(),
							'attr' => ' readonly="readonly"'))?>

					<?=$tpl->get_view('_input/text', array('field' => 'description', 'label' => 'role:description', 'val' => $object->get_description()))?>
					<?=$tpl->get_view('_input/textarea', array('field' => 'permissions', 'label' => 'role:permissions', 'val' => $object->get_permissions(),
							'required' => true, 'error' => $object->is_missing('permissions')))?>

					<?=$tpl->get_view('_input/check', array('field' => 'display', 'label' => 'role:display', 'val' => 1, 'checked' => $object->get_display()))?>
					<?=$tpl->get_view('_input/hidden', array('field' => 'active', 'val' => $object->get_active()))?>
				</div>

				<div class="form-actions">
					<?=$tpl->get_view('_input/submit')?>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
<script type="text/javascript">
init_single();
</script>
</view>

