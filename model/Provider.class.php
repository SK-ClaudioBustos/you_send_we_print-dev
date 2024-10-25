<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Provider
 * GENERATION DATE:  2019-09-25
 * -------------------------------------------------------
 *
 */

class Provider extends Base {

	// Protected Vars

	protected $dbClass = 'ProviderDb';

	protected $provider = '';
	protected $provider_address = '';
	protected $provider_city = '';
	protected $provider_state = '';
	protected $provider_zip = '';
	protected $provider_email = '';
	protected $provider_phone = '';
	protected $provider_url = '';


	// Getters

	public function get_string() { return $this->provider; }

	public function get_provider() { return $this->provider; }
	public function get_provider_address() { return $this->provider_address; }
	public function get_provider_city() { return $this->provider_city; }
	public function get_provider_state() { return $this->provider_state; }
	public function get_provider_zip() { return $this->provider_zip; }
	public function get_provider_email() { return $this->provider_email; }
	public function get_provider_phone() { return $this->provider_phone; }
	public function get_provider_url() { return $this->provider_url; }


	// Setters

	public function set_provider($val) { $this->provider = $val; }
	public function set_provider_address($val) { $this->provider_address = $val; }
	public function set_provider_city($val) { $this->provider_city = $val; }
	public function set_provider_state($val) { $this->provider_state = $val; }
	public function set_provider_zip($val) { $this->provider_zip = $val; }
	public function set_provider_email($val) { $this->provider_email = $val; }
	public function set_provider_phone($val) { $this->provider_phone = $val; }
	public function set_provider_url($val) { $this->provider_url = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->provider_id);

			$this->set_provider($row->provider);
			$this->set_provider_address($row->provider_address);
			$this->set_provider_city($row->provider_city);
			$this->set_provider_state($row->provider_state);
			$this->set_provider_zip($row->provider_zip);
			$this->set_provider_email($row->provider_email);
			$this->set_provider_phone($row->provider_phone);
			$this->set_provider_url($row->provider_url);
			$this->set_created($row->created);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
