<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Contact
 * GENERATION DATE:  10.01.2010
 * -------------------------------------------------------
 *
 */


class ContactDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'contact';
	protected $primary = 'contact_id';

	// false means "'{$object->get_[field]()}'"
	protected $fields = array(
			'section_key' => false, 'category_key' => false, 'first_name' => false, 'last_name' => false,
			'address' => false, 'phone' => false, 'email' => false, 'country_id' => false,
			'city' => false, 'message' => false, 'ip' => false, 'approved' => false, 'created' => false,
			'active' => false
		);


	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => array("`section_key` = '{$object->get_section_key()}'"),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => array("`section_key` = '{$object->get_section_key()}'"),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function remove_by_mail($email, $section_key) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET `deleted` = 1
					WHERE `email` = ?
						AND `section_key` = ?;";
		$stmt = $this->db->prepare($query);
		return $stmt->execute(array($email, $section_key));
	}


}
?>
