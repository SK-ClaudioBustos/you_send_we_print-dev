<?php
$list_count = $object->list_count();
$ws = $address_info['wholesaler'];

$date_sold = $utl->date_format($sale->get_date_sold(), false, $app->date_format);

//$separate = false; // <<<<<<<<<<<<<<<<<< temp
?>

<view key="page_metas">
	<link href="/site/views/default/cart/cart_print.css" rel="stylesheet" type="text/css" media="print" />
</view>


<view key="body">
	<div class="print_type clearfix">
		<a href="#" class="print_page"><?=$lng->text('form:print')?></a>

		<?php if ($separate) { ?>
		<a href="<?=$app->go('Cart/work_order', false, '/' . $sale->get_hash())?>"><?=$lng->text('product:jobs_all')?></a> |
		<span><?=$lng->text('product:jobs_one')?></span>
		<?php } else { ?>
		<span><?=$lng->text('product:jobs_all')?></span> |
		<a href="<?=$app->go('Cart/work_order', false, '/' . $sale->get_hash()) . '/one'?>"><?=$lng->text('product:jobs_one')?></a>
		<?php } ?>
	</div>
	<?php
	if (!$separate) {
		echo $tpl->get_view('cart/work_order_header', array(
				'sale' => $sale,
				'object' => $object,
				'product' => $product,
				'items' => $items,
				'address_info' => $address_info,
				'title' => $title,
				'date_sold' => $date_sold,
				'first' => true,
			));
	}
	?>

	<div class="product_form cart_product final clearfix">
		<?=$tpl->get_view('cart/work_order_block', array(
				'sale' => $sale,
				'object' => $object,
				'product' => $product,
				'items' => $items,
				'items_array_by_key' => $item_array_list,
				'address_info' => $address_info,
				'added_id' => $added_id,
				'list_count' => $list_count,
				'from_account' => $from_account,
				'hide_buttons' => true,
				'work_order' => true,
				'title' => $title,
				'date_sold' => $date_sold,
				'separate' => $separate,
				'shirts' => $shirts,
			))?>
	</div>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		init_work_order();
	</script>
</view>
