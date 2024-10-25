<?php
$images = new Image();
$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$object->get_id()}"));
$url_folder = '/image/sale/' . sprintf('%08s', $object->get_sale_id());

if ($count = $images->list_count()) { // || ($object->get_status() == 'st_confirmed')) { << ??
	?>
	<tr>
		<td></td>
		<td class="details images" colspan="3"><?='<b>' . $lng->text('cart:images') . ':</b> ' . $count?></p>
		</td>
	</tr>
	<?php
	for($i = 0; $images->list_paged(); $i++) {
		$url_img = $url_folder . '/210x210/' . (($img = $images->get_newname()) ? $img : 'default.jpg');
		?>
		<tr>
			<td></td>
			<td class="details images" colspan="3">
				<div class="image clearfix">
					<div class="frame">
						<img loading="lazy"  src="<?=$url_img?>" />
					</div>

					<div class="note">
						<p class="file"><?=$images->get_newname()?></p>
						<p class="units"><?=$images->get_quantity() . ' ' . $lng->text('product:unit_s')?></p>
						<p><i><?=$images->get_description()?></i></p>
					</div>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>
