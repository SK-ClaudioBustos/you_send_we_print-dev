<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PaypalDb
 * GENERATION DATE:  26.03.2014
 * -------------------------------------------------------
 *
 */


class PaypalDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'paypal';
	protected $primary = 'paypal_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'via' => false, 'user_id' => false, 'processed' => false,
			'invoice' => false, 'custom' => false, 'test_ipn' => false, 'memo' => false,
			'business' => false, 'receiver_id' => false, 'receiver_email' => false, 'first_name' => false,
			'last_name' => false, 'contact_phone' => false, 'address_city' => false, 'address_country' => false,
			'address_country_code' => false, 'address_name' => false, 'address_state' => false, 'address_status' => false,
			'address_street' => false, 'address_zip' => false, 'payer_business_name' => false, 'payer_email' => false,
			'payer_id' => false, 'payer_status' => false, 'residence_country' => false, 'txn_id' => false,
			'txn_type' => false, 'transaction_entity' => false, 'tax' => false, 'auth_id' => false,
			'auth_exp' => false, 'auth_status' => false, 'auth_amount' => false, 'num_cart_items' => false,
			'mc_currency' => false, 'exchange_rate' => false, 'mc_fee' => false, 'mc_gross' => false,
			'parent_txn_id' => false, 'payment_date' => false, 'payment_status' => false, 'payment_type' => false,
			'pending_reason' => false, 'reason_code' => false, 'remaining_settle' => false, 'mc_handling' => false,
			'mc_shipping' => false, 'settle_currency' => false, 'case_id' => false, 'case_type' => false,
			'case_creation_date' => false, 'handling' => false, 'shipping' => false, 'settle_amount' => false,
			'auction_buyer_id' => false, 'auction_closing_date' => false, 'auction_multi_item' => false, 'for_auction' => false,
			'subscr_date' => false, 'subscr_effective' => false, 'period1' => false, 'period2' => false,
			'period3' => false, 'amount1' => false, 'amount2' => false, 'amount3' => false,
			'mc_amount1' => false, 'mc_amount2' => false, 'mc_amount3' => false, 'recurring' => false,
			'reattempt' => false, 'retry_at' => false, 'recur_times' => false, 'username' => false,
			'password' => false, 'subscr_id' => false, 'receipt_id' => false, 'active' => false, 'created' => false
		);



	public function retrieve_pending($user_id) {
		// OJO - user_id en tbl_paypal tiene el sale_id ******************************
		$query = "SELECT DISTINCT `custom`
					FROM `{$this->prefix}{$this->table}` `PP`
						INNER JOIN `tbl_sale` `SL` ON `SL`.`sale_id` = `PP`.`user_id`
					WHERE `PP`.`payment_status` = 'Completed'
						AND `PP`.`active` = 0
						AND `SL`.`active` = 0
						AND `SL`.`user_id` = ?
					ORDER BY `sale_id` DESC
					LIMIT 1"; // one at a time, most recent first
//echo $query;
//echo $user_id;
//exit;
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($user_id));
		$row = $stmt->fetch();
		return $row['custom'];
	}

	public function retrieve_completed($token) {
		$query = "SELECT * FROM `{$this->prefix}{$this->table}`
					WHERE `custom` = ?
						AND `payment_status` = 'Completed'
						AND `active` = 0
					LIMIT 1;";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($token));
		return $stmt;
	}

	public function update_completed($token) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
						SET `active` = 1
					WHERE `custom` = ?;
				";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($token));
		return $stmt;
	}

	public function retrieve_by_token($token, $via) {
		$query = "SELECT * FROM `{$this->prefix}{$this->table}`
					WHERE `custom` = ?
						AND `via` = ?;";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($token, $via));
		return $stmt;
	}

}
?>
