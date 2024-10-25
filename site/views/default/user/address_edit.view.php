<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>", "<?=$subtitle?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
		<div class="col-xs-12 clearfix">
			<?=$tpl->get_view('user/account_tab', array('wholesaler' => $wholesaler))?>
		</div>

		<form id="address_form" method="post" class="form register-form" action="<?=$app->go($app->module_key, false, '/save/address')?>">
			<div class="col-sm-6 clearfix">
				<h2><?=$subtitle?></h2>

				<?=$tpl->get_view('_input/text', array('field' => 'ship_last_name', 'label' => 'wholesaler:contact_name', 'val' => $object->get_ship_last_name(),
						'required' => true, 'error' => $object->is_missing('last_name'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
				<?=$tpl->get_view('_input/text', array('field' => 'ship_address', 'label' => 'wholesaler:address', 'val' => $object->get_ship_address(),
						'required' => true, 'error' => $object->is_missing('ship_address'), 'attr' => 'maxlength="60"', 'width' => 'full'))?>
				<?=$tpl->get_view('_input/select', array('field' => 'ship_state', 'label' => 'wholesaler:state', 'val' => $object->get_ship_state(),
						'required' => true, 'error' => $object->is_missing('ship_state'), 'width' => 'full', 'class' => 'short', 
						'options' => $app->states, 'none_val' => '', 'none_text' => ''))?>
				<?=$tpl->get_view('_input/text', array('field' => 'ship_city', 'label' => 'wholesaler:city', 'val' => $object->get_ship_city(),
						'required' => true, 'error' => $object->is_missing('ship_city'), 'attr' => 'maxlength="120"', 'width' => 'full'))?>
				<?=$tpl->get_view('_input/text', array('field' => 'ship_zip', 'label' => 'wholesaler:zip', 'val' => $object->get_ship_zip(),
						'required' => true, 'error' => $object->is_missing('ship_zip'), 'attr' => 'maxlength="5"', 'width' => 'full', 'class' => 'short'))?>
				<?=$tpl->get_view('_input/text', array('field' => 'ship_phone', 'label' => 'wholesaler:phone', 'val' => $object->get_ship_phone(),
						'required' => true, 'error' => $object->is_missing('ship_phone'), 'attr' => 'maxlength="20"', 'width' => 'full', 'class' => 'short'))?>
			
				<div class="form-group">
					<button type="submit" class="btn yswp-red btn-outline pull-right">
						<?=$lng->text('form:save')?> <i class="fa fa-arrow-circle-right"></i>
					</button>
					<a href="" class="btn blue-madison btn-outline pull-right btn-cancel">
						<?=$lng->text('form:cancel')?>
					</a>
				</div>
			</div>

			<div class="col-sm-6 picture">
                <div class="form-group" style="min-height: 560px; background: url(/data/site/back_register.jpg) top right no-repeat;">
                </div>
			</div>

			<input type="hidden" name="id" value="<?=$object->get_id()?>">
			<input type="hidden" name="action" value="address" />
		</form>
	</div>
</view>


<view key="page_scripts">
	<script>init_address();</script>
</view>
