<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Coupon
 * GENERATION DATE:  2021-09-10
 * -------------------------------------------------------
 *
 */

class Coupon extends Base {

	// Protected Vars

	protected $dbClass = 'CouponDb';

	protected $quantity = '';
	protected $code = '';
	protected $discount = '';
	protected $user_id = '';
	protected $valid_products = '';
	protected $expiration = '';
	protected $discount_limit = '';
	protected $use_per_user = '';

	protected $user = '';


	// Getters

	public function get_string() { return $this->code; }

	public function get_quantity() { return $this->quantity; }
	public function get_code() { return $this->code; }
	public function get_discount() { return $this->discount; }
	public function get_user_id() { return $this->user_id; }
	public function get_valid_products() { return $this->valid_products; }
	public function get_expiration() { return $this->expiration; }
	public function get_discount_limit() { return $this->discount_limit; }
	public function get_use_per_user() { return $this->use_per_user; }

	public function get_user() { return $this->user; }


	// Setters

	public function set_quantity($val) { $this->quantity = $val; }
	public function set_code($val) { $this->code = $val; }
	public function set_discount($val) { $this->discount = $val; }
	public function set_user_id($val) { $this->user_id = $val; }
	public function set_valid_products($val) { $this->valid_products = $val; }
	public function set_expiration($val) { $this->expiration = $val; }
	public function set_discount_limit($val) { $this->discount_limit = $val; }
	public function set_use_per_user($val) { $this->use_per_user = $val; }

	public function set_user($val) { $this->user = $val; }


	// Public Methods

	public function	check_running_promo($date) {
		return $this->db->check_running_promo($date);
	}

	public function check_used_coupons($user_id, $coupon_id) {
		return $this->db->check_used_coupons($user_id, $coupon_id);
	}

	public function check_user_firt_coupon($user_id)
	{
		return $this->db->check_user_firt_coupon($user_id);
	}

	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->coupon_id);

			$this->set_quantity($row->quantity);
			$this->set_code($row->code);
			$this->set_discount($row->discount);
			$this->set_user_id($row->user_id);
			$this->set_valid_products($row->valid_products);
			$this->set_expiration($row->expiration);
			$this->set_discount_limit($row->discount_limit);
			$this->set_use_per_user($row->use_per_user);
			$this->set_created($row->created);
			$this->set_active($row->active);

			$this->set_user($row->user);
		}
		return $this->row = $row;
	}

}
?>
