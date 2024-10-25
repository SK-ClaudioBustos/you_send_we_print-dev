<div class="form-group">
	<label class="col-sm-3 control-label lbl_form" for="form" id="lbl_form">
		<?=$lng->text('item:cut_items')?><span class="required no_visible">*</span>
	</label>

	<div class="col-sm-8">
		<div class="list_container">
			<div class="check_list">
				<ol>
					<?php
					while($cut_items->list_paged()) {
						$checked = (array_key_exists((string)$cut_items->get_id(), $item_cuts)) ? ' checked="checked"' : '';
						echo '<li><input type="checkbox" value="1" name="itm_' . $cut_items->get_id() . '" id="itm_' . $cut_items->get_id() . '"' . $checked . ' />';
						echo '<label for="itm_' . $cut_items->get_id() . '">' . (($cut_items->get_item_code()) ? '[' . $cut_items->get_item_code() . '] ' : '') . $cut_items->get_title() . '</label></li>';
					}
					?>
				</ol>
			</div>
		</div>
	</div>
</div>
