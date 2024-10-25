<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Document
 * GENERATION DATE:  10.01.2010
 * -------------------------------------------------------
 *
 */

class Article extends Document {

	// Private Vars

	protected $categories = array ('general' => 'General');
	protected $year = '';

	protected $dbClass = 'ArticleDb';


	// Getters

	public function get_categories() { return $this->categories; }
	public function get_category() { return $this->categories[$this->category_key]; }
	public function get_year() { return $this->year; }

	// Setters

	public function set_year($val) { $this->year = $val; }


	// Methods

	public function update($convert_arrays = true, $format_json = false) {
		$this->set_document_key($this->get_new_key('document_key', $this->get_document_key(), $this->get_title(), true));
		if ($this->get_id()) {
			return $this->db->update($this);
		} else {
			return $this->id = $this->db->insert($this);
		}
	}

}
?>