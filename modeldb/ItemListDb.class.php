<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemList
 * GENERATION DATE:  19.06.2010
 * -------------------------------------------------------
 *
 */


class ItemListDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'item_list';
	protected $primary = 'item_list_id';

	protected $fields = array(
			'item_list_key' => false, 'title' => false, 'description' => false,'quantity_label' => false,'quantity_info' => false,  'calc_by' => false, 
			'standard' => false, 'has_cut' => false, 'has_max' => false, 'active' => false
		);


	public function list_paged_array($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`item_list_key`,
								`calc_by`,
								`has_cut`,
								`has_max`
							",
				'from' => "`{$this->prefix}{$this->table}`",
				'where' => array(),
			);
		return parent::list_paged_array($object, $active_only, $hide_deleted, $sql_parts);
	}

}
?>
