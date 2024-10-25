<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=htmlspecialchars($title)?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-md-12">

			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text('object:single_title')?></div>
				</div>
				<div class="portlet-body form">

					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1_1" data-toggle="tab"><?=$lng->text('sale:tab:main')?></a></li>
						<li><a href="#tab_1_2" data-toggle="tab"><?=$lng->text('sale:tab:status')?></a></li>
						<li><a href="#tab_1_3" data-toggle="tab"><?=$lng->text('sale:tab:details')?></a></li>
						<li><a href="#tab_1_4" data-toggle="tab"><?=$lng->text('sale:tab:images')?></a></li>
						<? if ($object->get_proof()) { ?>
						<li><a href="#tab_1_5" data-toggle="tab"><?=$lng->text('sale:tab:proofs')?></a></li>
						<? } else { ?>
						<li class="disabled"><a><?=$lng->text('sale:tab:proofs')?></a></li>
						<? } ?>
						<li><a href="#tab_1_6" data-toggle="tab"><?=$lng->text('sale:client')?></a></li>
						<li><a href="#tab_1_7" data-toggle="tab"><?=$lng->text('sale:tab:shipping')?></a></li>
						<? if ($user->perm('perm:sale_price')) { ?>
						<li><a href="#tab_1_8" data-toggle="tab"><?=$lng->text('sale:tab:economic')?></a></li>
						<li><a href="#tab_1_9" data-toggle="tab"><?=$lng->text('sale:tab:raw')?></a></li>
						<? } ?>
					</ul>

					<div class="form-body">
						<div class="tab-content">
							<div class="tab-pane active in" id="tab_1_1">
								<?=$this->get_view('sale/sale_main', array(
										'user' => $user,
										'object' => $object, 'sale' => $sale, 'wholesaler' => $wholesaler, 'bill_address' => $bill_address,
										'sale_url' => $sale_url, 'invoice_url' => $invoice_url, 'work_order_url' => $work_order_url,
										'date_sold' => $date_sold, 'date_confirm' => $date_confirm, 'date_due' => $date_due))?>
							</div>

							<div class="tab-pane" id="tab_1_2">
								<?=$this->get_view('sale/sale_status', array('object' => $object, 'sale' => $sale, 'items' => $items))?>
							</div>

							<div class="tab-pane" id="tab_1_3">
								<?=$this->get_view('sale/sale_details', array('object' => $object, 'sale' => $sale, 'items' => $items, 'sale_product_wp' => $sale_product_wp))?>
							</div>

							<div class="tab-pane" id="tab_1_4">
								<?=$this->get_view('sale/sale_images', array('object' => $object, 'sale' => $sale, 'images' => $images))?>
							</div>

							<div class="tab-pane" id="tab_1_5">
								<? if ($object->get_proof()) { ?>
								<?=$this->get_view('sale/sale_proofs', array('object' => $object, 'sale' => $sale, 'proofs' => $proofs, 'proof' => $proof, 'images' => $images))?>
								<? } ?>
							</div>

							<div class="tab-pane" id="tab_1_6">
								<?=$this->get_view('sale/sale_customer', array('object' => $object, 'sale' => $sale, 'wholesaler' => $wholesaler, 'bill_address' => $bill_address))?>
							</div>

							<div class="tab-pane" id="tab_1_7">
								<?=$this->get_view('sale/sale_shipping', array('object' => $object, 'sale' => $sale, 'wholesaler' => $wholesaler,
										'ship_address' => $ship_address, 'shipping' => $shipping, 'shipping_by' => $shipping_by))?>
							</div>

							<div class="tab-pane" id="tab_1_8">
								<?=$this->get_view('sale/sale_economic', array('object' => $object, 'sale' => $sale, 'wholesaler' => $wholesaler))?>
							</div>

							<div class="tab-pane" id="tab_1_9">
								<?=$this->get_view('sale/sale_raw', array('object' => $object, 'sale' => $sale, 'wholesaler' => $wholesaler))?>
							</div>

						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:back')?></button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

	</div>

</view>


<view key="page_scripts">
	<script type="text/javascript">
		var status = '<?=$object->get_status()?>';
		var st_history = <?=json_encode($object->get_status_history())?>;
		var url_action = '<?=$app->go($app->module_key, false, '/ajax_action/' . $object->get_id())?>';
		var url_date = '<?=$app->go($app->module_key, false, '/ajax_date/' . $object->get_id())?>';
		var url_comment = '<?=$app->go($app->module_key, false, '/ajax_comment/')?>';

		init_single();
	</script>
</view>
