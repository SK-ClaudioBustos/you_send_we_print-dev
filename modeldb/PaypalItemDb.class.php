<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PaypalItemDb
 * GENERATION DATE:  26.03.2014
 * -------------------------------------------------------
 *
 */


class PaypalItemDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'paypal_item';
	protected $primary = 'paypal_item_id';
	
	protected $fields = array(
			'paypal_id' => false, 'number' => false, 'item_name' => false, 'item_number' => false, 
			'quantity' => false, 'mc_gross' => false, 'option_name1' => false, 'option_selection1' => false, 
			'option_name2' => false, 'option_selection2' => false, 'active' => false);
	
}
?>
