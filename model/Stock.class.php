<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Stock
 * GENERATION DATE:  01.02.2016
 * -------------------------------------------------------
 *
 */

class Stock extends Base {

	// Protected Vars

	protected $dbClass = 'StockDb';

	protected $product_id = '';
	protected $stock = 0;
	protected $last_update = '';

	protected $product = '';
	protected $stock_min = '';


	// Getters

	public function get_string() { return $this->product; }

	public function get_product_id() { return $this->product_id; }
	public function get_stock() { return $this->stock; }
	public function get_last_update() { return $this->last_update; }

	public function get_product() { return $this->product; }
	public function get_stock_min() { return $this->stock_min; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_stock($val) { $this->stock = $val; }
	public function set_last_update($val) { $this->last_update = $val; }

	public function set_product($val) { $this->product = $val; }
	public function set_stock_min($val) { $this->stock_min = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->stock_id);

			$this->set_product_id($row->product_id);
			$this->set_stock($row->stock);
			$this->set_last_update($row->last_update);

			$this->set_product($row->title);
			$this->set_stock_min($row->stock_min);
		}
		return $this->row = $row;
	}

}
?>
