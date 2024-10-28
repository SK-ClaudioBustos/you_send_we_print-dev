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

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_product_key(),
				$objects->get_product(),
				$objects->get_item_list_key(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'product_key';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $products = array();

		/*
		$products = new Product();
		$products->set_paging(1, 0, "`product` ASC");

		*/

		$page_args = array(
				'products' => $products,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'product_id' => $this->get_input('product_id', 0),
					'product_key' => $this->get_input('product_key', '', true),
					'item_list_key' => $this->get_input('item_list_key', '', true),
					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					//'some_string' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_product_id($data['product_id']);
			$object->set_product_key($data['product_key']);
			$object->set_item_list_key($data['item_list_key']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = false) {
		$version = array_shift($args);

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`product_key` ASC", $filter);

		$header = array(
				$this->lng->text('productlist:product_id'),
				$this->lng->text('productlist:product_key'),
				$this->lng->text('productlist:item_list_key'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_product(),
					$objects->get_product_key(),
					$objects->get_item_list_key(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
