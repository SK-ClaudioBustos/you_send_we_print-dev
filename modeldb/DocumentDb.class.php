<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Document
 * GENERATION DATE:  10.01.2010
 * -------------------------------------------------------
 *
 */


class DocumentDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'document';
	protected $primary = 'document_id';

	// false means "'{$object->get_[field]()}'"
	protected $fields = array(
			'document_key' => false, 'section_key' => false, 'category_key' => false, 'lang_iso' => false,
			'parent_id' => false, 'featured' => false, 'pre_title' => false, 'title' => false,
			'subtitle' => false, 'author' => false, 'brief' => false, 'content' => false,
			'source' => false, 'source_url' => false, 'order' => false, 'status' => false,
			'date_begin' => false, 'date_end' => false, 'user_id' => false, 'pictures' => false,
			'expand_pic' => false, 'filename' => false, 'original_name' => false, 'meta_description' => false, 
			'meta_keywords' => false, 'created' => false, 'active' => false);


	// Lists

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = $this->get_filter($object);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}


	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = $this->get_filter($object);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}


	public function retrieve_by_key($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => array(
						"`document_key` = ?",
						"`lang_iso` = ?",
					),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	protected function get_filter($object) {
		$where = array();
		if ($object->get_section_key()) {
			$where = "`section_key` = '{$object->get_section_key()}'";
		}
		if ($object->get_category_key()) {
			$where = "`category_key` = '{$object->get_category_key()}'";
		}
		return array('where' => $where);
	}


}
?>
