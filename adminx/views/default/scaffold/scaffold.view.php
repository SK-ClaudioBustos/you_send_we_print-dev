<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" action="<?=$app->go($app->module_key, false, '/save')?>" class="form-horizontal scaffold-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body form">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'table_prefix', 'label' => 'scaffold:table_prefix', 'val' => $object->get_table_prefix()))?>
							<?=$tpl->get_view('_input/select', array('field' => 'table_name', 'label' => 'scaffold:table_name', 'val' => $object->get_table_name(),
									'options' => $tables, 'iterator' => 'list_tables', 'val_prop' => 'table_name', 'txt_prop' => 'table_name',
									'none_val' => '', 'none_text' => '', 'required' => true, 'error' => $object->is_missing('table_name')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'class_name', 'label' => 'scaffold:class_name', 'val' => $object->get_class_name(),
									'required' => true, 'error' => $object->is_missing('class_name')))?>
							<?=$tpl->get_view('_input/text', array('field' => 'controller', 'label' => 'scaffold:controller', 'val' => $object->get_controller(),
									'required' => false, 'error' => $object->is_missing('controller'), 'help' => 'scaffold:controller_help'))?>
							<?=$tpl->get_view('_input/text', array('field' => 'plural', 'label' => 'scaffold:plural', 'val' => $object->get_plural(),
									'help' => 'scaffold:plural_help'))?>

							<?=$tpl->get_view('_input/text', array('field' => 'primary', 'label' => 'scaffold:primary', 'val' => $object->get_primary(),
									'attr' => ' readonly="readonly"'))?>
							<?=$tpl->get_view('_input/select', array('field' => 'to_string', 'label' => 'scaffold:to_string', 'val' => $object->get_to_string(),
									'options' => $fields, 'required' => true, 'error' => $object->is_missing('to_string'), 'help' => 'scaffold:to_string_help'))?>

							<?=$tpl->get_view('_input/check', array('field' => 'grid_activation', 'label' => 'scaffold:grid_activation', 'val' => 1, 'checked' => $object->get_grid_activation()))?>

							<?=$tpl->get_view('scaffold/scaffold_select', array('field' => 'fields_grid[]', 'label' => 'scaffold:fields_grid', 'val' => $object->get_fields_grid(),
									'options' => $fields, 'required' => true, 'error' => $object->is_missing('fields_grid'), 'multiple' => true))?>
							<?=$tpl->get_view('scaffold/scaffold_select', array('field' => 'fields_form[]', 'label' => 'scaffold:fields_form', 'val' => $object->get_fields_form(),
									'options' => $fields, 'required' => true, 'error' => $object->is_missing('fields_form'), 'multiple' => true))?>

							<?=$tpl->get_view('scaffold/scaffold_select', array('field' => 'override[]', 'label' => 'scaffold:override', 'val' => $object->get_override(),
									'options' => $override, 'required' => true, 'error' => $object->is_missing('override'), 'multiple' => true))?>

							<?=$tpl->get_view('_input/check', array('field' => 'generate', 'label' => 'scaffold:generate', 'val' => 1, 'checked' => true))?>

							<?=$tpl->get_view('_input/check', array('field' => 'to_root', 'label' => 'scaffold:to_root', 'val' => 1, 'checked' => false, 'disabled' => true))?>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
									<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></button>
								</div>
							</div>
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
var url_table = '<?=$app->go($app->module_key, false, '/ajax_table_info/')?>';
init_single();
</script>
</view>



