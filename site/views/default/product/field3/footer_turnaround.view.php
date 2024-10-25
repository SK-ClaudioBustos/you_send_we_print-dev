<?php
$info_title = $info['turnaround']['title'];
$info_text = html_entity_decode($info['turnaround']['info']);

$turnaround = explode('/', $object->get_turnaround_detail());
?>

<div class="form-group">
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:turnaround')?>&nbsp;&nbsp;<a href="#" class="info" data-target="turnaround"><span class="badge badge-green">i</span></a></label>
    <div class="col-xs-6 col-sm-4">
		<?=$tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'turnaround',
				'options' => $shapes,
			))?>
    </div>
    <div class="col-xs-offset-6 col-xs-6 col-sm-offset-0 col-sm-4">
        <input type="text" name="turnaround_cost" id="turnaround_cost" class="form-control total_gray right" title="<?=$lng->text('product:turnaround_cost')?>" value="$ <?=number_format($object->get_turnaround_cost(), 2)?>" readonly="readonly" />
    </div>

	<?php if ($app->wholesaler_ok) { ?>
    <div class="col-xs-12">
		<span class="help right"><em><?=sprintf($lng->text('product:date_due'), '-',
			'<a href="' . $cfg->url->data . '/guidelines/YSWP_ProductionTime.pdf' . '" target="_blank" class="due_details">', '</a>')?></em></span>
    </div>
	<?php } ?>

    <div class="col-xs-12"><div class="sep-bottom"></div></div>

    <input type="hidden" name="turnaround_calc" id="turnaround_calc" value="<?=$turnaround[0]?>" />
    <input type="hidden" name="turnaround_days" id="turnaround_days" value="<?=$turnaround[0]?>" />

    <script type="text/javascript">
		var turnarounds = <?=json_encode($info['turnaround']['turnarounds'])?>;
		var turn_text = ' <?=$lng->text('product:business_days')?>';
    </script>
</div>

<div class="info info-turnaround">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>
