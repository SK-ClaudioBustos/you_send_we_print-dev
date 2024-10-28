<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductGroupCtrl
 * GENERATION DATE:  2020-01-29
 * -------------------------------------------------------
  *
 */

class ProductGroupCtrl extends CustomCtrl {
	protected $mod = 'ProductGroup';
	protected $class = 'ProductGroup';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_product_id(),
				$objects->get_group(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'product_id';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $products = $groups = array();

		/*
		$products = new Product();
		$products->set_paging(1, 0, "`product` ASC");

		$groups = new Group();
		$groups->set_paging(1, 0, "`group` ASC");

		*/

		$page_args = array(
				'products' => $products,
				'groups' => $groups,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'product_id' => $this->get_input('product_id', 0),
					'group_id' => $this->get_input('group_id', 0),
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
			$object->set_group_id($data['group_id']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = false) {
		$version = array_shift($args);

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`product_id` ASC", $filter);

		$header = array(
				$this->lng->text('productgroup:product_id'),
				$this->lng->text('productgroup:group_id'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_product(),
					$objects->get_group(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
