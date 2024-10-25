<?php
$discounts = $info['discounts']['discounts'];
$info_title = $info['discounts']['title'];
$info_text = html_entity_decode($info['discounts']['info']);

$unit = ($info['discounts']['closed']) ? ' units' : ' sqft';

$no_stock = sprintf($lng->text('product:not_available'), $product->get_stock(), '<a href="'. $app->go('Contact') . '">', '</a>');

if (is_array($discounts)) {
	$info_text .= '<ul>';
	foreach ($info['discounts']['discounts'] as $row) {
		$discount = explode('/', $row);
		list($min, $max, $perc) = $discount;

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
        <input type="text" name="quantity" id="quantity" maxlength="5" min="1" class="form-control right" title="<?=$lng->text('product:quantity')?>" autocomplete="off" value="<?=$object->get_quantity()?>" />
    </div>
	<label class="col-xs-6 col-sm-4 discounts right"><?=$lng->text('product:qty_discounts')?>&nbsp;&nbsp;<a href="#" class="info" data-target="quantity"><span class="badge badge-green">i</span></a></label>
	<span id="mult_quantity" class="col-sm-offset-4 col-sm-8 help"><?=$lng->text('product:mult_quantity')?></span>
    <span id="not_available" class="col-sm-offset-4 col-sm-8 help"><?=$no_stock?></span>
</div>

<div class="info info-quantity">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>