<?php
class ProductListCtrl extends AdminCtrl {
	protected $mod = 'ProductList';


	protected function run_single($object, $args = false) {
		$products = new Product();
		$products->set_paging(1, 0, "`title` ASC", array(
				"`product_type` IN ('product-single', 'product-multiple')"
			));

		$item_lists = new ItemList();

		$items = new Item();
		$items->set_item_list_key($object->get_item_list_key());
		$items->set_paging(1, 0, '`item_code` ASC');

		$filter = array(
				"`product_id` = {$object->get_product_id()}",
				"`tbl_product_item`.`item_list_key` = '{$object->get_item_list_key()}'",
			);
		$product_item = new ProductItem();
		$product_item->set_paging(1, 0, '`order` ASC', $filter);

		$product_items = array();
		while($product_item->list_paged()) {
			$product_items[(string)$product_item->get_item_id()] = (($product_item->get_item_code()) ? '[' . $product_item->get_item_code() . '] ' : '') . $product_item->get_item();
		}

		$args = array(
				'products' => $products,
				'item_lists' => $item_lists,
				'items' => $items,
				'product_items' => $product_items
			);
		parent::run_single($object, $args);
	}


	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'product_id'	=> $this->get_input('product_id', '', true),
					'item_list_key'	=> $this->get_input('item_list_key', '', true),
					'id'			=> $this->get_input('id', 0),
				);

			$object = new $this->class($data['id']);

			if (!$data['id']) {
				// there is not edit
				$error_fields = $this->validate_data($data, array(
						'product_id' 		=> array('string', false, 1),
						'item_list_key' 	=> array('string', false, 1),
				));

				$error = $this->missing_fields($error_fields);

				// TODO: check in other way
//				if (substr_count($data['product_key'], '/') < 3) {
//					$error[] = 'ERR_INVALID_PRODUCT';
//					$error_fields[] = 'product_key';
//				}
				$object->set_missing_fields($error_fields);

//				$pos = strrpos($data['product_key'], '/') + 1;
//				$product_key = substr($data['product_key'], $pos);
//
//				$product = new Product();
//				$product->retrieve_by_key($product_key);

				$object->set_product_id($data['product_id']);
//				$object->set_product_key($product_key);
				$object->set_item_list_key($data['item_list_key']);

				try {
					$this->save($object, $error, false);
				} catch (PDOException $e) {
					if ($e->getCode() == 23000) { // Duplicate entry
						$tmp_var = 'tmp_' . strtolower($this->app->module_key);

						$_SESSION[$tmp_var] = serialize($object);

						$product = new Product($data['product_id']);
						$_SESSION['error_msg'] = sprintf($this->lng->text('ERR_DUPLICATE_ENTRY'), $product->get_string(), $data['item_list_key']);

						$go_error = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
						$go_error = $this->app->go($this->app->module_key, false, $go_error);
						header('Location: ' . $go_error);
						exit;
					}
				}

			} else {
				// save items
				$items = new Item();
				$items->set_item_list_key($object->get_item_list_key());
				$items->set_paging(1, 0);

				$filter = array(
						"`product_id` = {$object->get_product_id()}",
						"`tbl_product_item`.`item_list_key` = '{$object->get_item_list_key()}'",
					);
				$product_item = new ProductItem();
				$product_item->set_paging(1, 0, '`order` ASC', $filter);

				$product_items = array();
				while($product_item->list_paged()) {
					$product_items[(string)$product_item->get_item_id()] = $product_item->get_id();
				}
				$new_items = array();
				while($items->list_paged()) {
					$product_item = new ProductItem();
					if (array_key_exists('itm_' . $items->get_id(), $_POST)) {
						if (!array_key_exists((string)$items->get_id(), $product_items)) {
							$product_item->set_product_id($object->get_product_id());
//							$product_item->set_product_key($object->get_product_key()); // only for legibility
							$product_item->set_item_list_key($object->get_item_list_key());
							$product_item->set_item_id($items->get_id());
							$id = $product_item->update();
							$new_items[$object->get_product_id() . '/' . $items->get_id()] = $id;
						}

					} else {
						if (array_key_exists((string)$items->get_id(), $product_items)) {
							$product_item->delete($product_items[(string)$items->get_id()]);
						}
					}
				}
				// Sort Order
				if ($this->get_input('order_changed', 0)) {
					if ($order = $this->get_input('order', '', true)) {
						$item_list = explode('|', $order);
						$i = 1;
						foreach ($item_list as $item_id) {
							$product_item = new ProductItem();
							$product_item->update_order($object->get_item_list_key(), $object->get_product_id(), $item_id, $i);
							$i++;
						}
					}
				}

				header('Location: ' . $this->app->go($this->app->module_key));
				exit;

			}

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;

		}
	}

}
?>