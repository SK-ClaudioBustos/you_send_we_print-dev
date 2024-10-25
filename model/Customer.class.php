<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Customer
 * GENERATION DATE:  04.10.2010
 * -------------------------------------------------------
 *
 */

class Customer extends Base {

	// Protected Vars

	protected $dbClass = 'CustomerDb';

	protected $user_id = '';
	protected $customer_type = '';
	protected $company = '';
	protected $first_name = '';
	protected $last_name = '';
	protected $website = '';
	protected $business_type = '';
	protected $trade_id = '';
	protected $how_hear = '';
	protected $bill_address = '';
	protected $bill_city = '';
	protected $bill_state = '';
	protected $bill_zip = '';
	protected $bill_country = '';
	protected $bill_phone = '';
	protected $bill_fax = '';
	protected $ship_same = '';
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
	protected $language = '';
	protected $status = '';
	protected $discount = '';
	protected $active = '';


	// Getters

	public function get_string() { return $this->company; }

	public function get_full_name() { return $this->first_name . ' ' . $this->last_name; }
	public function get_full_name_rev() {
		if ($this->last_name && $this->first_name) {
			return $this->last_name . ', ' . $this->first_name;
		} else {
			return $this->last_name . $this->first_name;
		}
	}

	public function get_user_id() { return $this->user_id; }
	public function get_customer_type() { return $this->customer_type; }
	public function get_company() { return $this->company; }
	public function get_first_name() { return $this->first_name; }
	public function get_last_name() { return $this->last_name; }
	public function get_website() { return $this->website; }
	public function get_business_type() { return $this->business_type; }
	public function get_trade_id() { return $this->trade_id; }
	public function get_how_hear() { return $this->how_hear; }
	public function get_bill_address() { return $this->bill_address; }
	public function get_bill_city() { return $this->bill_city; }
	public function get_bill_state() { return $this->bill_state; }
	public function get_bill_zip() { return $this->bill_zip; }
	public function get_bill_country() { return $this->bill_country; }
	public function get_bill_phone() { return $this->bill_phone; }
	public function get_bill_fax() { return $this->bill_fax; }
	public function get_ship_same() { return $this->ship_same; }
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
	public function get_language() { return $this->language; }
	public function get_status() { return $this->status; }
	public function get_discount() { return $this->discount; }
	public function get_active() { return $this->active; }


	// Setters

	public function set_user_id($val) { $this->user_id = $val; }
	public function set_customer_type($val) { $this->customer_type = $val; }
	public function set_company($val) { $this->company = $val; }
	public function set_first_name($val) { $this->first_name = $val; }
	public function set_last_name($val) { $this->last_name = $val; }
	public function set_website($val) { $this->website = $val; }
	public function set_business_type($val) { $this->business_type = $val; }
	public function set_trade_id($val) { $this->trade_id = $val; }
	public function set_how_hear($val) { $this->how_hear = $val; }
	public function set_bill_address($val) { $this->bill_address = $val; }
	public function set_bill_city($val) { $this->bill_city = $val; }
	public function set_bill_state($val) { $this->bill_state = $val; }
	public function set_bill_zip($val) { $this->bill_zip = $val; }
	public function set_bill_country($val) { $this->bill_country = $val; }
	public function set_bill_phone($val) { $this->bill_phone = $val; }
	public function set_bill_fax($val) { $this->bill_fax = $val; }
	public function set_ship_same($val) { $this->ship_same = $val; }
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
	public function set_language($val) { $this->language = $val; }
	public function set_status($val) { $this->status = $val; }
	public function set_discount($val) { $this->discount = $val; }
	public function set_active($val) { $this->active = $val; }


	// Public Methods

	public function retrieve_by_user($user_id) {
		$this->rs = $this->db->retrieve_by_user($user_id);
		$this->load();
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->customer_id);

			$this->set_user_id($row->user_id);
			$this->set_customer_type($row->customer_type);
			$this->set_company($row->company);
			$this->set_first_name($row->first_name);
			$this->set_last_name($row->last_name);
			$this->set_website($row->website);
			$this->set_business_type($row->business_type);
			$this->set_trade_id($row->trade_id);
			$this->set_how_hear($row->how_hear);
			$this->set_bill_address($row->bill_address);
			$this->set_bill_city($row->bill_city);
			$this->set_bill_state($row->bill_state);
			$this->set_bill_zip($row->bill_zip);
			$this->set_bill_country($row->bill_country);
			$this->set_bill_phone($row->bill_phone);
			$this->set_bill_fax($row->bill_fax);
			$this->set_ship_same($row->ship_same);
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
			$this->set_language($row->language);
			$this->set_status($row->status);
			$this->set_discount($row->discount);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
