<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleAddress
 * GENERATION DATE:  11.08.2012
 * -------------------------------------------------------
 *
 */

class SaleAddress extends Base {

	// Pseudo Enums

	private $address_type_enum = array ('bill' => 0, 'ship' => 1);
	private $address_level_enum = array ('sale' => 0, 'product' => 1);
	private $address_ws_enum = array ('none' => 0, 'default' => 1, 'other' => 2, 'new' => 3);
	private $same_address_enum = array ('local_pickup' => 0, 'same_address' => 1, 'other_address' => 2);


	// Protected Vars

	protected $dbClass = 'SaleAddressDb';

	protected $sale_id = '';
	protected $user_id = '';

	protected $address_type = 0;	// 0-bill, 1-ship
	protected $address_level = 0;	// 0-sale, 1-product
	protected $address_ws = 0;		// wholesaler 0-none, 1-default, 2-other, 3-new
	protected $other_address_id = 0;
	protected $same_address = 0;	// Ship address = Bill address

	protected $company = '';
	protected $first_name = '';
	protected $last_name = '';
	protected $address = '';
	protected $city = '';
	protected $state = '';
	protected $zip = '';
	protected $country = '';
	protected $phone = '';
	protected $fax = '';

	protected $email = '';
	protected $latitude = '';
	protected $longitude = '';


	// Getters

	public function get_sale_id() { return $this->sale_id; }
	public function get_user_id() { return $this->user_id; }

	public function get_address_type() { return $this->address_type; }
	public function get_address_level() { return $this->address_level; }
	public function get_address_ws() { return $this->address_ws; }
	public function get_other_address_id() { return $this->other_address_id; }
	public function get_same_address() { return $this->same_address; }

	public function get_company() { return $this->company; }
	public function get_first_name() { return $this->first_name; }
	public function get_last_name() { return $this->last_name; }
	public function get_address() { return $this->address; }
	public function get_city() { return $this->city; }
	public function get_state() { return $this->state; }
	public function get_zip() { return $this->zip; }
	public function get_country() { return $this->country; }
	public function get_phone() { return $this->phone; }
	public function get_fax() { return $this->fax; }

	public function get_email() { return $this->email; }
	public function get_latitude() { return $this->latitude; }
	public function get_longitude() { return $this->longitude; }


	// Setters

	public function set_sale_id($val) { $this->sale_id = $val; }
	public function set_user_id($val) { $this->user_id = $val; }

	public function set_address_type($val) { $this->address_type = $val; }
	public function set_address_level($val) { $this->address_level = $val; }
	public function set_address_ws($val) { $this->address_ws = $val; }
	public function set_other_address_id($val) { $this->other_address_id = $val; }
	public function set_same_address($val) { $this->same_address = $val; }

	public function set_company($val) { $this->company = $val; }
	public function set_first_name($val) { $this->first_name = $val; }
	public function set_last_name($val) { $this->last_name = $val; }
	public function set_address($val) { $this->address = $val; }
	public function set_city($val) { $this->city = $val; }
	public function set_state($val) { $this->state = $val; }
	public function set_zip($val) { $this->zip = $val; }
	public function set_country($val) { $this->country = $val; }
	public function set_phone($val) { $this->phone = $val; }
	public function set_fax($val) { $this->fax = $val; }

	public function set_email($val) { $this->email = $val; }
	public function set_latitude($val) { $this->latitude = $val; }
	public function set_longitude($val) { $this->longitude = $val; }


	// Public Methods

	// TODO: should be static
	public function address_type_enum($value) {
		return $this->address_type_enum[$value];
	}

	public function address_level_enum($value) {
		return $this->address_level_enum[$value];
	}

	public function address_ws_enum($value) {
		return $this->address_ws_enum[$value];
	}

	public function same_address_enum($value) {
		return $this->same_address_enum[$value];
	}



	public function calculate_hash() {
		return md5($this->address_type . $this->address_level . $this->address_ws . $this->company . $this->first_name . $this->last_name . $this->address . $this->city
				. $this->state . $this->zip . $this->country . $this->phone . $this->fax);
	}


	public function retrieve_by_sale($sale_id, $address_type = 0) {
		$this->rs = $this->db->retrieve_by_sale(array($sale_id, $address_type));
		$this->load();
	}

	public function copy_other_address($user_address) {
		$this->set_other_address_id($user_address->get_id());

		$this->set_last_name($user_address->get_ship_last_name());
		$this->set_address($user_address->get_ship_address());
		$this->set_city($user_address->get_ship_city());
		$this->set_state($user_address->get_ship_state());
		$this->set_zip($user_address->get_ship_zip());
		$this->set_country($user_address->get_ship_country());
		$this->set_phone($user_address->get_ship_phone());
	}

	public function copy_default_address($wholesaler) {
		$this->set_last_name($wholesaler->get_full_name());

		if ($wholesaler->get_ship_same()) {
			$this->set_address($wholesaler->get_bill_address());
			$this->set_city($wholesaler->get_bill_city());
			$this->set_state($wholesaler->get_bill_state());
			$this->set_zip($wholesaler->get_bill_zip());
			$this->set_phone($wholesaler->get_bill_phone());
		} else {
			$this->set_address($wholesaler->get_ship_address());
			$this->set_city($wholesaler->get_ship_city());
			$this->set_state($wholesaler->get_ship_state());
			$this->set_zip($wholesaler->get_ship_zip());
			$this->set_phone($wholesaler->get_ship_phone());
		}
	}

	public function get_full_address($formatted = false, $length = 60) {
		if ($formatted) {
			$address = $this->get_last_name() . '<br />'
					. $this->get_address() . '<br />'
					. $this->get_city() . ', ' . $this->get_state() . ' ' . $this->get_zip() . '<br />'
					. 'Ph ' . $this->get_phone();
			return $address;
		} else {
			$address = '[' . $this->get_last_name() . '] ' . $this->get_address() . ', ' . $this->get_city()
					. ', ' . $this->get_state() . ' ' . $this->get_zip() . ', Ph ' . $this->get_phone();

			if ($length) {
				return (strlen($address) > $length) ? substr($address, 0, 58) . '&hellip;' : $address;
			} else {
				return $address;
			}
		}
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->sale_address_id);

			$this->set_sale_id($row->sale_id);
			$this->set_user_id($row->user_id);

			$this->set_address_type($row->address_type);
			$this->set_address_level($row->address_level);
			$this->set_address_ws($row->address_ws);
			$this->set_other_address_id($row->other_address_id);
			$this->set_same_address($row->same_address);

			$this->set_company($row->company);
			$this->set_first_name($row->first_name);
			$this->set_last_name($row->last_name);
			$this->set_address($row->address);
			$this->set_city($row->city);
			$this->set_state($row->state);
			$this->set_zip($row->zip);
			$this->set_country($row->country);
			$this->set_phone($row->phone);
			$this->set_fax($row->fax);

			$this->set_email($row->email);
			$this->set_latitude($row->latitude);
			$this->set_longitude($row->longitude);

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
