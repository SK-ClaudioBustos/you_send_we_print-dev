<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        TaxCountyDb
 * GENERATION DATE:  29.11.2015
 * -------------------------------------------------------
 *
 */


class TaxCountyDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'county';
	protected $primary = 'county_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'county' => false, 'tax' => false
		);
	
}
?>
