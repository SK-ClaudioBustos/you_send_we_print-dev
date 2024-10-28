<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Item_list
 * GENERATION DATE:  2019-10-30
 * -------------------------------------------------------
 *
 */

class Item_list extends Base {

	// Protected Vars

	protected $dbClass = 'Item_listDb';

	protected $item_list_key = '';
	protected $title = '';
	protected $description = '';
	protected $calc_by = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_item_list_key() { return $this->item_list_key; }
	public function get_title() { return $this->title; }
	public function get_description() { return $this->description; }
	public function get_calc_by() { return $this->calc_by; }


	// Setters

	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_calc_by($val) { $this->calc_by = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_list_id);

			$this->set_item_list_key($row->item_list_key);
			$this->set_title($row->title);
			$this->set_description($row->description);
			$this->set_calc_by($row->calc_by);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
