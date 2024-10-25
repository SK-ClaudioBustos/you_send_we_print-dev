<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Sale
 * GENERATION DATE:  24.06.2010
 * -------------------------------------------------------
 *
 */

class Sale extends Base {

	// Pseudo Enums

	private $payment_type_enum = array ('ccard' => 0, 'paypal' => 1);

	// Protected Vars

	protected $dbClass = 'SaleDb';

	protected $hash = '';
	protected $source = '';
	protected $user_id = '';
	protected $wholesaler_id = '';

	protected $total_weight = 0;
	protected $quantity = '';
	protected $subtotal = 0;
	protected $shipping = 0;
	protected $taxes = 0;
	protected $total = 0;

	protected $date_sold = '';
	protected $status = 'st_saved';

	protected $payment_type = 0;
	protected $name_card = '';
	protected $credit_card = '';

	protected $coupon = '';
	protected $coupon_discount = 0;

	// only for carrying
	protected $card_number = '';
	protected $exp_month = '';
	protected $exp_year = '';
	protected $sec_code = '';

	protected $bill_address = false;
	protected $ship_address = false;
	protected $ship_info = false;


	// Getters

	public function get_string() { return $this->sale_id; }

	public function get_hash() { return $this->hash; }
	public function get_source() { return $this->source; }
	public function get_user_id() { return $this->user_id; }
	public function get_wholesaler_id() { return $this->wholesaler_id; }

	public function get_total_weight() { return $this->total_weight; }
	public function get_quantity() { return $this->quantity; }
	public function get_subtotal() { return $this->subtotal; }
	public function get_shipping() { return $this->shipping; }
	public function get_taxes() { return $this->taxes; }
	public function get_total() { return $this->total; }
	public function get_date_sold() { return $this->date_sold; }

	public function get_status() { return $this->status; }
	public function get_payment_type() { return $this->payment_type; }
	public function get_name_card() { return $this->name_card; }
	public function get_credit_card() { return $this->credit_card; }

	public function get_coupon() { return $this->coupon; }
	public function get_coupon_discount() { return $this->coupon_discount; }

	public function get_card_number() { return $this->card_number; }
	public function get_exp_month() { return $this->exp_month; }
	public function get_exp_year() { return $this->exp_year; }
	public function get_sec_code() { return $this->sec_code; }

	public function get_bill_address() { return $this->bill_address; }
	public function get_ship_address() { return $this->ship_address; }
	public function get_ship_info() { return $this->ship_info; }


	// Setters

	public function set_hash($val) { $this->hash = $val; }
	public function set_source($val) { $this->source = $val; }
	public function set_user_id($val) { $this->user_id = $val; }
	public function set_wholesaler_id($val) { $this->wholesaler_id = $val; }

	public function set_total_weight($val) { $this->total_weight = $val; }
	public function set_quantity($val) { $this->quantity = $val; }
	public function set_subtotal($val) { $this->subtotal = $val; }
	public function set_shipping($val) { $this->shipping = $val; }
	public function set_taxes($val) { $this->taxes = $val; }
	public function set_total($val) { $this->total = $val; }
	public function set_date_sold($val) { $this->date_sold = $val; }

	public function set_status($val) { $this->status = $val; }
	public function set_payment_type($val) { $this->payment_type = $val; }
	public function set_name_card($val) { $this->name_card = $val; }
	public function set_credit_card($val) { $this->credit_card = $val; }

	public function set_coupon($val) { $this->coupon = $val; }
	public function set_coupon_discount($val) { $this->coupon_discount = $val; }

	public function set_card_number($val) { $this->card_number = $val; }
	public function set_exp_month($val) { $this->exp_month = $val; }
	public function set_exp_year($val) { $this->exp_year = $val; }
	public function set_sec_code($val) { $this->sec_code = $val; }

	public function set_bill_address($val) { $this->bill_address = $val; }
	public function set_ship_address($val) { $this->ship_address = $val; }
	public function set_ship_info($val) { $this->ship_info = $val; }


	// Public Methods

	function payment_type_enum($value) {
		return $this->payment_type_enum[$value];
	}


	public function update_total() {
		return $this->db->update_total($this);
	}

	public function product_ship_address($sale_ship_address_id) {
		$sale_products = new SaleProduct();
		$sale_products->update_ship_address($this->get_id(), $sale_ship_address_id);
	}

	public function item_count() {
		$sale_products = new SaleProduct();
		$sale_products->set_sale_id($this->get_id());
		$sale_products->set_status('st_added');
		return $sale_products->list_count(false);
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->sale_id);

			$this->set_hash($row->hash);
			$this->set_source($row->source);
			$this->set_user_id($row->user_id);
			$this->set_wholesaler_id($row->wholesaler_id);

			$this->set_total_weight($row->total_weight);
			$this->set_quantity($row->quantity);
			$this->set_subtotal($row->subtotal);
			$this->set_shipping($row->shipping);
			$this->set_taxes($row->taxes);
			$this->set_total($row->total);
			$this->set_created($row->created);
			$this->set_date_sold($row->date_sold);

			$this->set_status($row->status);
			$this->set_payment_type($row->payment_type);
			$this->set_name_card($row->name_card);
			$this->set_credit_card($row->credit_card);

			$this->set_coupon($row->coupon);
			$this->set_coupon_discount($row->coupon_discount);

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
