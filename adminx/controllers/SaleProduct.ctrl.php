<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleProductCtrl
 * GENERATION DATE:  2018-12-05
 * -------------------------------------------------------
  *
 */

class SaleProductCtrl extends CustomCtrl {
	protected $mod = 'SaleProduct';
	protected $class = 'SaleProduct';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_sale_id(),
				$objects->get_id(),
				$objects->get_job_name(),
				$objects->get_product(),
				$objects->get_quantity(),
				$objects->get_total_sqft(),
				$objects->get_product_subtotal(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'job_name';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $sales = $products = $sale_addresss = array();

		/*
		$sales = new Sale();
		$sales->set_paging(1, 0, "`sale` ASC");

		$products = new Product();
		$products->set_paging(1, 0, "`product` ASC");

		$sale_addresss = new Sale_address();
		$sale_addresss->set_paging(1, 0, "`sale_address` ASC");

		*/

		$page_args = array(
				'sales' => $sales,
				'products' => $products,
				'sale_addresss' => $sale_addresss,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'sale_id' => $this->get_input('sale_id', 0),
					'job_name' => $this->get_input('job_name', '', true),
					'description' => $this->get_input('description', '', true),
					'comment' => $this->get_input('comment', '', true),
					'product_id' => $this->get_input('product_id', 0),
					'product_key' => $this->get_input('product_key', '', true),
					'product' => $this->get_input('product', '', true),
					'measure_unit' => $this->get_input('measure_unit', '', true),
					'width' => $this->get_input('width', 0),
					'height' => $this->get_input('height', 0),
					'partial_sqft' => $this->get_input('partial_sqft', 0),
					'partial_perim' => $this->get_input('partial_perim', 0),
					'quantity' => $this->get_input('quantity', 0),
					'total_sqft' => $this->get_input('total_sqft', 0),
					'total_perim' => $this->get_input('total_perim', 0),
					'sides' => $this->get_input('sides', 0),
					'size' => $this->get_input('size', '', true),
					'orientation' => $this->get_input('orientation', '', true),
					'detail' => $this->get_input('detail', '', true),
					'qty_discount_detail' => $this->get_input('qty_discount_detail', '', true),
					'quantity_discount' => $this->get_input('quantity_discount', 0),
					'product_subtotal' => $this->get_input('product_subtotal', 0),
					'subtotal_discount' => $this->get_input('subtotal_discount', 0),
					'subtotal_discount_real' => $this->get_input('subtotal_discount_real', 0),
					'price_sqft' => $this->get_input('price_sqft', 0),
					'price_piece' => $this->get_input('price_piece', 0),
					'turnaround_detail' => $this->get_input('turnaround_detail', '', true),
					'turnaround_cost' => $this->get_input('turnaround_cost', 0),
					'packaging' => $this->get_input('packaging', 0),
					'packaging_cost' => $this->get_input('packaging_cost', 0),
					'proof' => $this->get_input('proof', 0),
					'proof_cost' => $this->get_input('proof_cost', 0),
					'shipping_cost' => $this->get_input('shipping_cost', 0),
					'shipping_weight' => $this->get_input('shipping_weight', 0),
					'real_weight' => $this->get_input('real_weight', 0),
					'sale_address_id' => $this->get_input('sale_address_id', 0),
					'product_total' => $this->get_input('product_total', 0),
					'date_confirm' => $this->get_input('date_confirm', ''),
					'date_due' => $this->get_input('date_due', ''),
					'status' => $this->get_input('status', '', true),
					'reason' => $this->get_input('reason', '', true),
					'status_customer' => $this->get_input('status_customer', '', true),
					'status_history' => $this->get_input('status_history', '', true),
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
			$object->set_sale_id($data['sale_id']);
			$object->set_job_name($data['job_name']);
			$object->set_description($data['description']);
			$object->set_comment($data['comment']);
			$object->set_product_id($data['product_id']);
			$object->set_product_key($data['product_key']);
			$object->set_product($data['product']);
			$object->set_measure_unit($data['measure_unit']);
			$object->set_width($data['width']);
			$object->set_height($data['height']);
			$object->set_partial_sqft($data['partial_sqft']);
			$object->set_partial_perim($data['partial_perim']);
			$object->set_quantity($data['quantity']);
			$object->set_total_sqft($data['total_sqft']);
			$object->set_total_perim($data['total_perim']);
			$object->set_sides($data['sides']);
			$object->set_size($data['size']);
			$object->set_orientation($data['orientation']);
			$object->set_detail($data['detail']);
			$object->set_qty_discount_detail($data['qty_discount_detail']);
			$object->set_quantity_discount($data['quantity_discount']);
			$object->set_product_subtotal($data['product_subtotal']);
			$object->set_subtotal_discount($data['subtotal_discount']);
			$object->set_subtotal_discount_real($data['subtotal_discount_real']);
			$object->set_price_sqft($data['price_sqft']);
			$object->set_price_piece($data['price_piece']);
			$object->set_turnaround_detail($data['turnaround_detail']);
			$object->set_turnaround_cost($data['turnaround_cost']);
			$object->set_packaging($data['packaging']);
			$object->set_packaging_cost($data['packaging_cost']);
			$object->set_proof($data['proof']);
			$object->set_proof_cost($data['proof_cost']);
			$object->set_shipping_cost($data['shipping_cost']);
			$object->set_shipping_weight($data['shipping_weight']);
			$object->set_real_weight($data['real_weight']);
			$object->set_sale_address_id($data['sale_address_id']);
			$object->set_product_total($data['product_total']);
			$object->set_date_confirm($data['date_confirm']);
			$object->set_date_due($data['date_due']);
			$object->set_status($data['status']);
			$object->set_reason($data['reason']);
			$object->set_status_customer($data['status_customer']);
			$object->set_status_history($data['status_history']);
			$object->set_created($data['created']);
			$object->set_active($data['active']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`job_name` ASC", $filter);

		$header = array(
				$this->lng->text('saleproduct:sale_id'),
				$this->lng->text('saleproduct:job_name'),
				$this->lng->text('saleproduct:description'),
				$this->lng->text('saleproduct:comment'),
				$this->lng->text('saleproduct:product_id'),
				$this->lng->text('saleproduct:product_key'),
				$this->lng->text('saleproduct:product'),
				$this->lng->text('saleproduct:measure_unit'),
				$this->lng->text('saleproduct:width'),
				$this->lng->text('saleproduct:height'),
				$this->lng->text('saleproduct:partial_sqft'),
				$this->lng->text('saleproduct:partial_perim'),
				$this->lng->text('saleproduct:quantity'),
				$this->lng->text('saleproduct:total_sqft'),
				$this->lng->text('saleproduct:total_perim'),
				$this->lng->text('saleproduct:sides'),
				$this->lng->text('saleproduct:size'),
				$this->lng->text('saleproduct:orientation'),
				$this->lng->text('saleproduct:detail'),
				$this->lng->text('saleproduct:qty_discount_detail'),
				$this->lng->text('saleproduct:quantity_discount'),
				$this->lng->text('saleproduct:product_subtotal'),
				$this->lng->text('saleproduct:subtotal_discount'),
				$this->lng->text('saleproduct:subtotal_discount_real'),
				$this->lng->text('saleproduct:price_sqft'),
				$this->lng->text('saleproduct:price_piece'),
				$this->lng->text('saleproduct:turnaround_detail'),
				$this->lng->text('saleproduct:turnaround_cost'),
				$this->lng->text('saleproduct:packaging'),
				$this->lng->text('saleproduct:packaging_cost'),
				$this->lng->text('saleproduct:proof'),
				$this->lng->text('saleproduct:proof_cost'),
				$this->lng->text('saleproduct:shipping_cost'),
				$this->lng->text('saleproduct:shipping_weight'),
				$this->lng->text('saleproduct:real_weight'),
				$this->lng->text('saleproduct:sale_address_id'),
				$this->lng->text('saleproduct:product_total'),
				$this->lng->text('saleproduct:date_confirm'),
				$this->lng->text('saleproduct:date_due'),
				$this->lng->text('saleproduct:status'),
				$this->lng->text('saleproduct:reason'),
				$this->lng->text('saleproduct:status_customer'),
				$this->lng->text('saleproduct:status_history'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_sale(),
					$objects->get_job_name(),
					$objects->get_description(),
					$objects->get_comment(),
					$objects->get_product(),
					$objects->get_product_key(),
					$objects->get_product(),
					$objects->get_measure_unit(),
					$objects->get_width(),
					$objects->get_height(),
					$objects->get_partial_sqft(),
					$objects->get_partial_perim(),
					$objects->get_quantity(),
					$objects->get_total_sqft(),
					$objects->get_total_perim(),
					$objects->get_sides(),
					$objects->get_size(),
					$objects->get_orientation(),
					$objects->get_detail(),
					$objects->get_qty_discount_detail(),
					$objects->get_quantity_discount(),
					$objects->get_product_subtotal(),
					$objects->get_subtotal_discount(),
					$objects->get_subtotal_discount_real(),
					$objects->get_price_sqft(),
					$objects->get_price_piece(),
					$objects->get_turnaround_detail(),
					$objects->get_turnaround_cost(),
					$objects->get_packaging(),
					$objects->get_packaging_cost(),
					$objects->get_proof(),
					$objects->get_proof_cost(),
					$objects->get_shipping_cost(),
					$objects->get_shipping_weight(),
					$objects->get_real_weight(),
					$objects->get_sale_address(),
					$objects->get_product_total(),
					$objects->get_date_confirm(),
					$objects->get_date_due(),
					$objects->get_status(),
					$objects->get_reason(),
					$objects->get_status_customer(),
					$objects->get_status_history(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
