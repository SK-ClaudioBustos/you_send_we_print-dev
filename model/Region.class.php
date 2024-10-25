<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Region
 * GENERATION DATE:  2018-01-20
 * -------------------------------------------------------
 *
 */

class Region extends Base {

	// Protected Vars

	protected $dbClass = 'RegionDb';

	protected $region = '';


	// Getters

	public function get_string() { return $this->region; }

	public function get_region() { return $this->region; }


	// Setters

	public function set_region($val) { $this->region = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->region_id);

			$this->set_region($row->region);
			$this->set_created($row->created);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
