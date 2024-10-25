<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        TaxCounty
 * GENERATION DATE:  29.11.2015
 * -------------------------------------------------------
 *
 */

class TaxCounty extends Base {

	// Protected Vars

	protected $dbClass = 'TaxCountyDb';

	protected $county = '';
	protected $tax = '';


	// Getters

	public function get_string() { return $this->county; }

	public function get_county() { return $this->county; }
	public function get_tax() { return $this->tax; }


	// Setters

	public function set_county($val) { $this->county = $val; }
	public function set_tax($val) { $this->tax = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->county_id);

			$this->set_county($row->county);
			$this->set_tax($row->tax);
		}
		return $this->row = $row;
	}

}
?>
