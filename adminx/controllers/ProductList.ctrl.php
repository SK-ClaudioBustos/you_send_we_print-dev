<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductListCtrl
 * GENERATION DATE:  2020-04-17
 * -------------------------------------------------------
  *
 */

class ProductListCtrl extends CustomCtrl {
	protected $mod = 'ProductList';
	protected $class = 'ProductList';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_product(),
				$objects->get_item_list(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = array("`PD`.`title`", "`IL`.`title`");

		$filter = array();
		if ($product_id = $this->get_input('product_id', '')) {
			$filter[] = "`product_id` = '{$product_id}'";
			$_SESSION[$this->mod_key . ':product_id'] = $product_id;
		}
		$args['filter'] = $filter;

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_multiple($args = []) {
		$product_id = false;
		if (isset($_SESSION[$this->mod_key . ':product_id'])) {
			$product_id = $_SESSION[$this->mod_key . ':product_id'];
		}

		$products = new Product();
		$products->set_paging(1, 0, "`title` ASC", array("`product_type` IN ('product-single', 'product-multiple')"));

		$args = array(
				'products' => $products,
				'product_id' => $product_id,
			);
		parent::run_multiple($args);
	}

	protected function run_single($object, $args = array()) {
		$products = new Product();
		$products->set_paging(1, 0, "`title` ASC", array("`product_type` IN ('product-single', 'product-multiple')"));

		$item_lists = new ItemList();
		$item_lists->set_paging(1, 0, "`title` ASC");

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

		$page_args = array(
				'products' => $products,
				'item_lists' => $item_lists,
				'items' => $items,
				'product_items' => $product_items
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'product_id' => $this->get_input('product_id', 0),
					'item_list_key' => $this->get_input('item_list_key', '', true),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'product_id' => array('num', false, 1),
					'item_list_key' => array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_product_id($data['product_id']);
			$object->set_item_list_key($data['item_list_key']);

			if (!sizeof($error)) {
				// check duplicates
				$product_list = new $this->class();
				$product_list->retrieve_by(array('product_id', 'item_list_key'), array($data['product_id'], $data['item_list_key']));

				if ($product_list->get_id() && $product_list->get_id() != $data['id']) {
					// already exists
					$error[] = $this->lng->text('ERROR:PRODUCT_LIST_EXISTS');
				}
			}

			if ($this->save($object, $error, 'return')) {
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
				while($items->list_paged()) {
					$product_item = new ProductItem();
					if (array_key_exists('itm_' . $items->get_id(), $_POST)) {
						if (!array_key_exists((string)$items->get_id(), $product_items)) {
							$product_item->set_product_id($object->get_product_id());
							$product_item->set_item_list_key($object->get_item_list_key());
							$product_item->set_item_id($items->get_id());
							$product_item->update();
						}

					} else {
						if (array_key_exists((string)$items->get_id(), $product_items)) {
							$product_item->delete($product_items[(string)$items->get_id()]);
						}
					}
				}

				// sort order
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

			}

			$go = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
			$go = $this->app->go($this->app->module_key, false, $go);
			header('Location: ' . $go);
			exit;

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`product_key` ASC", $filter);

		$header = array(
				$this->lng->text('productlist:product_id'),
				$this->lng->text('productlist:item_list_key'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_product(),
					$objects->get_item_list(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
