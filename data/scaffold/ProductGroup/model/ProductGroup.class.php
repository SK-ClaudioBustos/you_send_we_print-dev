<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductGroup
 * GENERATION DATE:  2020-01-29
 * -------------------------------------------------------
 *
 */

class ProductGroup extends Base {

	// Protected Vars

	protected $dbClass = 'ProductGroupDb';

	protected $product_id = '';
	protected $group_id = '';

	protected $product = '';
	protected $group = '';


	// Getters

	public function get_string() { return $this->product_id; }

	public function get_product_id() { return $this->product_id; }
	public function get_group_id() { return $this->group_id; }

	public function get_product() { return $this->product; }
	public function get_group() { return $this->group; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_group_id($val) { $this->group_id = $val; }

	public function set_product($val) { $this->product = $val; }
	public function set_group($val) { $this->group = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_group_id);

			$this->set_product_id($row->product_id);
			$this->set_group_id($row->group_id);

			$this->set_product($row->product);
			$this->set_group($row->group);
		}
		return $this->row = $row;
	}

}
?>
