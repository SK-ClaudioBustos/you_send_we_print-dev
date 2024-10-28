<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal point-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<?=$tpl->get_view('_input/text', array('field' => 'point', 'label' => 'point:point', 'val' => $object->get_point(),
									'required' => true, 'error' => $object->is_missing('point')))?>
							<?=$tpl->get_view('_input/select', array('field' => 'chain_id', 'label' => 'point:chain_id', 'val' => $object->get_chain_id(),
									'required' => true, 'error' => $object->is_missing('chain_id'),
									'options' => $chains, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/select', array('field' => 'manager_id', 'label' => 'point:manager_id', 'val' => $object->get_manager_id(),
									'required' => true, 'error' => $object->is_missing('manager_id'),
									'options' => $managers, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/select', array('field' => 'leader_id', 'label' => 'point:leader_id', 'val' => $object->get_leader_id(),
									'required' => true, 'error' => $object->is_missing('leader_id'),
									'options' => $leaders, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/select', array('field' => 'state_id', 'label' => 'point:state_id', 'val' => $object->get_state_id(),
									'required' => true, 'error' => $object->is_missing('state_id'),
									'options' => $states, 'none_val' => '', 'none_text' => ''))?>
							<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'point:active', 'val' => 1, 'checked' => $object->get_active()))?>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
									<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></a>
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
		init_single();
	</script>
</view>
