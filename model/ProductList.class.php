<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductList
 * GENERATION DATE:  23.06.2010
 * -------------------------------------------------------
 *
 */

class ProductList extends Base {

	// Protected Vars

	protected $dbClass = 'ProductListDb';

	protected $product_id = 0;
	protected $item_list_key = '';

	protected $product = '';
	protected $item_list = '';


	// Getters

	public function get_string() { return $this->product . ' / ' . $this->item_list; }

	public function get_product_id() { return $this->product_id; }
	public function get_item_list_key() { return $this->item_list_key; }

	public function get_product() { return $this->product; }
	public function get_item_list() { return $this->item_list; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_item_list_key($val) { $this->item_list_key = $val; }

	public function set_product($val) { $this->product = $val; }
	public function set_item_list($val) { $this->item_list = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_list_id);

			$this->set_product_id($row->product_id);
			$this->set_item_list_key($row->item_list_key);

			$this->set_product($row->product);
			$this->set_item_list($row->item_list);
		}
		return $this->row = $row;
	}

}
?>
