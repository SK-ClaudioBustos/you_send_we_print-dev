<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Document
 * GENERATION DATE:  10.01.2010
 * -------------------------------------------------------
 *
 */

class Document extends Base {

	// Private Vars

	protected $document_key = '';
	protected $section_key = '';
	protected $category_key = '';
	protected $lang_iso = '';
	protected $parent_id = '';
	protected $featured = '';
	protected $pre_title = '';
	protected $title = '';
	protected $subtitle = '';
	protected $author = '';
	protected $brief = '';
	protected $content = '';
	protected $source = '';
	protected $source_url = '';
	protected $order = '';
	protected $status = '';
	protected $created = '';
	protected $date_begin = '';
	protected $date_end = '';
	protected $user_id = '';

	protected $pictures = '';
	protected $expand_pic = '';
	protected $filename = '';
	protected $original_name = '';
	
	protected $meta_description = '';
	protected $meta_keywords = '';

	protected $dbClass = 'DocumentDb';


	// Getters

	public function get_string() { return $this->title; }

	public function get_document_key() { return $this->document_key; }
	public function get_section_key() { return $this->section_key; }
	public function get_category_key() { return $this->category_key; }
	public function get_lang_iso() { return $this->lang_iso; }
	public function get_parent_id() { return $this->parent_id; }
	public function get_featured() { return $this->featured; }
	public function get_pre_title() { return $this->pre_title; }
	public function get_title() { return $this->title; }
	public function get_subtitle() { return $this->subtitle; }
	public function get_author() { return $this->author; }
	public function get_brief() { return $this->brief; }
	public function get_content() { return $this->content; }
	public function get_source() { return $this->source; }
	public function get_source_url() { return $this->source_url; }
	public function get_status() { return $this->status; }
	public function get_order() { return $this->order; }
	public function get_date_begin() { return $this->date_begin; }
	public function get_date_end() { return $this->date_end; }
	public function get_user_id() { return $this->user_id; }
	
	public function get_pictures() { return $this->pictures; }
	public function get_expand_pic() { return $this->expand_pic; }
	public function get_filename() { return $this->filename; }
	public function get_original_name() { return $this->original_name; }

	public function get_meta_description() { return $this->meta_description; }
	public function get_meta_keywords() { return $this->meta_keywords; }


	// Setters

	public function set_document_key($val) { $this->document_key = $val; }
	public function set_section_key($val) { $this->section_key = $val; }
	public function set_category_key($val) { $this->category_key = $val; }
	public function set_lang_iso($val) { $this->lang_iso = $val; }
	public function set_parent_id($val) { $this->parent_id = $val; }
	public function set_featured($val) { $this->featured = $val; }
	public function set_pre_title($val) { $this->pre_title = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_subtitle($val) { $this->subtitle = $val; }
	public function set_author($val) { $this->author = $val; }
	public function set_brief($val) { $this->brief = $val; }
	public function set_content($val) { $this->content = $val; }
	public function set_source($val) { $this->source =  $val; }
	public function set_source_url($val) { $this->source_url =  $val; }
	public function set_status($val) { $this->status = $val; }
	public function set_order($val) { $this->order = $val; }
	public function set_date_begin($val) { $this->date_begin = $val; }
	public function set_date_end($val) { $this->date_end = $val; }
	public function set_user_id($val) { $this->user_id = $val; }
	
	public function set_pictures($val) { $this->pictures = $val; }
	public function set_expand_pic($val) { $this->expand_pic = $val; }
	public function set_filename($val) { $this->filename = $val; }
	public function set_original_name($val) { $this->original_name = $val; }

	public function set_meta_description($val) { $this->meta_description = $val; }
	public function set_meta_keywords($val) { $this->meta_keywords = $val; }


	// Functions

	public function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->document_id);

			$this->set_document_key($row->document_key);
			$this->set_section_key($row->section_key);
			$this->set_category_key($row->category_key);
			$this->set_lang_iso($row->lang_iso);
			$this->set_parent_id($row->parent_id);
			$this->set_featured($row->featured);
			$this->set_pre_title($row->pre_title);
			$this->set_title($row->title);
			$this->set_subtitle($row->subtitle);
			$this->set_author($row->author);
			$this->set_brief($row->brief);
			$this->set_content($row->content);
			$this->set_source($row->source);
			$this->set_source_url($row->source_url);
			$this->set_status($row->status);
			$this->set_order($row->order);
			$this->set_created($row->created);
			$this->set_date_begin($row->date_begin);
			$this->set_date_end($row->date_end);
			$this->set_user_id($row->user_id);

			$this->set_pictures($row->pictures);
			$this->set_expand_pic($row->expand_pic);
			$this->set_filename($row->filename);
			$this->set_original_name($row->original_name);

			$this->set_meta_description($row->meta_description);
			$this->set_meta_keywords($row->meta_keywords);
			$this->set_active($row->active);
			$this->set_deleted($row->deleted);
		}
		return $this->row = $row;
	}



	//// Custom
	//public function retrieve_by($document_key, $lang_iso = 'en') {
	//    $this->rs = $this->db->retrieve_by_key(array($document_key, $lang_iso));
	//    $this->load();
	//}

	public function get_intro($lenght) {
		// the double 'html_entity_decode' is correct because tinyMce store á as &amp;aacute;
    	if ($this->brief) {
			$intro = mb_substr(strip_tags($this->brief), 0, $lenght);
			$intro_len = strlen($intro);
			if ($intro_len < $lenght) {
				$intro .= '<br /><br />' . mb_substr(strip_tags(html_entity_decode(html_entity_decode($this->content), ENT_COMPAT, 'UTF-8')), 0, $lenght - $intro_len);
			}
		} else {
			$intro = mb_substr(strip_tags(html_entity_decode(html_entity_decode($this->content), ENT_COMPAT, 'UTF-8')), 0, $lenght);
		}
		return $intro . '&hellip;'; //((strlen($intro) > $lenght) ? '&hellip;' : '');
	}

	public function list_last($number) {
		if ($this->row == null) $this->rs = DocumentDb::List_last($this, $number);
		return $this->load();
	}

}
?>
