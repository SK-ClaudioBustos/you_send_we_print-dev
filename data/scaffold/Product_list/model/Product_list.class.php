<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Product_list
 * GENERATION DATE:  2020-04-17
 * -------------------------------------------------------
 *
 */

class Product_list extends Base {

	// Protected Vars

	protected $dbClass = 'Product_listDb';

	protected $product_id = '';
	protected $product_key = '';
	protected $item_list_key = '';

	protected $product = '';


	// Getters

	public function get_string() { return $this->product_key; }

	public function get_product_id() { return $this->product_id; }
	public function get_product_key() { return $this->product_key; }
	public function get_item_list_key() { return $this->item_list_key; }

	public function get_product() { return $this->product; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_item_list_key($val) { $this->item_list_key = $val; }

	public function set_product($val) { $this->product = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_list_id);

			$this->set_product_id($row->product_id);
			$this->set_product_key($row->product_key);
			$this->set_item_list_key($row->item_list_key);

			$this->set_product($row->product);
		}
		return $this->row = $row;
	}

}
?>
