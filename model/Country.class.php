<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Country
 * GENERATION DATE:  15.12.2013
 * -------------------------------------------------------
 *
 */

class Country extends Base {

	// Protected Vars

	protected $dbClass = 'CountryDb';

	protected $country = '';
	protected $id_region = '';
	protected $iso = '';
	protected $currency = '';
	protected $curr_description = '';
	protected $curr_symbol = '';
	protected $active = '';

	protected $records_page = 0;
	protected $sort_field = 'country';
	protected $sort_order = 'ASC';
	
	
	// Getters

	public function get_string() { return $this->country; }
	public function get_country() { return $this->country; }
	public function get_id_region() { return $this->id_region; }
	public function get_iso() { return $this->iso; }
	public function get_currency() { return $this->currency; }
	public function get_curr_description() { return $this->curr_description; }
	public function get_curr_symbol() { return $this->curr_symbol; }


	// Setters

	public function set_country($val) { $this->country = $val; }
	public function set_id_region($val) { $this->id_region = $val; }
	public function set_iso($val) { $this->iso = $val; }
	public function set_currency($val) { $this->currency = $val; }
	public function set_curr_description($val) { $this->curr_description = $val; }
	public function set_curr_symbol($val) { $this->curr_symbol = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->id_country);

			$this->set_country($row->country);
			$this->set_id_region($row->id_region);
			$this->set_iso($row->iso);
			$this->set_currency($row->currency);
			$this->set_curr_description($row->curr_description);
			$this->set_curr_symbol($row->curr_symbol);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
