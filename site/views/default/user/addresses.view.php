<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$lng->text('account:addresses')?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
		<div class="col-xs-12 clearfix">
			<?=$tpl->get_view('user/account_tab', array('wholesaler' => $wholesaler))?>
		</div>

		<div class="col-xs-12 orders addresses">		
			<div class="background back_orders">
				<h2><?=$lng->text('account:addresses')?></h2>
				<div class="intro">
					<p>You can check and edit your shipping addresses list below. Besides you can eliminate an existing item, or add a new one to be used in your shopping process</p>
				</div>

				<div class="table-responsive">
					<table class="table cart_details">
						<tr>
							<th><?=$lng->text('addresses:contact')?></th>
							<th><?=$lng->text('addresses:address')?></th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<td class="new" colspan="4"><a href="<?=$edit_url?>"><?=$lng->text('addresses:new')?><i class="fa fa-asterisk"></i></a></td>
						</tr>
						<?php
						if (!$addresses->list_count()) {
							?>
							<tr>
								<td colspan="4"><?=$lng->text('addresses:empty')?></td>
							</tr>
							<?php
						} else {
							while($addresses->list_paged()) {
								?>
								<tr>
									<td><?=$addresses->get_ship_last_name()?></td>
									<td><?=$addresses->get_full_address(false, false)?></td>
									<td class="edit"><a title="<?=$lng->text('addresses:edit')?>" href="<?=$edit_url . $addresses->get_id()?>"><i class="fa fa-edit"></i></a></td>
									<td class="edit remove"><a title="<?=$lng->text('addresses:remove')?>" href="<?=$remove_url . $addresses->get_id()?>"><i class="fa fa-close"></i></a></td>
								</tr>
								<?php
							}
						}
						?>
					</table>
				</div>
			</div>

		</div>	
	</div>	
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var remove_msg = '<?=$lng->text('addresses:remove_msg')?>';

		$(function() {
			$('.remove a').click(function() {
				$parent = $(this).parents('tr');
				if (confirm(remove_msg)) {
					$.ajax({
						type: 'GET',
						url: $(this).attr('href') + '/1',
						success: function(data) {
							if (data) {
								$parent.fadeOut(600, function() { $parent.remove(); });

							} else {
							}
						}
					});
				}
				return false;
			});
		});
	</script>
</view>
