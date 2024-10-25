<div class="panel-group accordion proof-accordion" id="accordion_<?=$nro?>">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_<?=$nro?>" href="#collapse_<?=$nro?>"><i class="fa fa-plus-square"></i> <?=$lng->text('proof:upload')?></a>
			</h4>
		</div>
		<div id="collapse_<?=$nro?>" class="panel-collapse collapse">
			<div class="row">
				<form method="post" action="<?=$app->go($app->module_key, false, '/save')?>" enctype="multipart/form-data" class="form-horizontal saleproduct-form">
					<div class="panel-body">
						<?=$tpl->get_view('_input/file', array('field' => 'filename', 'label' => 'proof:filename', 'val' => $proof->get_filename(),
								'required' => true, 'error' => $proof->is_missing('filename'), 'lbl_width' => 3, 'width' => 7))?>
						<?=$tpl->get_view('_input/textarea', array('field' => 'description', 'label' => 'proof:description', 'val' => $proof->get_description(),
								'required' => true, 'error' => $proof->is_missing('description'), 'lbl_width' => 3, 'width' => 7))?>


						<div class="form-group">
							<label class="col-md-3 control-label"> </label>
							<div class="col-md-7">
								<button type="submit" class="btn blue"><?=$lng->text('form:save')?></button>
								<input type="hidden" name="action" value="proof" />
								<input type="hidden" name="image_id" value="<?=$image_id?>" />
								<input type="hidden" name="sale_id" value="<?=$object->get_sale_id()?>" />
								<input type="hidden" name="sale_product_id" value="<?=$object->get_id()?>" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
