<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Item
 * GENERATION DATE:  2019-06-11
 * -------------------------------------------------------
 *
 */

class Item extends Base {

	// Protected Vars

	protected $dbClass = 'ItemDb';

	protected $item_code = '';
	protected $item_key = '';
	protected $item_list_key = '';
	protected $title = '';
	protected $description = '';
	protected $price = '';
	protected $order = '';
	protected $max_width = '';
	protected $max_length = '';
	protected $max_absolute = '';
	protected $calc_by = '';
	protected $weight = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_item_code() { return $this->item_code; }
	public function get_item_key() { return $this->item_key; }
	public function get_item_list_key() { return $this->item_list_key; }
	public function get_title() { return $this->title; }
	public function get_description() { return $this->description; }
	public function get_price() { return $this->price; }
	public function get_order() { return $this->order; }
	public function get_max_width() { return $this->max_width; }
	public function get_max_length() { return $this->max_length; }
	public function get_max_absolute() { return $this->max_absolute; }
	public function get_calc_by() { return $this->calc_by; }
	public function get_weight() { return $this->weight; }


	// Setters

	public function set_item_code($val) { $this->item_code = $val; }
	public function set_item_key($val) { $this->item_key = $val; }
	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_price($val) { $this->price = $val; }
	public function set_order($val) { $this->order = $val; }
	public function set_max_width($val) { $this->max_width = $val; }
	public function set_max_length($val) { $this->max_length = $val; }
	public function set_max_absolute($val) { $this->max_absolute = $val; }
	public function set_calc_by($val) { $this->calc_by = $val; }
	public function set_weight($val) { $this->weight = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_id);

			$this->set_item_code($row->item_code);
			$this->set_item_key($row->item_key);
			$this->set_item_list_key($row->item_list_key);
			$this->set_title($row->title);
			$this->set_description($row->description);
			$this->set_price($row->price);
			$this->set_order($row->order);
			$this->set_max_width($row->max_width);
			$this->set_max_length($row->max_length);
			$this->set_max_absolute($row->max_absolute);
			$this->set_calc_by($row->calc_by);
			$this->set_weight($row->weight);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
