<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<ul class="spp_tabs">
		<li><a class="current" href="#">List</a></li>
		<?php
		if ($object->get_id()) {
			?>
			<li><a href="#">Items</a></li>
			<li><a href="#">Order</a></li>
			<?php
		}
		?>
		<li class="clear_float"></li>
	</ul>

	<form id="edit_form" name="edit_form" method="post" action="<?=$app->go($app->module_key, false, '/save')?>">
		<div class="spp_panes" style="min-height: 270px;">
			<div>
				<fieldset>
					<ol>
						<li>
							<label class="required<?=$object->is_missing('product_id')?>" for="product_id"><?=$lng->text('productlist:product')?></label>
							<select name="product_id" id="product_id">
								<option value=""></option>
								<?php
								while($products->list_paged(false)) {
									$selected = (($object->get_product_id() == $products->get_id()) ? ' selected="selected"' : '');
									echo '<option value="' . $products->get_id() . '"' . $selected . '>' . $products->get_title() . '</option>';
								}
///								?>
							</select>
						</li>
						<li class="medium">
							<label class="required<?=$object->is_missing('item_list_key')?>" for="item_list_key"><?=$lng->text('productlist:item_list')?></label>
							<select name="item_list_key" id="item_list_key">
								<option value=""></option>
								<?php
								while($item_lists->list_paged()) {
									$selected = (($item_lists->get_item_list_key() == $object->get_item_list_key()) ? ' selected="selected"' : '');
									echo '<option value="' . $item_lists->get_item_list_key() . '"' . $selected . '>' . $item_lists->get_title() . '</option>';
								}
								?>
							</select>
						</li>
					</ol>
				</fieldset>
			</div>

			<div>
				<fieldset>
					<div class="container">
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
				</fieldset>
			</div>

			<div>
				<fieldset>
					<div class="container" id="sort_container">
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
				</fieldset>
			</div>
		</div>
		<input type="hidden" name="order" id="order" value="<?=$order_list?>" />
		<input type="hidden" name="order_changed" id="order_changed" value="0" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />

		<input type="submit" id="submit" name="submit" class="submit_form" value="<?=$lng->text('form:save')?>" />
		<input type="button" id="cancel" name="cancel" class="cancel_form" value="<?=$lng->text('form:cancel')?>" />
	</form>
</div>

<script type="text/javascript">
	init_single();
</script>
