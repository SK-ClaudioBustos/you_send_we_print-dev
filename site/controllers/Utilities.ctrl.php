<?php
class UtilitiesCtrl extends CustomCtrl {
	protected $mod = 'Utilities';
	protected $class = 'Document';


	protected function run_default($args = array(), $action) {
		$this->run_multiple($args);
	}


	protected function run_multiple($args = array()) {
		$text = new Document();
		$text->retrieve_by(
				array('document_key', 'lang_iso'), 
				array('utilities', $this->cfg->setting->language)
			);

		$title = $this->lng->text('menu:utilities');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_utilities',
				'meta_description' => $this->lng->meta('utilities:description'),
				'meta_keywords' => $this->lng->meta('utilities:keywords'),
				'title' => $title,
				'text' => html_entity_decode($text->get_content()),
			));

		parent::run_multiple($page_args);
	}

}
?>