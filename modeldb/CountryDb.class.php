<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CountryDb
 * GENERATION DATE:  15.12.2013
 * -------------------------------------------------------
 *
 */


class CountryDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'country';
	protected $primary = 'id_country';
	
	protected $has_deleted = false;
	
	protected $fields = array(
			'country' => false, 'id_region' => false, 'iso' => false, 'currency' => false, 
			'curr_description' => false, 'curr_symbol' => false, 'active' => false);
	
}
?>
