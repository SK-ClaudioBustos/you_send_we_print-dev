<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $lng->text('account:orders') ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-xs-12 clearfix">
			<?= $tpl->get_view('user/account_tab', array('wholesaler' => $wholesaler)) ?>
		</div>

		<div class="col-xs-12 orders">
			<div class="background back_orders">
				<h2><?= $lng->text('account:orders') ?></h2>
				<div class="intro">
					<p><?= $lng->text('orders:orders_1') ?></p>
					<p><?= $lng->text('orders:orders_2') ?></p>
				</div>

				<?php
				if (!$sales->list_count()) {
				?>
					<div class="table-responsive">
						<table class="table cart_details">
							<tr>
								<th class="p40"><?= $lng->text('orders:order_no') ?></th>
								<th class="p25"><?= $lng->text('orders:date') ?></th>
								<th class="right"><?= $lng->text('orders:items') ?></th>
								<th class="right"><?= $lng->text('orders:total') ?></th>
								<th class="right"></th>
							</tr>

							<tr>
								<td colspan="5"><?= $lng->text('orders:no_orders') ?></td>
							</tr>
						</table>
					</div>
					<?php } else {
					$count = 0;
					while ($sales->list_paged()) { ?>
						<div class="table-responsive <?= ($count > 0) ? "mt50" : "" ?>">
							<table class="table cart_details">
								<tr>
									<th class="p40"><?= $lng->text('orders:order_no') ?></th>
									<th class="p25"><?= $lng->text('orders:date') ?></th>
									<th class="right"><?= $lng->text('orders:items') ?></th>
									<th class="right"><?= $lng->text('orders:total') ?></th>
									<th class="right"></th>
								</tr>
								<tr>
									<td class="order"><a href="<?= $app->go('Cart/done', false, '/' . $sales->get_hash()) . '/1' ?>"><?= sprintf('#%08d', $sales->get_id()) ?></a></td>
									<td><?= $utl->date_format( $sales->get_created()) ?></td>
									<td class="right qty"><?= $sales->get_quantity() ?></td>
									<td class="right subtot">$ <?= $sales->get_total() ?></td>
									<td class="right invoice"><a href="<?= $app->go('Cart/invoice', false, '/' . $sales->get_hash()) ?>"><?= $lng->text('orders:invoice') ?></a></td>
								</tr>
								<?php
								$saleProducts->set_sale_id($sales->get_id());
								$saleProducts->set_paging();
								if ($saleProducts->list_count_s() >= 0) { ?>
									<tr>
										<td class="fbold"><?= $lng->text('orders:product') ?></td>
										<td class="fbold"><?= $lng->text('orders:status') ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php
									while ($saleProducts->list_paged_s()) { ?>
										<tr>
											<td><?= $saleProducts->get_product(); ?></td>
											<td><?= $lng->text($saleProducts->get_status()); ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
								<?php

									}
								}
								?>
							</table>
						</div>

				<?php $count++;
					}
				}
				?>
			</div>
		</div>
	</div>
</view>


<view key="page_scripts">
</view>