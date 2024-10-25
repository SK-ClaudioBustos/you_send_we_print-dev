<div class="form-group">
	<label class="col-sm-3 control-label lbl_form" for="form" id="lbl_form">
		<?=$lng->text('product:order')?><span class="required no_visible">*</span>
	</label>

	<div class="col-sm-8">
		<div id="sort_container">
			<div class="check_list">
				<ol class="sortable" id="order_list">
					<?php
					//$order_list = '';
					if ($children) {
						while ($children->list_paged(false)) {
							$order_list .= $children->get_id() . '|';
							echo '<li id="item_' . $children->get_id() . '"' . ((!$children->get_active()) ? ' class="disabled"' : '') . '>' . $children->get_title() . '</li>';
						}
						//$order_list = ($order_list) ? substr($order_list, 0, -1) : '';
					}
					?>
				</ol>
			</div>
		</div>
	</div>
</div>



