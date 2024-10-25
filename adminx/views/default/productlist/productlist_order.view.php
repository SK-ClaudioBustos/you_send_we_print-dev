<div class="form-group">
	<label class="col-sm-3 control-label">
		<?=$lng->text('productlist:order')?><span class="required no_visible">*</span>
	</label>

	<div class="col-sm-8">
		<div id="sort_container">
			<div class="check_list">
				<ol class="sortable" id="order_list">
					<?php
					$order_list = '';
					foreach ($product_items as $key => $value) {
						$order_list .= $key . '|';
						echo '<li id="item_' . $key . '">' . $value . '</li>';
					}
					$order_list = ($order_list) ? substr($order_list, 0, -1) : '';
					?>
				</ol>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="order" id="order" value="<?=$order_list?>" />



