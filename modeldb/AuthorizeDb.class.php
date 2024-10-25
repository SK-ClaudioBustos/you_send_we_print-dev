<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        AuthorizeDb
 * GENERATION DATE:  16.10.2015
 * -------------------------------------------------------
 *
 */


class AuthorizeDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'authorize';
	protected $primary = 'authorize_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'sale_id' => false, 'response_code' => false, 'response_reason_code' => false, 'response_reason_text' => false, 
			'authorization_code' => false, 'avs_response' => false, 'transaction_id' => false, 'description' => false, 
			'amount' => false, 'method' => false, 'transaction_type' => false, 'md5_hash' => false, 
			'card_code_response' => false, 'cavr' => false, 'account_number' => false, 'card_type' => false
		);
	
}
?>
