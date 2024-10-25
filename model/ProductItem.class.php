<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductItem
 * GENERATION DATE:  23.06.2010
 * -------------------------------------------------------
 *
 */

class ProductItem extends Base {

	// Protected Vars

	protected $dbClass = 'ProductItemDb';

	protected $product_id = 0;
	protected $product_key = '';
	protected $item_list_key = '';
	protected $item_id = 0;
	protected $order = '';
	protected $default = '';

	protected $item = '';
	protected $item_code = '';
	protected $description = '';

	protected $max_width;
	protected $max_length;
	protected $max_absolute = '';
	protected $calc_by = '';


	// Getters

	public function get_string() { return $this->item_key; }

	public function get_product_id() { return $this->product_id; }
	public function get_product_key() { return $this->product_key; }
	public function get_item_list_key() { return $this->item_list_key; }
	public function get_item_id() { return $this->item_id; }
	public function get_order() { return $this->order; }
	public function get_default() { return $this->default; }

	public function get_item() { return $this->item; }
	public function get_item_code() { return $this->item_code; }
	public function get_description() { return $this->description; }

	public function get_max_width() { return $this->max_width; }
	public function get_max_length() { return $this->max_length; }
	public function get_max_absolute() { return $this->max_absolute; }
	public function get_calc_by() { return $this->calc_by; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_item_id($val) { $this->item_id = $val; }
	public function set_order($val) { $this->order = $val; }
	public function set_default($val) { $this->default = $val; }

	public function set_item($val) { $this->item = $val; }
	public function set_item_code($val) { $this->item_code = $val; }
	public function set_description($val) { $this->description = $val; }

	public function set_max_width($val) { $this->max_width = $val; }
	public function set_max_length($val) { $this->max_length = $val; }
	public function set_max_absolute($val) { $this->max_absolute = $val; }
	public function set_calc_by($val) { $this->calc_by = $val; }


	// Public Methods

	public function update_order($item_list_key, $product_id, $item_id, $order) {
		return $this->db->update_order($item_list_key, $product_id, $item_id, $order);
	}

	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_item_id);

			$this->set_product_id($row->product_id);
			$this->set_product_key($row->product_key);
			$this->set_item_list_key($row->item_list_key);
			$this->set_item_id($row->item_id);
			$this->set_order($row->order);
			$this->set_default($row->default);

			$this->set_item($row->item);
			$this->set_item_code($row->item_code);
			$this->set_description($row->description);

			$this->set_max_width($row->max_width);
			$this->set_max_length($row->max_length);
			$this->set_max_absolute($row->max_absolute);
			$this->set_calc_by($row->calc_by);
		}
		return $this->row = $row;
	}

}
?>
