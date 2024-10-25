<fieldset>
	<div class="container" id="sort_container">
		<div class="check_list">
			<ol class="sortable" id="order_list">
				<?php
				foreach ($children as $key => $value) {
					$order_list .= $key . '|';
					echo '<li id="item_' . $key . '">' . $value . '</li>';
				}
				$order_list = ($order_list) ? substr($order_list, 0, -1) : '';
				?>
			</ol>
		</div>
	</div>
</fieldset>
