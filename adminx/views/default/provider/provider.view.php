<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal provider-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body">
					<?=$tpl->get_view('_input/text', array('field' => 'provider', 'label' => 'provider:provider', 'val' => $object->get_provider(),
							'required' => true, 'error' => $object->is_missing('provider')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_address', 'label' => 'provider:provider_address', 'val' => $object->get_provider_address(),
							'required' => true, 'error' => $object->is_missing('provider_address')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_city', 'label' => 'provider:provider_city', 'val' => $object->get_provider_city(),
							'required' => true, 'error' => $object->is_missing('provider_city')))?>
					<?=$tpl->get_view('_input/select', array('field' => 'provider_state', 'label' => 'provider:provider_state', 'val' => $object->get_provider_state(),
							'required' => true, 'error' => $object->is_missing('provider_state'), 'width' => 4, 
							'options' => $app->states, 'none_val' => '', 'none_text' => ''))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_zip', 'label' => 'provider:provider_zip', 'val' => $object->get_provider_zip(),
							'required' => true, 'error' => $object->is_missing('provider_zip'), 'width' => 'small'))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_phone', 'label' => 'provider:provider_phone', 'val' => $object->get_provider_phone(),
							'required' => true, 'error' => $object->is_missing('provider_phone'), 'width' => 'medium'))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_email', 'label' => 'provider:provider_email', 'val' => $object->get_provider_email(),
							'required' => false, 'error' => $object->is_missing('provider_email')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'provider_url', 'label' => 'provider:provider_url', 'val' => $object->get_provider_url(),
							'required' => false, 'error' => $object->is_missing('provider_url')))?>
					<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'provider:active', 'val' => 1, 'checked' => $object->get_active()))?>
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
