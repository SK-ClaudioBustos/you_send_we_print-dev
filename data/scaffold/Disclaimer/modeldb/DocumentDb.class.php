<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        DocumentDb
 * GENERATION DATE:  2019-06-11
 * -------------------------------------------------------
 *
 */


class DocumentDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'document';
	protected $primary = 'document_id';

	protected $fields = array(
			'document_key' => false, 'section_key' => false, 'category_key' => false, 'lang_iso' => false, 
			'parent_id' => false, 'featured' => false, 'pre_title' => false, 'title' => false, 
			'subtitle' => false, 'author' => false, 'brief' => false, 'content' => false, 
			'source' => false, 'source_url' => false, 'order' => false, 'status' => false, 
			'date_begin' => false, 'date_end' => false, 'user_id' => false, 'pictures' => false, 
			'expand_pic' => false, 'filename' => false, 'original_name' => false, 'meta_description' => false, 
			'meta_keywords' => false, 'created' => false, 'active' => false
		);
	
}
?>
