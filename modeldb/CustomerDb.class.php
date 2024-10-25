<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Customer
 * GENERATION DATE:  04.10.2010
 * -------------------------------------------------------
 *
 */


class CustomerDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'customer';
	protected $primary = 'customer_id';

	protected $fields = array(
			'user_id' => false, 'customer_type' => false, 'company' => false, 'first_name' => false,
			'last_name' => false, 'website' => false, 'business_type' => false, 'trade_id' => false,
			'how_hear' => false, 'bill_address' => false, 'bill_city' => false, 'bill_state' => false,
			'bill_zip' => false, 'bill_country' => false, 'bill_phone' => false, 'bill_fax' => false,
			'ship_same' => false, 'ship_company' => false, 'ship_first_name' => false, 'ship_last_name' => false,
			'ship_address' => false, 'ship_city' => false, 'ship_state' => false, 'ship_zip' => false,
			'ship_country' => false, 'ship_phone' => false, 'ship_fax' => false, 'language' => false,
			'status' => false, 'discount' => false, 'created' => false, 'active' => false);


	public function retrieve_by_user($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => array("`user_id` = ?"),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}


}
?>
