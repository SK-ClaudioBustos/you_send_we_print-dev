<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleShipping
 * GENERATION DATE:  05.03.2013
 * -------------------------------------------------------
 *
 */

class SaleShipping extends Base {

	// Protected Vars

	protected $dbClass = 'SaleShippingDb';

	protected $sale_id = '';
	protected $sale_product_id = '';
	protected $shipping_level = '';
	protected $shipping_zip = '';
	protected $shipping_weight = 0;
	protected $shipping_types = '';
	protected $shipping_type = '';
	protected $shipping_cost = 0;
	protected $shipping_change = false;


	// Getters

	public function get_sale_id() { return $this->sale_id; }
	public function get_sale_product_id() { return $this->sale_product_id; }
	public function get_shipping_level() { return $this->shipping_level; }
	public function get_shipping_zip() { return $this->shipping_zip; }
	public function get_shipping_weight() { return $this->shipping_weight; }
	public function get_shipping_types() { return $this->shipping_types; }
	public function get_shipping_type() { return $this->shipping_type; }
	public function get_shipping_cost() { return $this->shipping_cost; }
	public function get_shipping_change() { return $this->shipping_change; }


	// Setters

	public function set_sale_id($val) { $this->sale_id = $val; }
	public function set_sale_product_id($val) { $this->sale_product_id = $val; }
	public function set_shipping_level($val) { $this->shipping_level = $val; }
	public function set_shipping_zip($val) { $this->shipping_zip = $val; }
	public function set_shipping_weight($val) { $this->shipping_weight = $val; }
	public function set_shipping_types($val) { $this->shipping_types = $val; }
	public function set_shipping_type($val) { $this->shipping_type = $val; }
	public function set_shipping_cost($val) { $this->shipping_cost = $val; }
	public function set_shipping_change($val) { $this->shipping_change = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->sale_shipping_id);

			$this->set_sale_id($row->sale_id);
			$this->set_sale_product_id($row->sale_product_id);
			$this->set_shipping_level($row->shipping_level);
			$this->set_shipping_zip($row->shipping_zip);
			$this->set_shipping_weight($row->shipping_weight);
			$this->set_shipping_types($row->shipping_types);
			$this->set_shipping_type($row->shipping_type);
			$this->set_shipping_cost($row->shipping_cost);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
