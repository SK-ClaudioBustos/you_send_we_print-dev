<?php
$discounts = $info['discounts']['discounts'];
$info_title = $info['discounts']['title'];
$info_text = html_entity_decode($info['discounts']['info']);

$unit = ($info['discounts']['closed']) ? ' units' : ' sqft';
//print_r($info['discounts']);

$show_qty_disc = ($product->get_measure_type() != 'shirts') ? true : false;
//echo $info['discounts']['closed']." - Calcula Turnaround por:".$unit."<br>";
if ($show_qty_disc == false) {
	$info_title = $info['discounts_prints']['title'];
	$info_text = html_entity_decode($info['discounts_prints']['info']);
	$unit = ' Prints';
}
//echo "Array descuentos en este producto:";print_r($discounts);
$no_stock = sprintf($lng->text('product:not_available'), $product->get_stock(), '<a href="'. $app->go('Contact') . '">', '</a>');

if (is_array($discounts)) {
	$info_text .= '<ul>';
	foreach ($info['discounts']['discounts'] as $row) {
		$discount = explode('/', $row);
		list($min, $max, $perc) = $discount;
//echo $min."-"."$max"."-".$perc."<br>";
		if ($max != 'n') {
			$info_text .= '<li>' . $min . ' ' . $lng->text('product:to') . ' ' . $max . $unit . ' -' . $perc . '%</li>';
		} else {
			$info_text .= '<li>' . $lng->text('product:from') . ' ' . $min . $unit . ' -' . $perc . '%</li>';
		}
	}

	$info_text .= '</ul>';
}
?>
<div class="form-group">
    <label class="col-xs-12 col-sm-4"><?=$lng->text('product:quantity') . ' (' . $lng->text('product:units') . ')'?></label>
    <div class="col-xs-6 col-sm-4">
		<?php if (($parent && $parent->get_measure_type() == 'fixd-fixd') 
				|| $product->get_measure_type() == 'fixd-fixd') { ?> 
		<select name="quantity" id="quantity" class="form-control select2">
			<?php 
			foreach ($info['discounts']['discounts'] as $row) { 
				$discount = explode('/', $row);
				list($min, $max, $perc) = $discount;
				?>
				<option value="<?=$min?>"><?=$min?></option>
				<?php 
			} 
			?> 
		</select>
		<?php } else { ?> 
        <input type="text" name="quantity" id="quantity" maxlength="5" min="1" class="form-control right" title="<?=$lng->text('product:quantity')?>" autocomplete="off" value="<?=$object->get_quantity()?>" />
		<?php } ?> 
    </div>
	<label class="col-xs-6 col-sm-4 discounts right"><?= $show_qty_disc ?  $lng->text('product:qty_discounts') : $lng->text('product:qty_discounts_prints')?>&nbsp;&nbsp;<a href="#" class="info" data-target="quantity"><span class="badge badge-green">i</span></a></label>
	<span id="mult_quantity" class="col-sm-offset-4 col-sm-8 help"><?=$lng->text('product:mult_quantity')?></span>
    <span id="not_available" class="col-sm-offset-4 col-sm-8 help"><?=$no_stock?></span>
</div>

<div class="info info-quantity">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
    <input type="hidden" id='turnaround_calculate' value="<?= trim($unit);?>" />
</div>