<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CategoryCtrl
 * GENERATION DATE:  2018-06-17
 * -------------------------------------------------------
  *
 */

class CategoryCtrl extends CustomCtrl {
	protected $mod = 'Category';
	protected $class = 'Category';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_category(),
				$objects->get_category_key(),
				$objects->get_product(),
				$objects->get_parent(),
				$objects->get_category_order(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $mysql_parts = [], $return = false) {
		$args['searchfields'] = '`tbl_category`.`category`';
		$args['active_only'] = false;

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_download($args) {
		if ($id = $this->get_url_arg($args, 0)) {
			$object = new $this->class($id);
			$page_args = array(
					'file' => $object->get_filename(),
					'filename' => $object->get_original_name(),
					'folder' => 'category',
				);
			if ($object->get_id() && $page_args['file']) {
				parent::run_download($page_args);
			} else {
				// ?
			}
		}
	}

	protected function run_single($object, $args = array()) {
		$products = new Product();
		$products->set_paging(1, 0, "`product` ASC", array("`tbl_product`.`parent_id` = 0"));

		$parents = new Category();
		$parents->set_paging(1, 0, "`category` ASC", array("`tbl_category`.`parent_id` = 0"));

		$prod_parents = array();
		while($parents->list_paged()) {
			$prod_parents[(string)$parents->get_product_id()][$parents->get_id()] = $parents->get_category();
		}
//print_r($prod_parents);
//exit;

		$preview = false;
		if ($object->get_filename()) {
			$preview = '/image/category/0/' . $object->get_filename();
		}

		$page_args = array(
				'products' => $products,
				'prod_parents' => $prod_parents,
				'preview' => $preview,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'category' => $this->get_input('category', '', true),
					'product_id' => $this->get_input('product_id', 0),
					'parent_id' => $this->get_input('parent_id', 0),
					'category_order' => $this->get_input('category_order', 0),
					'active' => $this->get_input('active', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'category' => array('string', false, 1),
					'product_id' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_category($data['category']);
			$object->set_product_id($data['product_id']);
			$object->set_parent_id($data['parent_id']); // TODO: verify parent itself
			$object->set_category_order($data['category_order']);
			$object->set_active($data['active']);

			if ($this->save($object, $error, 'return')) {
				// save attach
				$folder = $this->cfg->path->data . '/category/';
				$filename = 'id_' . sprintf('%06d', $object->get_id());
				$result = $this->save_attach($folder, 'filename', $this->app->file_extensions, $filename, $original_name);
				if ($result === true) {
					$object->set_filename($filename);
					$object->set_original_name($original_name);
				} else {
					//error_log('invoice_attach: ' . $result);
				}
				$object->update();
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
		$objects->set_paging(1, 0, "`category` ASC", $filter);

		$header = array(
				$this->lng->text('category:category'),
				$this->lng->text('category:parent_id'),
				$this->lng->text('category:category_order'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_category(),
					$objects->get_parent(),
					$objects->get_category_order(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
