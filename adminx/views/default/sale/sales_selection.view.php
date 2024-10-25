<form method="post" action="" class="form-horizontal grid-sel">
	<div class="row">

		<div class="col-md-6">

			<div class="portlet selection">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-bars"></i><?=$lng->text('form:selection')?></div>
					<div class="tools">
						<a class="expand" href="javascript:;"></a>
					</div>
				</div>
				<div class="portlet-body form" style="display: none;">
					<div class="form-body">
						<?=$tpl->get_view('_input/text', array('field' => 'sale_id', 'label' => 'sale:sale_nro', 'val' => '', 'width' => 4, 'lbl_width' => 3))?>
						<?=$tpl->get_view('_input/text', array('field' => 'sale_product_id', 'label' => 'sale:job_nro', 'val' => '', 'width' => 4, 'lbl_width' => 3))?>
						<?=$tpl->get_view('_input/text', array('field' => 'job_id', 'label' => 'sale:job_id', 'val' => '', 'width' => 4, 'lbl_width' => 3))?>
						<div class="form-group"></div>

						<?=$tpl->get_view('_input/text', array('field' => 'client', 'label' => 'sale:client', 'val' => ($user_id) ? $wholesaler->get_company() : '',
								'width' => 8, 'lbl_width' => 3))?>
						<div class="form-group"></div>

						<?=$tpl->get_view('_input/date_range', array('field' => 'date', 'label' => 'form:date', 'width' => 8, 'lbl_width' => 3,
								'val_from' => $date_from, 'val_to' => $date_to))?>

						<?=$tpl->get_view('_input/select', array('field' => 'source', 'width' => 8, 'lbl_width' => 3, 'label' => 'sale:source',
								'val' => 'yswp', 'options' => $sources)) ?>

						<?=$tpl->get_view('sale/select_status', array('field' => 'status', 'width' => 8, 'lbl_width' => 3, 'label' => 'sale:status',
								'val' => '', 'attr' => ' multiple="multiple"', 'options' => $status, 'select' => ($user_id) ? false : true))?>

						<div class="form-group"></div>

						<div class="form-group">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" id="btn_apply" class="btn blue"><i class="fa fa-check"></i> <?=$lng->text('form:apply')?></button>
								<button type="button" id="btn_cancel" class="btn default"><?=$lng->text('form:reset')?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</form>
