<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        TaxZipDb
 * GENERATION DATE:  29.11.2015
 * -------------------------------------------------------
 *
 */


class TaxZipDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'zip';
	protected $primary = 'zip_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'zip' => false, 'city' => false, 'county_id' => false
		);


	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`CT`.`tax`",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}county` `CT` USING(`county_id`)",
			);
		return parent::retrieve_by($fields, $values, $active_only, $hide_deleted, $sql_parts);
	}

}
?>
