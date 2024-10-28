<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Item_listDb
 * GENERATION DATE:  2019-10-30
 * -------------------------------------------------------
 *
 */


class Item_listDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'item_list';
	protected $primary = 'item_list_id';

	protected $fields = array(
			'item_list_key' => false, 'title' => false, 'description' => false, 'calc_by' => false, 
			'active' => false
		);
	
}
?>
