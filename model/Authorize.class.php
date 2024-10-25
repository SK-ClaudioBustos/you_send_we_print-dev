<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Authorize
 * GENERATION DATE:  16.10.2015
 * -------------------------------------------------------
 *
 */

class Authorize extends Base {

	// Protected Vars

	protected $dbClass = 'AuthorizeDb';

	protected $sale_id = '';
	protected $response_code = '';
	protected $response_reason_code = '';
	protected $response_reason_text = '';
	protected $authorization_code = '';
	protected $avs_response = '';
	protected $transaction_id = '';
	protected $description = '';
	protected $amount = '';
	protected $method = '';
	protected $transaction_type = '';
	protected $md5_hash = '';
	protected $card_code_response = '';
	protected $cavr = '';
	protected $account_number = '';
	protected $card_type = '';


	// Getters

	public function get_string() { return $this->authorize_id; }

	public function get_sale_id() { return $this->sale_id; }
	public function get_response_code() { return $this->response_code; }
	public function get_response_reason_code() { return $this->response_reason_code; }
	public function get_response_reason_text() { return $this->response_reason_text; }
	public function get_authorization_code() { return $this->authorization_code; }
	public function get_avs_response() { return $this->avs_response; }
	public function get_transaction_id() { return $this->transaction_id; }
	public function get_description() { return $this->description; }
	public function get_amount() { return $this->amount; }
	public function get_method() { return $this->method; }
	public function get_transaction_type() { return $this->transaction_type; }
	public function get_md5_hash() { return $this->md5_hash; }
	public function get_card_code_response() { return $this->card_code_response; }
	public function get_cavr() { return $this->cavr; }
	public function get_account_number() { return $this->account_number; }
	public function get_card_type() { return $this->card_type; }


	// Setters

	public function set_sale_id($val) { $this->sale_id = $val; }
	public function set_response_code($val) { $this->response_code = $val; }
	public function set_response_reason_code($val) { $this->response_reason_code = $val; }
	public function set_response_reason_text($val) { $this->response_reason_text = $val; }
	public function set_authorization_code($val) { $this->authorization_code = $val; }
	public function set_avs_response($val) { $this->avs_response = $val; }
	public function set_transaction_id($val) { $this->transaction_id = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_amount($val) { $this->amount = $val; }
	public function set_method($val) { $this->method = $val; }
	public function set_transaction_type($val) { $this->transaction_type = $val; }
	public function set_md5_hash($val) { $this->md5_hash = $val; }
	public function set_card_code_response($val) { $this->card_code_response = $val; }
	public function set_cavr($val) { $this->cavr = $val; }
	public function set_account_number($val) { $this->account_number = $val; }
	public function set_card_type($val) { $this->card_type = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->authorize_id);

			$this->set_sale_id($row->sale_id);
			$this->set_response_code($row->response_code);
			$this->set_response_reason_code($row->response_reason_code);
			$this->set_response_reason_text($row->response_reason_text);
			$this->set_authorization_code($row->authorization_code);
			$this->set_avs_response($row->avs_response);
			$this->set_transaction_id($row->transaction_id);
			$this->set_description($row->description);
			$this->set_amount($row->amount);
			$this->set_method($row->method);
			$this->set_transaction_type($row->transaction_type);
			$this->set_md5_hash($row->md5_hash);
			$this->set_card_code_response($row->card_code_response);
			$this->set_cavr($row->cavr);
			$this->set_account_number($row->account_number);
			$this->set_card_type($row->card_type);
		}
		return $this->row = $row;
	}

}
?>
