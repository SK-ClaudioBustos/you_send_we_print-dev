<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        New_paypal
 * GENERATION DATE:  2021-03-03
 * -------------------------------------------------------
 *
 */

class New_paypal extends Base {

	// Protected Vars

	protected $dbClass = 'New_paypalDb';

	protected $sale_id = '';
	protected $transaction_id = '';
	protected $status = '';
	protected $email = '';
	protected $payer_id = '';
	protected $value = '';
	protected $full_name = '';
	protected $full_address = '';

	//protected $sale = '';
	//protected $transaction = '';
	//protected $payer = '';


	// Getters

	public function get_string() { return $this->new_paypal_id; }

	public function get_sale_id() { return $this->sale_id; }
	public function get_transaction_id() { return $this->transaction_id; }
	public function get_status() { return $this->status; }
	public function get_email() { return $this->email; }
	public function get_payer_id() { return $this->payer_id; }
	public function get_value() { return $this->value; }
	public function get_full_name() { return $this->full_name; }
	public function get_full_address() { return $this->full_address; }

	//public function get_sale() { return $this->sale; }
	//public function get_transaction() { return $this->transaction; }
	//public function get_payer() { return $this->payer; }


	// Setters

	public function set_sale_id($val) { $this->sale_id = $val; }
	public function set_transaction_id($val) { $this->transaction_id = $val; }
	public function set_status($val) { $this->status = $val; }
	public function set_email($val) { $this->email = $val; }
	public function set_payer_id($val) { $this->payer_id = $val; }
	public function set_value($val) { $this->value = $val; }
	public function set_full_name($val) { $this->full_name = $val; }
	public function set_full_address($val) { $this->full_address = $val; }

	//public function set_sale($val) { $this->sale = $val; }
	//public function set_transaction($val) { $this->transaction = $val; }
	//public function set_payer($val) { $this->payer = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->new_paypal_id);

			$this->set_sale_id($row->sale_id);
			$this->set_transaction_id($row->transaction_id);
			$this->set_status($row->status);
			$this->set_email($row->email);
			$this->set_payer_id($row->payer_id);
			$this->set_value($row->value);
			$this->set_full_name($row->full_name);
			$this->set_full_address($row->full_address);
			$this->set_created($row->created);
			$this->set_active($row->active);

			//$this->set_sale($row->sale);
			//$this->set_transaction($row->transaction);
			//$this->set_payer($row->payer);
		}
		return $this->row = $row;
	}

}
?>
