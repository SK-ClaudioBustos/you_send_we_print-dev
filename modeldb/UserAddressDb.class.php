<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        UserAddressDb
 * GENERATION DATE:  30.07.2012
 * -------------------------------------------------------
 *
 */


class UserAddressDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'user_address';
	protected $primary = 'user_address_id';

	protected $fields = array(
			'user_id' => false, 'ship_company' => false, 'ship_first_name' => false, 'ship_last_name' => false,
			'ship_address' => false, 'ship_city' => false, 'ship_state' => false, 'ship_zip' => false,
			'ship_country' => false, 'ship_phone' => false, 'ship_fax' => false, 'active' => false);


}
?>
