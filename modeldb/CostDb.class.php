<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Cost
 * GENERATION DATE:  08.07.2010
 * -------------------------------------------------------
 *
 */


class CostDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'cost';
	protected $primary = 'cost_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'cost_key' => false, 'title' => false, 'value' => false);


	// Custom

	public function retrieve_by_key($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => array("`cost_key` = ?"),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

}
?>
