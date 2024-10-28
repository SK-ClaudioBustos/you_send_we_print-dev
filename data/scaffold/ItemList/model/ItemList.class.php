<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemList
 * GENERATION DATE:  2020-04-24
 * -------------------------------------------------------
 *
 */

class ItemList extends Base {

	// Protected Vars

	protected $dbClass = 'ItemListDb';

	protected $item_list_key = '';
	protected $title = '';
	protected $description = '';
	protected $calc_by = '';
	protected $standard = '';
	protected $has_cut = '';
	protected $has_max = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_item_list_key() { return $this->item_list_key; }
	public function get_title() { return $this->title; }
	public function get_description() { return $this->description; }
	public function get_calc_by() { return $this->calc_by; }
	public function get_standard() { return $this->standard; }
	public function get_has_cut() { return $this->has_cut; }
	public function get_has_max() { return $this->has_max; }


	// Setters

	public function set_item_list_key($val) { $this->item_list_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_calc_by($val) { $this->calc_by = $val; }
	public function set_standard($val) { $this->standard = $val; }
	public function set_has_cut($val) { $this->has_cut = $val; }
	public function set_has_max($val) { $this->has_max = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_list_id);

			$this->set_item_list_key($row->item_list_key);
			$this->set_title($row->title);
			$this->set_description($row->description);
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
