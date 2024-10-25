<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Cost
 * GENERATION DATE:  08.07.2010
 * -------------------------------------------------------
 *
 */

class Cost extends Base {

	// Protected Vars

	protected $dbClass = 'CostDb';

	protected $cost_key = '';
	protected $title = '';
	protected $value = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_cost_key() { return $this->cost_key; }
	public function get_title() { return $this->title; }
	public function get_value() { return $this->value; }


	// Setters

	public function set_cost_key($val) { $this->cost_key = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_value($val) { $this->value = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->cost_id);

			$this->set_cost_key($row->cost_key);
			$this->set_title($row->title);
			$this->set_value($row->value);
		}
		return $this->row = $row;
	}

}
?>
