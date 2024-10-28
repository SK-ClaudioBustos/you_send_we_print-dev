<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemListDb
 * GENERATION DATE:  2020-04-24
 * -------------------------------------------------------
 *
 */


class ItemListDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'item_list';
	protected $primary = 'item_list_id';

	protected $fields = array(
			'item_list_key' => false, 'title' => false, 'description' => false, 'calc_by' => false, 
			'standard' => false, 'has_cut' => false, 'has_max' => false, 'active' => false
		);
	
}
?>
