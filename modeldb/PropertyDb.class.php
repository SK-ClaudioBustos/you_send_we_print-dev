<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PropertyDb
 * GENERATION DATE:  22.01.2016
 * -------------------------------------------------------
 *
 */


class PropertyDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'property';
	protected $primary = 'property_id';

	protected $has_active = false;

	protected $fields = array(
			'property_key' => false, 'property' => false, 'type' => false, 'value' => false,
			'value_str' => false, 'hidden' => false, 'created' => false
		);

}
?>
