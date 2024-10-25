<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        StockMove
 * GENERATION DATE:  2016-02-01
 * -------------------------------------------------------
 *
 */

class StockMove extends Base {

	// Protected Vars

	protected $dbClass = 'StockMoveDb';

	protected $user_id = '';
	protected $product_id = '';
	protected $concept = '';
	protected $concept_other = '';
	protected $quantity = '';
	protected $balance = '';

	protected $product = '';
	protected $username = '';


	// Getters

	public function get_string() { return $this->product; }

	public function get_user_id() { return $this->user_id; }
	public function get_product_id() { return $this->product_id; }
	public function get_concept() { return $this->concept; }
	public function get_concept_other() { return $this->concept_other; }
	public function get_quantity() { return $this->quantity; }
	public function get_balance() { return $this->balance; }

	public function get_product() { return $this->product; }
	public function get_username() { return $this->username; }


	// Setters

	public function set_user_id($val) { $this->user_id = $val; }
	public function set_product_id($val) { $this->product_id = $val; }
	public function set_concept($val) { $this->concept = $val; }
	public function set_concept_other($val) { $this->concept_other = $val; }
	public function set_quantity($val) { $this->quantity = $val; }
	public function set_balance($val) { $this->balance = $val; }

	public function set_product($val) { $this->product = $val; }
	public function set_username($val) { $this->username = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->stock_move_id);

			$this->set_user_id($row->user_id);
			$this->set_product_id($row->product_id);
			$this->set_concept($row->concept);
			$this->set_concept_other($row->concept_other);
			$this->set_quantity($row->quantity);
			$this->set_balance($row->balance);
			$this->set_created($row->created);

			$this->set_product($row->title);
			$this->set_username($row->username);
		}
		return $this->row = $row;
	}

}
?>
