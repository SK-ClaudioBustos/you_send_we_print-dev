<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Paypal
 * GENERATION DATE:  26.03.2014
 * -------------------------------------------------------
 *
 */

class Paypal extends Base {

	// Protected Vars

	protected $dbClass = 'PaypalDb';

	protected $via = '';
	protected $user_id = '';
	protected $processed = '';

	protected $invoice = '';
	protected $custom = '';
	protected $test_ipn = '';
	protected $memo = '';
	protected $business = '';
	protected $receiver_id = '';
	protected $receiver_email = '';
	protected $first_name = '';
	protected $last_name = '';
	protected $contact_phone = '';
	protected $address_city = '';
	protected $address_country = '';
	protected $address_country_code = '';
	protected $address_name = '';
	protected $address_state = '';
	protected $address_status = '';
	protected $address_street = '';
	protected $address_zip = '';
	protected $payer_business_name = '';
	protected $payer_email = '';
	protected $payer_id = '';
	protected $payer_status = '';
	protected $residence_country = '';
	protected $txn_id = '';
	protected $txn_type = '';
	protected $transaction_entity = '';
	protected $tax = '';
	protected $auth_id = '';
	protected $auth_exp = '';
	protected $auth_status = '';
	protected $auth_amount = '';
	protected $num_cart_items = '';
	protected $mc_currency = '';
	protected $exchange_rate = '';
	protected $mc_fee = '';
	protected $mc_gross = '';
	protected $parent_txn_id = '';
	protected $payment_date = '';
	protected $payment_status = '';
	protected $payment_type = '';
	protected $pending_reason = '';
	protected $reason_code = '';
	protected $remaining_settle = '';
	protected $mc_handling = '';
	protected $mc_shipping = '';
	protected $settle_currency = '';
	protected $case_id = '';
	protected $case_type = '';
	protected $case_creation_date = '';
	protected $handling = '';
	protected $shipping = '';
	protected $settle_amount = '';
	protected $auction_buyer_id = '';
	protected $auction_closing_date = '';
	protected $auction_multi_item = '';
	protected $for_auction = '';
	protected $subscr_date = '';
	protected $subscr_effective = '';
	protected $period1 = '';
	protected $period2 = '';
	protected $period3 = '';
	protected $amount1 = '';
	protected $amount2 = '';
	protected $amount3 = '';
	protected $mc_amount1 = '';
	protected $mc_amount2 = '';
	protected $mc_amount3 = '';
	protected $recurring = '';
	protected $reattempt = '';
	protected $retry_at = '';
	protected $recur_times = '';
	protected $username = '';
	protected $password = '';
	protected $subscr_id = '';
	protected $receipt_id = '';


	// Getters

	public function get_via() { return $this->via; }
	public function get_user_id() { return $this->user_id; }
	public function get_processed() { return $this->processed; }

	public function get_invoice() { return $this->invoice; }
	public function get_custom() { return $this->custom; }
	public function get_test_ipn() { return $this->test_ipn; }
	public function get_memo() { return $this->memo; }
	public function get_business() { return $this->business; }
	public function get_receiver_id() { return $this->receiver_id; }
	public function get_receiver_email() { return $this->receiver_email; }
	public function get_first_name() { return $this->first_name; }
	public function get_last_name() { return $this->last_name; }
	public function get_contact_phone() { return $this->contact_phone; }
	public function get_address_city() { return $this->address_city; }
	public function get_address_country() { return $this->address_country; }
	public function get_address_country_code() { return $this->address_country_code; }
	public function get_address_name() { return $this->address_name; }
	public function get_address_state() { return $this->address_state; }
	public function get_address_status() { return $this->address_status; }
	public function get_address_street() { return $this->address_street; }
	public function get_address_zip() { return $this->address_zip; }
	public function get_payer_business_name() { return $this->payer_business_name; }
	public function get_payer_email() { return $this->payer_email; }
	public function get_payer_id() { return $this->payer_id; }
	public function get_payer_status() { return $this->payer_status; }
	public function get_residence_country() { return $this->residence_country; }
	public function get_txn_id() { return $this->txn_id; }
	public function get_txn_type() { return $this->txn_type; }
	public function get_transaction_entity() { return $this->transaction_entity; }
	public function get_tax() { return $this->tax; }
	public function get_auth_id() { return $this->auth_id; }
	public function get_auth_exp() { return $this->auth_exp; }
	public function get_auth_status() { return $this->auth_status; }
	public function get_auth_amount() { return $this->auth_amount; }
	public function get_num_cart_items() { return $this->num_cart_items; }
	public function get_mc_currency() { return $this->mc_currency; }
	public function get_exchange_rate() { return $this->exchange_rate; }
	public function get_mc_fee() { return $this->mc_fee; }
	public function get_mc_gross() { return $this->mc_gross; }
	public function get_parent_txn_id() { return $this->parent_txn_id; }
	public function get_payment_date() { return $this->payment_date; }
	public function get_payment_status() { return $this->payment_status; }
	public function get_payment_type() { return $this->payment_type; }
	public function get_pending_reason() { return $this->pending_reason; }
	public function get_reason_code() { return $this->reason_code; }
	public function get_remaining_settle() { return $this->remaining_settle; }
	public function get_mc_handling() { return $this->mc_handling; }
	public function get_mc_shipping() { return $this->mc_shipping; }
	public function get_settle_currency() { return $this->settle_currency; }
	public function get_case_id() { return $this->case_id; }
	public function get_case_type() { return $this->case_type; }
	public function get_case_creation_date() { return $this->case_creation_date; }
	public function get_handling() { return $this->handling; }
	public function get_shipping() { return $this->shipping; }
	public function get_settle_amount() { return $this->settle_amount; }
	public function get_auction_buyer_id() { return $this->auction_buyer_id; }
	public function get_auction_closing_date() { return $this->auction_closing_date; }
	public function get_auction_multi_item() { return $this->auction_multi_item; }
	public function get_for_auction() { return $this->for_auction; }
	public function get_subscr_date() { return $this->subscr_date; }
	public function get_subscr_effective() { return $this->subscr_effective; }
	public function get_period1() { return $this->period1; }
	public function get_period2() { return $this->period2; }
	public function get_period3() { return $this->period3; }
	public function get_amount1() { return $this->amount1; }
	public function get_amount2() { return $this->amount2; }
	public function get_amount3() { return $this->amount3; }
	public function get_mc_amount1() { return $this->mc_amount1; }
	public function get_mc_amount2() { return $this->mc_amount2; }
	public function get_mc_amount3() { return $this->mc_amount3; }
	public function get_recurring() { return $this->recurring; }
	public function get_reattempt() { return $this->reattempt; }
	public function get_retry_at() { return $this->retry_at; }
	public function get_recur_times() { return $this->recur_times; }
	public function get_username() { return $this->username; }
	public function get_password() { return $this->password; }
	public function get_subscr_id() { return $this->subscr_id; }
	public function get_receipt_id() { return $this->receipt_id; }


	// Setters

	public function set_via($val) { $this->via = $val; }
	public function set_user_id($val) { $this->user_id = $val; }
	public function set_processed($val) { $this->processed = $val; }

	public function set_invoice($val) { $this->invoice = $val; }
	public function set_custom($val) { $this->custom = $val; }
	public function set_test_ipn($val) { $this->test_ipn = $val; }
	public function set_memo($val) { $this->memo = $val; }
	public function set_business($val) { $this->business = $val; }
	public function set_receiver_id($val) { $this->receiver_id = $val; }
	public function set_receiver_email($val) { $this->receiver_email = $val; }
	public function set_first_name($val) { $this->first_name = $val; }
	public function set_last_name($val) { $this->last_name = $val; }
	public function set_contact_phone($val) { $this->contact_phone = $val; }
	public function set_address_city($val) { $this->address_city = $val; }
	public function set_address_country($val) { $this->address_country = $val; }
	public function set_address_country_code($val) { $this->address_country_code = $val; }
	public function set_address_name($val) { $this->address_name = $val; }
	public function set_address_state($val) { $this->address_state = $val; }
	public function set_address_status($val) { $this->address_status = $val; }
	public function set_address_street($val) { $this->address_street = $val; }
	public function set_address_zip($val) { $this->address_zip = $val; }
	public function set_payer_business_name($val) { $this->payer_business_name = $val; }
	public function set_payer_email($val) { $this->payer_email = $val; }
	public function set_payer_id($val) { $this->payer_id = $val; }
	public function set_payer_status($val) { $this->payer_status = $val; }
	public function set_residence_country($val) { $this->residence_country = $val; }
	public function set_txn_id($val) { $this->txn_id = $val; }
	public function set_txn_type($val) { $this->txn_type = $val; }
	public function set_transaction_entity($val) { $this->transaction_entity = $val; }
	public function set_tax($val) { $this->tax = $val; }
	public function set_auth_id($val) { $this->auth_id = $val; }
	public function set_auth_exp($val) { $this->auth_exp = $val; }
	public function set_auth_status($val) { $this->auth_status = $val; }
	public function set_auth_amount($val) { $this->auth_amount = $val; }
	public function set_num_cart_items($val) { $this->num_cart_items = $val; }
	public function set_mc_currency($val) { $this->mc_currency = $val; }
	public function set_exchange_rate($val) { $this->exchange_rate = $val; }
	public function set_mc_fee($val) { $this->mc_fee = $val; }
	public function set_mc_gross($val) { $this->mc_gross = $val; }
	public function set_parent_txn_id($val) { $this->parent_txn_id = $val; }
	public function set_payment_date($val) { $this->payment_date = $val; }
	public function set_payment_status($val) { $this->payment_status = $val; }
	public function set_payment_type($val) { $this->payment_type = $val; }
	public function set_pending_reason($val) { $this->pending_reason = $val; }
	public function set_reason_code($val) { $this->reason_code = $val; }
	public function set_remaining_settle($val) { $this->remaining_settle = $val; }
	public function set_mc_handling($val) { $this->mc_handling = $val; }
	public function set_mc_shipping($val) { $this->mc_shipping = $val; }
	public function set_settle_currency($val) { $this->settle_currency = $val; }
	public function set_case_id($val) { $this->case_id = $val; }
	public function set_case_type($val) { $this->case_type = $val; }
	public function set_case_creation_date($val) { $this->case_creation_date = $val; }
	public function set_handling($val) { $this->handling = $val; }
	public function set_shipping($val) { $this->shipping = $val; }
	public function set_settle_amount($val) { $this->settle_amount = $val; }
	public function set_auction_buyer_id($val) { $this->auction_buyer_id = $val; }
	public function set_auction_closing_date($val) { $this->auction_closing_date = $val; }
	public function set_auction_multi_item($val) { $this->auction_multi_item = $val; }
	public function set_for_auction($val) { $this->for_auction = $val; }
	public function set_subscr_date($val) { $this->subscr_date = $val; }
	public function set_subscr_effective($val) { $this->subscr_effective = $val; }
	public function set_period1($val) { $this->period1 = $val; }
	public function set_period2($val) { $this->period2 = $val; }
	public function set_period3($val) { $this->period3 = $val; }
	public function set_amount1($val) { $this->amount1 = $val; }
	public function set_amount2($val) { $this->amount2 = $val; }
	public function set_amount3($val) { $this->amount3 = $val; }
	public function set_mc_amount1($val) { $this->mc_amount1 = $val; }
	public function set_mc_amount2($val) { $this->mc_amount2 = $val; }
	public function set_mc_amount3($val) { $this->mc_amount3 = $val; }
	public function set_recurring($val) { $this->recurring = $val; }
	public function set_reattempt($val) { $this->reattempt = $val; }
	public function set_retry_at($val) { $this->retry_at = $val; }
	public function set_recur_times($val) { $this->recur_times = $val; }
	public function set_username($val) { $this->username = $val; }
	public function set_password($val) { $this->password = $val; }
	public function set_subscr_id($val) { $this->subscr_id = $val; }
	public function set_receipt_id($val) { $this->receipt_id = $val; }


	// Public Methods

	public function retrieve_by_token($token, $via) {
		$this->rs = $this->db->retrieve_by_token($token, $via);
		$this->load();
		return $this->get_id();
	}

	public function retrieve_completed($token) {
		$this->rs = $this->db->retrieve_completed($token);
		$this->load();
		return $this->get_id();
	}

	public function retrieve_pending($user_id) {
		$token = $this->db->retrieve_pending($user_id);
		return $token;
	}

	public function update_completed($token) {
		$this->db->update_completed($token);
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->paypal_id);

			$this->set_via($row->via);
			$this->set_user_id($row->user_id);
			$this->set_processed($row->processed);

			$this->set_invoice($row->invoice);
			$this->set_custom($row->custom);
			$this->set_test_ipn($row->test_ipn);
			$this->set_memo($row->memo);
			$this->set_business($row->business);
			$this->set_receiver_id($row->receiver_id);
			$this->set_receiver_email($row->receiver_email);
			$this->set_first_name($row->first_name);
			$this->set_last_name($row->last_name);
			$this->set_contact_phone($row->contact_phone);
			$this->set_address_city($row->address_city);
			$this->set_address_country($row->address_country);
			$this->set_address_country_code($row->address_country_code);
			$this->set_address_name($row->address_name);
			$this->set_address_state($row->address_state);
			$this->set_address_status($row->address_status);
			$this->set_address_street($row->address_street);
			$this->set_address_zip($row->address_zip);
			$this->set_payer_business_name($row->payer_business_name);
			$this->set_payer_email($row->payer_email);
			$this->set_payer_id($row->payer_id);
			$this->set_payer_status($row->payer_status);
			$this->set_residence_country($row->residence_country);
			$this->set_txn_id($row->txn_id);
			$this->set_txn_type($row->txn_type);
			$this->set_transaction_entity($row->transaction_entity);
			$this->set_tax($row->tax);
			$this->set_auth_id($row->auth_id);
			$this->set_auth_exp($row->auth_exp);
			$this->set_auth_status($row->auth_status);
			$this->set_auth_amount($row->auth_amount);
			$this->set_num_cart_items($row->num_cart_items);
			$this->set_mc_currency($row->mc_currency);
			$this->set_exchange_rate($row->exchange_rate);
			$this->set_mc_fee($row->mc_fee);
			$this->set_mc_gross($row->mc_gross);
			$this->set_parent_txn_id($row->parent_txn_id);
			$this->set_payment_date($row->payment_date);
			$this->set_payment_status($row->payment_status);
			$this->set_payment_type($row->payment_type);
			$this->set_pending_reason($row->pending_reason);
			$this->set_reason_code($row->reason_code);
			$this->set_remaining_settle($row->remaining_settle);
			$this->set_mc_handling($row->mc_handling);
			$this->set_mc_shipping($row->mc_shipping);
			$this->set_settle_currency($row->settle_currency);
			$this->set_case_id($row->case_id);
			$this->set_case_type($row->case_type);
			$this->set_case_creation_date($row->case_creation_date);
			$this->set_handling($row->handling);
			$this->set_shipping($row->shipping);
			$this->set_settle_amount($row->settle_amount);
			$this->set_auction_buyer_id($row->auction_buyer_id);
			$this->set_auction_closing_date($row->auction_closing_date);
			$this->set_auction_multi_item($row->auction_multi_item);
			$this->set_for_auction($row->for_auction);
			$this->set_subscr_date($row->subscr_date);
			$this->set_subscr_effective($row->subscr_effective);
			$this->set_period1($row->period1);
			$this->set_period2($row->period2);
			$this->set_period3($row->period3);
			$this->set_amount1($row->amount1);
			$this->set_amount2($row->amount2);
			$this->set_amount3($row->amount3);
			$this->set_mc_amount1($row->mc_amount1);
			$this->set_mc_amount2($row->mc_amount2);
			$this->set_mc_amount3($row->mc_amount3);
			$this->set_recurring($row->recurring);
			$this->set_reattempt($row->reattempt);
			$this->set_retry_at($row->retry_at);
			$this->set_recur_times($row->recur_times);
			$this->set_username($row->username);
			$this->set_password($row->password);
			$this->set_subscr_id($row->subscr_id);
			$this->set_receipt_id($row->receipt_id);
		}
		return $this->row = $row;
	}

}
?>
