<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductCtrl
 * GENERATION DATE:  2019-10-25
 * -------------------------------------------------------
  *
 */

class ProductCtrl extends CustomCtrl {
	protected $mod = 'Product';
	protected $class = 'Product';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_title(),
				$objects->get_product_key(),
				$objects->get_parent_key(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'title';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $parents = $disclaimers = $providers = array();

		/*
		$parents = new Parent();
		$parents->set_paging(1, 0, "`parent` ASC");

		$disclaimers = new Disclaimer();
		$disclaimers->set_paging(1, 0, "`disclaimer` ASC");

		$providers = new Provider();
		$providers->set_paging(1, 0, "`provider` ASC");

		*/

		$page_args = array(
				'parents' => $parents,
				'disclaimers' => $disclaimers,
				'providers' => $providers,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'product_code' => $this->get_input('product_code', '', true),
					'product_key' => $this->get_input('product_key', '', true),
					'parent_id' => $this->get_input('parent_id', 0),
					'parent_key' => $this->get_input('parent_key', '', true),
					'path' => $this->get_input('path', '', true),
					'title' => $this->get_input('title', '', true),
					'form' => $this->get_input('form', '', true),
					'short_description' => $this->get_input('short_description', '', true),
					'description' => $this->get_input('description', '', true),
					'details' => $this->get_input('details', '', true),
					'specs' => $this->get_input('specs', '', true),
					'meta_title' => $this->get_input('meta_title', '', true),
					'meta_description' => $this->get_input('meta_description', '', true),
					'meta_keywords' => $this->get_input('meta_keywords', '', true),
					'product_order' => $this->get_input('product_order', 0),
					'measure_type' => $this->get_input('measure_type', '', true),
					'standard_type' => $this->get_input('standard_type', '', true),
					'base_price' => $this->get_input('base_price', 0),
					'width' => $this->get_input('width', 0),
					'height' => $this->get_input('height', 0),
					'weight' => $this->get_input('weight', 0),
					'volume' => $this->get_input('volume', 0),
					'discounts' => $this->get_input('discounts', '', true),
					'turnarounds' => $this->get_input('turnarounds', '', true),
					'attachment' => $this->get_input('attachment', '', true),
					'minimum' => $this->get_input('minimum', 0),
					'price_from' => $this->get_input('price_from', 0),
					'use_stock' => $this->get_input('use_stock', 0),
					'stock_min' => $this->get_input('stock_min', 0),
					'disclaimer_id' => $this->get_input('disclaimer_id', 0),
					'provider_id' => $this->get_input('provider_id', 0),
					'provider_code' => $this->get_input('provider_code', '', true),
					'provider_name' => $this->get_input('provider_name', '', true),
					'provider_url' => $this->get_input('provider_url', '', true),
					'featured' => $this->get_input('featured', '', true),
					'created' => $this->get_input('created', ''),
					'active' => $this->get_input('active', 0),
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
			$object->set_product_code($data['product_code']);
			$object->set_product_key($data['product_key']);
			$object->set_parent_id($data['parent_id']);
			$object->set_parent_key($data['parent_key']);
			$object->set_path($data['path']);
			$object->set_title($data['title']);
			$object->set_form($data['form']);
			$object->set_short_description($data['short_description']);
			$object->set_description($data['description']);
			$object->set_details($data['details']);
			$object->set_specs($data['specs']);
			$object->set_meta_title($data['meta_title']);
			$object->set_meta_description($data['meta_description']);
			$object->set_meta_keywords($data['meta_keywords']);
			$object->set_product_order($data['product_order']);
			$object->set_measure_type($data['measure_type']);
			$object->set_standard_type($data['standard_type']);
			$object->set_base_price($data['base_price']);
			$object->set_width($data['width']);
			$object->set_height($data['height']);
			$object->set_weight($data['weight']);
			$object->set_volume($data['volume']);
			$object->set_discounts($data['discounts']);
			$object->set_turnarounds($data['turnarounds']);
			$object->set_attachment($data['attachment']);
			$object->set_minimum($data['minimum']);
			$object->set_price_from($data['price_from']);
			$object->set_use_stock($data['use_stock']);
			$object->set_stock_min($data['stock_min']);
			$object->set_disclaimer_id($data['disclaimer_id']);
			$object->set_provider_id($data['provider_id']);
			$object->set_provider_code($data['provider_code']);
			$object->set_provider_name($data['provider_name']);
			$object->set_provider_url($data['provider_url']);
			$object->set_featured($data['featured']);
			$object->set_created($data['created']);
			$object->set_active($data['active']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = false) {
		$version = array_shift($args);

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`title` ASC", $filter);

		$header = array(
				$this->lng->text('product:product_code'),
				$this->lng->text('product:product_key'),
				$this->lng->text('product:parent_id'),
				$this->lng->text('product:parent_key'),
				$this->lng->text('product:path'),
				$this->lng->text('product:title'),
				$this->lng->text('product:form'),
				$this->lng->text('product:short_description'),
				$this->lng->text('product:description'),
				$this->lng->text('product:details'),
				$this->lng->text('product:specs'),
				$this->lng->text('product:meta_title'),
				$this->lng->text('product:meta_description'),
				$this->lng->text('product:meta_keywords'),
				$this->lng->text('product:product_order'),
				$this->lng->text('product:measure_type'),
				$this->lng->text('product:standard_type'),
				$this->lng->text('product:base_price'),
				$this->lng->text('product:width'),
				$this->lng->text('product:height'),
				$this->lng->text('product:weight'),
				$this->lng->text('product:volume'),
				$this->lng->text('product:discounts'),
				$this->lng->text('product:turnarounds'),
				$this->lng->text('product:attachment'),
				$this->lng->text('product:minimum'),
				$this->lng->text('product:price_from'),
				$this->lng->text('product:use_stock'),
				$this->lng->text('product:stock_min'),
				$this->lng->text('product:disclaimer_id'),
				$this->lng->text('product:provider_id'),
				$this->lng->text('product:provider_code'),
				$this->lng->text('product:provider_name'),
				$this->lng->text('product:provider_url'),
				$this->lng->text('product:featured'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_product_code(),
					$objects->get_product_key(),
					$objects->get_parent(),
					$objects->get_parent_key(),
					$objects->get_path(),
					$objects->get_title(),
					$objects->get_form(),
					$objects->get_short_description(),
					$objects->get_description(),
					$objects->get_details(),
					$objects->get_specs(),
					$objects->get_meta_title(),
					$objects->get_meta_description(),
					$objects->get_meta_keywords(),
					$objects->get_product_order(),
					$objects->get_measure_type(),
					$objects->get_standard_type(),
					$objects->get_base_price(),
					$objects->get_width(),
					$objects->get_height(),
					$objects->get_weight(),
					$objects->get_volume(),
					$objects->get_discounts(),
					$objects->get_turnarounds(),
					$objects->get_attachment(),
					$objects->get_minimum(),
					$objects->get_price_from(),
					$objects->get_use_stock(),
					$objects->get_stock_min(),
					$objects->get_disclaimer(),
					$objects->get_provider(),
					$objects->get_provider_code(),
					$objects->get_provider_name(),
					$objects->get_provider_url(),
					$objects->get_featured(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
