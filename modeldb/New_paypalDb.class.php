<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        New_paypalDb
 * GENERATION DATE:  2021-03-03
 * -------------------------------------------------------
 *
 */


class New_paypalDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'new_paypal';
	protected $primary = 'new_paypal_id';

	protected $fields = array(
			'sale_id' => false, 'transaction_id' => false, 'status' => false, 'email' => false, 
			'payer_id' => false, 'value' => false, 'full_name' => false, 'full_address' => false, 
			'created' => false, 'active' => false
		);
	
}
?>
