<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        UserAddress
 * GENERATION DATE:  30.07.2012
 * -------------------------------------------------------
 *
 */

class UserAddress extends Base {

	// Protected Vars

	protected $dbClass = 'UserAddressDb';

	protected $user_id = '';
	protected $ship_company = '';
	protected $ship_first_name = '';
	protected $ship_last_name = '';
	protected $ship_address = '';
	protected $ship_city = '';
	protected $ship_state = '';
	protected $ship_zip = '';
	protected $ship_country = '';
	protected $ship_phone = '';
	protected $ship_fax = '';
	protected $active = '';


	// Getters

	public function get_full_name() { return $this->first_name . ' ' . $this->last_name; }
	public function get_full_name_rev() {
		if ($this->last_name && $this->first_name) {
			return $this->last_name . ', ' . $this->first_name;
		} else {
			return $this->last_name . $this->first_name;
		}
	}

	public function get_user_id() { return $this->user_id; }
	public function get_ship_company() { return $this->ship_company; }
	public function get_ship_first_name() { return $this->ship_first_name; }
	public function get_ship_last_name() { return $this->ship_last_name; }
	public function get_ship_address() { return $this->ship_address; }
	public function get_ship_city() { return $this->ship_city; }
	public function get_ship_state() { return $this->ship_state; }
	public function get_ship_zip() { return $this->ship_zip; }
	public function get_ship_country() { return $this->ship_country; }
	public function get_ship_phone() { return $this->ship_phone; }
	public function get_ship_fax() { return $this->ship_fax; }
	public function get_active() { return $this->active; }


	// Setters

	public function set_user_id($val) { $this->user_id = $val; }
	public function set_ship_company($val) { $this->ship_company = $val; }
	public function set_ship_first_name($val) { $this->ship_first_name = $val; }
	public function set_ship_last_name($val) { $this->ship_last_name = $val; }
	public function set_ship_address($val) { $this->ship_address = $val; }
	public function set_ship_city($val) { $this->ship_city = $val; }
	public function set_ship_state($val) { $this->ship_state = $val; }
	public function set_ship_zip($val) { $this->ship_zip = $val; }
	public function set_ship_country($val) { $this->ship_country = $val; }
	public function set_ship_phone($val) { $this->ship_phone = $val; }
	public function set_ship_fax($val) { $this->ship_fax = $val; }
	public function set_active($val) { $this->active = $val; }


	// Public Methods

	public function get_full_address($formatted = false, $include_contact = true) {
		if ($formatted) {
			$address = $this->get_ship_last_name() . '<br />'
					. $this->get_ship_address() . '<br />'
					. $this->get_ship_city() . ', ' . $this->get_ship_state() . ' ' . $this->get_ship_zip() . '<br />'
					. 'Ph ' . $this->get_ship_phone();
			return $address;
		} else {
			$address = ($include_contact) ? '[' . $this->get_ship_last_name() . '] ' : '';
			$address .= $this->get_ship_address() . ', ' . $this->get_ship_city()
					. ', ' . $this->get_ship_state() . ' ' . $this->get_ship_zip() . ', Ph ' . $this->get_ship_phone();
			return (strlen($address) > 60) ? substr($address, 0, 58) . '&hellip;' : $address;
		}
	}

	public function copy_new_address($sale_address) {
		$this->set_ship_last_name($sale_address->get_last_name());
		$this->set_ship_address($sale_address->get_address());
		$this->set_ship_city($sale_address->get_city());
		$this->set_ship_state($sale_address->get_state());
		$this->set_ship_zip($sale_address->get_zip());
		$this->set_ship_country($sale_address->get_country());
		$this->set_ship_phone($sale_address->get_phone());
	}

	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->user_address_id);

			$this->set_user_id($row->user_id);
			$this->set_ship_company($row->ship_company);
			$this->set_ship_first_name($row->ship_first_name);
			$this->set_ship_last_name($row->ship_last_name);
			$this->set_ship_address($row->ship_address);
			$this->set_ship_city($row->ship_city);
			$this->set_ship_state($row->ship_state);
			$this->set_ship_zip($row->ship_zip);
			$this->set_ship_country($row->ship_country);
			$this->set_ship_phone($row->ship_phone);
			$this->set_ship_fax($row->ship_fax);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
