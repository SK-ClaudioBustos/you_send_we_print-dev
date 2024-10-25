<?php
$date_due = ($object->get_date_due() == '0000-00-00 00:00:00') ? '-' : $utl->date_format($object->get_date_due(), false, 'l, F jS');
$turnaround = explode('/', $object->get_turnaround_detail());
?>
<tr>
	<td class="job_id"><?=sprintf('%08d', $object->get_id())?></td>
	<td class="job_name">
		<h3><b><?=$object->get_job_name()?></b></h3>
		<em><?=$product->get_title()?></em>
	</td>
	<td class="right qty"><?=$object->get_quantity()?></td>
	<td class="right date_due"> <?=$date_due?></td>
</tr>

<tr>
	<td>
		<div class="qr_code" data-id="job_<?=$object->get_id()?>" data-href="<?=$cfg->setting->blixflow . '/sales/edit/' . $object->get_id()?>"></div>
	</td>
	<td class="details">
		<?=$tpl->get_view('cart/cart_block_item_details', array(
				'object' => $object,
				'items' => $items,
				'items_array_by_key' => $items_array_by_key,
				'ws' => $ws,
				'sale_ship_address' => $sale_ship_address,
				'sale_shipping' => $sale_shipping,
				'images' => $images,
				'work_order' => $work_order,
				'shirts' => $shirts,
			))?>
	<td colspan="2" class="right turnaround"><?='<b>' . $lng->text('product:turnaround') . '</b><br />'
			. (($turnaround[0] == 1) ? '<span class="next_day">' . $lng->text('product:next_day') . '</span>' : $turnaround[0] . ' ' . $lng->text('product:days') . '<br />')?></td>
	</td>
</tr>

<?=$tpl->get_view('cart/work_order_block_item_images', array(
	'object' => $object,
))?>

<tr class="buttons">
	<td colspan="5">
	</td>
</tr>
