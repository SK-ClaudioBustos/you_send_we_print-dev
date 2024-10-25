<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Item
 * GENERATION DATE:  19.06.2010
 * -------------------------------------------------------
 *
 */

class Item extends Base {

	// Pseudo Enums

	private static $calc_enum = array(
			'area',
			'perimeter',
			'top_bottom',
			'top',
			'bottom',
			'unit',
		);


	// Protected Vars

	protected $dbClass = 'ItemDb';

	protected $item_code = '';
	protected $item_key = '';
	protected $item_list_key = '';
	protected $title = '';
	protected $filter_word = '';
	
	protected $description = '';

	protected $price = 0.000;
	protected $order = 0;
	protected $calc_by = '';

	protected $max_width = 0;
	protected $max_length = 0;
	protected $max_absolute = 0;
	protected $weight = 0.00;

	protected $price_date = '0000-00-00';

	protected $item_list = '';
	protected $list_calc_by = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_item_code() { return $this->item_code; }
	public function get_item_key() { return $this->item_key; }
	public function get_item_list_key() { return $this->item_list_key; }
	public function get_title() { return $this->title; }
	public function get_filter_word() { return $this->filter_word; }
	public function get_description() { return $this->description; }

	public function get_price() { return $this->price; }
	public function get_order() { return $this->order; }

	public function get_max_width() { return $this->max_width; }
	public function get_max_length() { return $this->max_length; }
	public function get_max_absolute() { return $this->max_absolute; }

	public function get_calc_by() { return $this->calc_by; }
	public function get_weight() { return $this->weight; }

	public function get_price_date() { return $this->price_date; }

	public function get_item_list() { return $this->item_list; }
	public function get_list_calc_by() { return $this->list_calc_by; }

	// Setters

	public function set_item_code($val) { $this->item_code = $val; }
	public function set_item_key($val) { $this->item_key = $val; }
	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_filter_word($val) { $this->filter_word = $val; }
	public function set_description($val) { $this->description = $val; }

	public function set_price($val) { $this->price = $val; }
	public function set_order($val) { $this->order = $val; }

	public function set_max_width($val) { $this->max_width = $val; }
	public function set_max_length($val) { $this->max_length = $val; }
	public function set_max_absolute($val) { $this->max_absolute = $val; }

	public function set_calc_by($val) { $this->calc_by = $val; }
	public function set_weight($val) { $this->weight = $val; }

	public function set_price_date($val) { $this->price_date = $val; }

	public function set_item_list($val) { $this->item_list = $val; }
	public function set_list_calc_by($val) { $this->list_calc_by = $val; }


	// Static Methods

	public static function calc_by_list() {
		return self::$calc_enum;
	}


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_id);

			$this->set_item_code($row->item_code);
			$this->set_item_key($row->item_key);
			$this->set_item_list_key($row->item_list_key);
			$this->set_title($row->title);
			$this->set_filter_word($row->filter_word);
			
			$this->set_description($row->description);

			$this->set_price($row->price);
			$this->set_order($row->order);

			$this->set_max_width($row->max_width);
			$this->set_max_length($row->max_length);
			$this->set_max_absolute($row->max_absolute);

			$this->set_calc_by(($row->list_calc_by == 'variable') ? $row->calc_by : $row->list_calc_by);
			$this->set_weight($row->weight);

			$this->set_price_date($row->price_date);

			$this->set_active($row->active);

			$this->set_item_list($row->item_list);
			$this->set_list_calc_by($row->list_calc_by);
		}
		return $this->row = $row;
	}

}
?>
