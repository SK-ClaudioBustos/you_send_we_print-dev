<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemList
 * GENERATION DATE:  19.06.2010
 * -------------------------------------------------------
 *
 */

class ItemList extends Base {

	// Pseudo Enums

	private static $calc_enum = array(
			'none',			// no cost
			'area',
			'perimeter',
			'variable',		// defined in each item
			//'special',	// it has a special calculation - not in use
		);


	// Protected Vars

	protected $dbClass = 'ItemListDb';

	protected $item_list_key = '';
	protected $title = '';
	protected $description = '';
	protected $quantity_label = '';
	protected $quantity_info = '';
	protected $calc_by = '';

	protected $standard = 0;
	protected $has_cut = 0;
	protected $has_max = 0;


	// Getters

	public function get_string() { return $this->title; }

	public function get_item_list_key() { return $this->item_list_key; }
	public function get_title() { return $this->title; }
	public function get_description() { return $this->description; }
	public function get_quantity_label() { return $this->quantity_label; }
	public function get_quantity_info() { return $this->quantity_info; }
	public function get_calc_by() { return $this->calc_by; }

	public function get_standard() { return $this->standard; }
	public function get_has_cut() { return $this->has_cut; }
	public function get_has_max() { return $this->has_max; }


	// Setters

	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_quantity_label($val) { $this->quantity_label = $val; }
	public function set_quantity_info($val) { $this->quantity_info = $val; }
	public function set_calc_by($val) { $this->calc_by = $val; }
	
	public function set_standard($val) { $this->standard = $val; }
	public function set_has_cut($val) { $this->has_cut = $val; }
	public function set_has_max($val) { $this->has_max = $val; }


	// Static Methods

	public static function calc_by_list() {
		return self::$calc_enum;
	}


	// Public Methods

	public function update($convert_arrays = true, $format_json = false) {
		if (!$this->get_id() || !$this->get_item_list_key()) {
			$this->set_item_list_key($this->get_new_key('item_list_key', $this->get_item_list_key(), $this->get_title()));
		}

		parent::update($convert_arrays, $format_json);
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_list_id);

			$this->set_item_list_key($row->item_list_key);
			$this->set_title($row->title);
			$this->set_description($row->description);
			$this->set_quantity_label($row->quantity_label);
			$this->set_quantity_info($row->quantity_info);
			$this->set_calc_by($row->calc_by);
			
			$this->set_standard($row->standard);
			$this->set_has_cut($row->has_cut);
			$this->set_has_max($row->has_max);
			
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
