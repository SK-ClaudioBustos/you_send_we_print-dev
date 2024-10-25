<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemCut
 * GENERATION DATE:  2019-02-12
 * -------------------------------------------------------
 *
 */

class ItemCut extends Base {

	// Protected Vars

	protected $dbClass = 'ItemCutDb';

	protected $item_id = '';
	protected $cut_id = '';

	protected $item_code = '';
	protected $item = '';
	protected $description = '';
	protected $cut = '';


	// Getters

	public function get_string() { return $this->item_cut_id; }

	public function get_item_id() { return $this->item_id; }
	public function get_cut_id() { return $this->cut_id; }

	public function get_item_code() { return $this->item_code; }
	public function get_item() { return $this->item; }
	public function get_description() { return $this->description; }
	public function get_cut() { return $this->cut; }


	// Setters

	public function set_item_id($val) { $this->item_id = $val; }
	public function set_cut_id($val) { $this->cut_id = $val; }

	public function set_item_code($val) { $this->item_code = $val; }
	public function set_item($val) { $this->item = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_cut($val) { $this->cut = $val; }


	// Public Methods

	public function list_count_info($only_actives = true, $hide_deleted = true) {
		$this->record_count = $this->db->list_count_info($this, $only_actives, $hide_deleted);
		return $this->record_count;
	}

	public function list_paged_info($only_actives = true, $hide_deleted = true) {
		if ($this->row == null) {
			$this->rs = $this->db->list_paged_info($this, $only_actives, $hide_deleted);
		}
		return $this->load();
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->item_cut_id);

			$this->set_item_id($row->item_id);
			$this->set_cut_id($row->cut_id);

			$this->set_item_code($row->item_code);
			$this->set_item($row->item);
			$this->set_description($row->description);
			$this->set_cut($row->cut);
		}
		return $this->row = $row;
	}

}
?>
