<div class="form-group">
	<label class="col-sm-3 control-label">
		<?=$lng->text('productlist:items')?><span class="required no_visible">*</span>
	</label>

	<div class="col-sm-8">
		<div class="list_container">
			<div class="check_list">
				<ol>
					<?php
					while($items->list_paged()) {
						$checked = (array_key_exists((string)$items->get_id(), $product_items)) ? ' checked="checked"' : '';
						echo '<li><input type="checkbox" value="1" name="itm_' . $items->get_id() . '" id="itm_' . $items->get_id() . '"' . $checked . ' />';
						echo '<label for="itm_' . $items->get_id() . '">' . (($items->get_item_code()) ? '[' . $items->get_item_code() . '] ' : '') . $items->get_title() . '</label></li>';
					}
					?>
				</ol>
			</div>
		</div>
	</div>
</div>
