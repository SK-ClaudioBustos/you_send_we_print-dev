<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal property-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?=$tpl->get_view('_input/text', array('field' => 'property', 'label' => 'property:property', 'val' => $object->get_property(),
							'required' => true, 'error' => $object->is_missing('property')))?>

					<?=$tpl->get_view('_input/text', array('field' => 'property_key', 'label' => 'property:property_key', 'val' => $object->get_property_key(),
							'required' => true, 'error' => $object->is_missing('property_key'), 'width' => 3,
							'class' => ($superadmin) ? '' : 'hidden'))?>
					<?=$tpl->get_view('_input/select', array('field' => 'type', 'label' => 'property:type', 'val' => $object->get_type(),
							'required' => true, 'error' => $object->is_missing('type'), 'options' => $types, 'width' => 3,
							'readonly' => (!$superadmin)))?>


					<?=$tpl->get_view('_input/text', array('field' => 'value_str', 'label' => 'property:value',
							'val' => $object->get_value_str(),
							'required' => true, 'error' => $object->is_missing('value_str'),
							'class' => (in_array($object->get_type(), array('str'))) ? '' : 'hidden'))?>

					<?=$tpl->get_view('_input/textarea', array('field' => 'value_jsn', 'label' => 'property:value',
							'val' => $object->get_value_str(),
							'required' => true, 'error' => $object->is_missing('value_jsn'),
							'class' => (in_array($object->get_type(), array('jsn'))) ? '' : 'hidden'))?>

					<?=$tpl->get_view('_input/text', array('field' => 'value', 'label' => 'property:value',
							'val' => ($object->get_type() == 'int') ? (int)$object->get_value() : $object->get_value(),
							'required' => true, 'error' => $object->is_missing('value'), 'width' => 'small',
							'class' => (in_array($object->get_type(), array('int', 'dec'))) ? '' : 'hidden'))?>

					<?=$tpl->get_view('_input/check', array('field' => 'value_trf', 'label' => 'property:value', 'val' => 1, 'checked' => (int)$object->get_value(),
							'class' => ($object->get_type() == 'trf') ? '' : 'hidden'))?>


					<?=$tpl->get_view('_input/check', array('field' => 'hidden', 'label' => 'property:hidden', 'val' => 1, 'checked' => $object->get_hidden(),
							'class' => ($superadmin) ? '' : 'hidden'))?>
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
		var url_table = '<?=$app->go($app->module_key, false, '/ajax_table_info/')?>';
		init_single();
	</script>
</view>
