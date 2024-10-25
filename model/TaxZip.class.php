<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        TaxZip
 * GENERATION DATE:  29.11.2015
 * -------------------------------------------------------
 *
 */

class TaxZip extends Base {

	// Protected Vars

	protected $dbClass = 'TaxZipDb';

	protected $zip = '';
	protected $city = '';
	protected $county_id = '';

	protected $tax = '';


	// Getters

	public function get_string() { return $this->zip; }

	public function get_zip() { return $this->zip; }
	public function get_city() { return $this->city; }
	public function get_county_id() { return $this->county_id; }

	public function get_tax() { return $this->tax; }


	// Setters

	public function set_zip($val) { $this->zip = $val; }
	public function set_city($val) { $this->city = $val; }
	public function set_county_id($val) { $this->county_id = $val; }

	public function set_tax($val) { $this->tax = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->zip_id);

			$this->set_zip($row->zip);
			$this->set_city($row->city);
			$this->set_county_id($row->county_id);

			$this->set_tax($row->tax);
		}
		return $this->row = $row;
	}

}
?>
