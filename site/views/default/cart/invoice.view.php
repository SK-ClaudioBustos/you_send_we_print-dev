<?php
$list_count = $object->list_count();
$ws = $address_info['wholesaler'];
?>

<view key="page_metas">
	<link href="/site/views/default/cart/cart_print.css" rel="stylesheet" type="text/css" media="print" />
</view>


<view key="breadcrumb">
    { "<?=$lng->text('account:orders')?>": "<?=$app->go('User/account', false, '/orders')?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">

	<div class="row clearfix">
		<div class="col-xs-12">

			<div class="invoice_body clearfix">

				<div class="invoice_header clearfix">
					<div class="invoice_address">
						<h2><?=$cfg->setting->site?></h2>
						<?=$invoice_address?>
					</div>

					<div class="invoice_logo">
						<img alt="logo" src="/data/site/invoice-logo.png" />
					</div>
				</div>

				<div class="invoice clearfix">
					<div class="invoice_info">
						<div>
							<h1><?=$title?></h1>
						</div>
						<div>
							<h2><?=sprintf('%08d', $sale->get_id())?></h2>
						</div>
						<div>
							<h2><?=$date_sold?></h2>
						</div>
					</div>

					<div class="invoice_to">
						<h4><?=$lng->text('checkout:bill_to')?></h4>
						<div class="">
							<?=$tpl->get_view('cart/invoice_bill', array('sale' => $sale, 'object' => $object, 'address_info' => $address_info))?>
						</div>
					</div>
				</div>

				<div class="product_form cart_product final clearfix">
					<?=$tpl->get_view('cart/done_block', array(
							'sale' => $sale,
							'object' => $object,
							'product' => $product,
							'items' => $items,
							'address_info' => $address_info,
							'added_id' => $added_id,
							'list_count' => $list_count,
							'items_array_by_key' => $item_array_list,
							'from_account' => $from_account,
							'hide_buttons' => true,
						))?>

					<div class="clearfix">
						<?=$tpl->get_view('cart/checkout_total', array('sale' => $sale, 'submit' => false))?>
					</div>

					<div class="back_orders">
						<a class="back" href="<?=$app->go('User/account', false, '/orders')?>">&laquo; <?=$lng->text('done:back_orders')?></a>
					</div>
				</div>

			</div>
		</div>

	</div>
</view>
