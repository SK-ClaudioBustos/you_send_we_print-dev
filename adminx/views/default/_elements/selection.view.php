<form method="post" action="<?=$app->go($app->module_key, false, ($profile) ? '/prof_save' : '/save')?>" class="form-horizontal report-sel">
	<div class="row">

		<div class="col-md-6">

			<div class="form-body">
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-bars"></i><?=$lng->text('report:selection')?></div>
					</div>
					<div class="portlet-body form">
						<?=$tpl->get_view('_input/select', array('field' => 'type', 'width' => 8,'label' => 'report:type', 'val' => '', 'options' => $types))?>

						<div class="form-group">

							<label class="col-md-2 control-label" for="period_from" id="lbl_period_from"><?=$lng->text('report:period')?></label>

							<div class="col-md-4">
								<select id="period_from" name="period_from" class="form-control select2" tabindex="1">
									<?php foreach($periods as $option) { ?>
									<option value="<?=$option?>"<?=($option == $period) ? ' selected="selected"' : ''?>><?=$option?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4">
								<select id="period_from" name="period_from" class="form-control select2" tabindex="1">
									<?php foreach($periods as $option) { ?>
									<option value="<?=$option?>"<?=($option == $period) ? ' selected="selected"' : ''?>><?=$option?></option>
									<?php } ?>
								</select>
							</div>

						</div>

						<?=$tpl->get_view('_input/select', array('field' => 'division', 'width' => 8,'label' => 'report:division', 'val' => '', 'options' => $divisions))?>
						<?=$tpl->get_view('_input/select', array('field' => 'manager', 'width' => 8,'label' => 'report:manager', 'val' => ''))?>
						<?=$tpl->get_view('_input/select', array('field' => 'consultant', 'width' => 8,'label' => 'report:consultant', 'val' => ''))?>
						<?=$tpl->get_view('_input/select', array('field' => 'doctor', 'width' => 8,'label' => 'report:doctor', 'val' => ''))?>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn blue"><i class="fa fa-ok"></i> <?=$lng->text('form:apply')?></button>
								<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:reset')?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</form>
