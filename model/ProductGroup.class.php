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

	protected $product_key = '';
	protected $product = '';
	protected $featured = '';
	protected $group = '';


	// Getters

	public function get_string() { return $this->product_id; }

	public function get_product_id() { return $this->product_id; }
	public function get_group_id() { return $this->group_id; }

	public function get_product_key() { return $this->product_key; }
	public function get_product() { return $this->product; }
	public function get_featured() { return $this->featured; }
	public function get_group() { return $this->group; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_group_id($val) { $this->group_id = $val; }

	public function set_product_key($val) { $this->product_key = $val; }
	public function set_product($val) { $this->product = $val; }
	public function set_featured($val) { $this->featured = $val; }
	public function set_group($val) { $this->group = $val; }


	// Public Methods

	public function list_products($active_only = true, $hide_deleted = true) {
		return $this->db->list_products($this, $active_only, $hide_deleted);;
	}

	public function list_groups($active_only = true, $hide_deleted = true) {
		return $this->db->list_groups($this, $active_only, $hide_deleted);;
	}

	public function list_paged_product($active_only = true, $hide_deleted = true, $sql_parts = array(), $values = array()) {
		if ($this->row == null) {
			$this->rs = $this->db->list_paged_product($this, $active_only, $hide_deleted, $sql_parts, $values);
		}
		return $this->load();
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_group_id);

			$this->set_product_id($row->product_id);
			$this->set_group_id($row->group_id);

			$this->set_product_key($row->product_key);
			$this->set_product($row->product);
			$this->set_featured($row->featured);
			$this->set_group($row->group);
		}
		return $this->row = $row;
	}

}
?>
