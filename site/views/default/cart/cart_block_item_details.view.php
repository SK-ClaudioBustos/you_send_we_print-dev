<?php
$info = $object->get_detail();
$detail = $info['detail'];
$turnaround = explode('/', $object->get_turnaround_detail());
$hidden = ($object->get_date_due() == '0000-00-00 00:00:00') ? ' style="display: none;"' : '';
$sep = '<br />';
?>
<p>
	<?= '<b>' . $lng->text('product:size') . ':</b> '
		. (($object->get_measure_unit() == 'std') ? $lng->text('cart:standard') . ' '  : '')
		. ($shirts ? $object->get_comment() : $object->get_width() . '" x ' . $object->get_height()) . '"<br />' ?>
	<?php if (!$shirts) { ?>
		<?php if ($object->get_sides() == '2') { ?>
			<?= '<b>' . $lng->text('product:sides') . ':</b> ' . $lng->text('product:double') . $sep ?>
		<?php } else { ?>
			<?= '<b>' . $lng->text('product:sides') . ':</b> ' . $lng->text('product:single') . $sep ?>
		<?php } ?>
	<?php } ?>
</p>

<p>
	<?php
	//print_r($detail);
	//exit;
	// lists
	$materials = array('material', 'material-fineart', 'material-photoproducts');
	foreach ($materials as $material) {
		if (array_key_exists($material, $detail)) {
			echo '<b>' . $lng->text('product:material') . ':</b> ' . $detail[$material]['descr'] . $sep;
		}
	}
	foreach ($detail as $key => $info) {
		if (!in_array($key, array_merge($materials, array('measure_unit', 'size', 'cutting', 'modifiers', 'sides', 'reinf_packaging')))) {
			if (in_array($key, array('accesory1', 'accesory2'))) {
				echo '<b>' . $lng->text('product:accesories') . ':</b> ' . $detail[$key]['descr'] . $lng->text('product:acc_units', $info['quantity']) . $sep;
			} else {
				echo '<b>' . /*$lng->text('product:' . $key)*/ ucfirst($items_array_by_key[$key]) . ':</b> ' . $detail[$key]['descr'] . $sep;
			}
		}
	}
	?>

	<?php
	// cutting
	if (array_key_exists('cutting', $detail)) {
		if (in_array($detail['cutting']['val'], array('none', 'edge'))) {
			echo '<b>' . $lng->text('product:cutting') . ':</b> ' . $lng->text('product:cut_' . $detail['cutting']['val']) . $sep;
		} else {
			// custom cut
			echo '<b>' . $lng->text('product:cutting') . ':</b> ' . html_entity_decode($detail['cutting']['descr']) . $sep;
		}
	}
	?>

	<?= ($object->get_proof()) ? '<b>' . $lng->text('product:proof') . ':</b> Yes<br />' : '' ?>
</p>

<?php if (!$work_order) { ?>
	<p<?= ($turnaround[0] == 1) ? ' class="rush"' : '' ?>>
		<?= '<b>' . $lng->text('product:turnaround') . ':</b> ' . $turnaround[0] . ' ' . $lng->text('product:business_days') . $sep ?>
		<?= '<span class="date_due"' . $hidden . '><b>' . $lng->text('product:date_due_cart') . ':</b> <span>' . $utl->date_format($object->get_date_due()) . '</span>, 4:30-5:30 PM - '
			. '<a href="' . $cfg->url->data . '/guidelines/YSWP_ProductionTime.pdf' . '" target="_blank" class="due_details">' . $lng->text('product:details') . '</a></span>' ?>
		</p>
	<?php } ?>


	<?php
	if ($ws && $ws->get_id()) {
		if (!$work_order) {
			$sale_ship_address = $object->get_sale_address();
			$ship_info = ($sale_shipping->get_shipping_type())
				? $sale_ship_address->get_full_address(false, false)
				. (($sale_shipping->get_shipping_type())
					? ' / ' . $sale_shipping->get_shipping_type() . ': <b>$ ' . $object->get_shipping_cost() . '</b>'
					: '')
				: $lng->text('product:local_pickup');
	?>
			<p>
				<?= (isset($detail['reinf_packaging'])) ? '<b>' . $lng->text('product:reinf_packaging') . ':</b> ' . $detail['reinf_packaging']['descr'] . $sep : '' ?>
				<?= '<b>' . $lng->text('cart:ship_to') . ':</b> ' . $ship_info ?>
			</p>
		<?php
		} else {
		?>
			<p>
				<?= (isset($detail['reinf_packaging'])) ? '<b>' . $lng->text('product:reinf_packaging') . ':</b> ' . $detail['reinf_packaging']['descr'] . $sep : '' ?>
				<?= '<b>' . $lng->text('cart:ship_to') . ':</b> ' . (($sale_shipping->get_shipping_type()) ? $sale_shipping->get_shipping_type() : $lng->text('product:local_pickup')) ?>
			</p>
		<?php
		}
	}

	if ($work_order) {
		// internal comment
		if ($object->get_comment()) {
		?>
			<p><?= '<b>' . $lng->text('cart:comment') . ':</b> ' . $object->get_comment() ?></p>
	<?php
		}
	}
	?>