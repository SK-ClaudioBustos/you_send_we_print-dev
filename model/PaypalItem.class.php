<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PaypalItem
 * GENERATION DATE:  26.03.2014
 * -------------------------------------------------------
 *
 */

class PaypalItem extends Base {

	// Protected Vars

	protected $dbClass = 'PaypalItemDb';

	protected $paypal_id = '';
	protected $number = '';
	protected $item_name = '';
	protected $item_number = '';
	protected $quantity = '';
	protected $mc_gross = '';
	protected $option_name1 = '';
	protected $option_selection1 = '';
	protected $option_name2 = '';
	protected $option_selection2 = '';
	protected $active = '';


	// Getters

	public function get_paypal_id() { return $this->paypal_id; }
	public function get_number() { return $this->number; }
	public function get_item_name() { return $this->item_name; }
	public function get_item_number() { return $this->item_number; }
	public function get_quantity() { return $this->quantity; }
	public function get_mc_gross() { return $this->mc_gross; }
	public function get_option_name1() { return $this->option_name1; }
	public function get_option_selection1() { return $this->option_selection1; }
	public function get_option_name2() { return $this->option_name2; }
	public function get_option_selection2() { return $this->option_selection2; }
	public function get_active() { return $this->active; }


	// Setters

	public function set_paypal_id($val) { $this->paypal_id = $val; }
	public function set_number($val) { $this->number = $val; }
	public function set_item_name($val) { $this->item_name = $val; }
	public function set_item_number($val) { $this->item_number = $val; }
	public function set_quantity($val) { $this->quantity = $val; }
	public function set_mc_gross($val) { $this->mc_gross = $val; }
	public function set_option_name1($val) { $this->option_name1 = $val; }
	public function set_option_selection1($val) { $this->option_selection1 = $val; }
	public function set_option_name2($val) { $this->option_name2 = $val; }
	public function set_option_selection2($val) { $this->option_selection2 = $val; }
	public function set_active($val) { $this->active = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->paypal_item_id);

			$this->set_paypal_id($row->paypal_id);
			$this->set_number($row->number);
			$this->set_item_name($row->item_name);
			$this->set_item_number($row->item_number);
			$this->set_quantity($row->quantity);
			$this->set_mc_gross($row->mc_gross);
			$this->set_option_name1($row->option_name1);
			$this->set_option_selection1($row->option_selection1);
			$this->set_option_name2($row->option_name2);
			$this->set_option_selection2($row->option_selection2);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
