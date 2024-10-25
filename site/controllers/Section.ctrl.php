<?php
class SectionCtrl extends CustomCtrl {
	protected $mod = 'Section';
	protected $class = 'Document';


	protected function run_default($args = array(), $action) {
		$this->run_single(false, array($action));
	}


	protected function run_single($object, $args = array()) {
		$document_key = array_shift($args);
		$document = new Document();
		$document->retrieve_by(
			array('document_key', 'lang_iso'), 
			array($document_key, $this->cfg->setting->language)
		);

		$img_tiles = [];
		if ($document->get_title() == 'About Us') {
			$img_tiles = $this->utl->get_property('about_us_imgs', array());
		}

		// Break in pages
		$content = html_entity_decode($document->get_content());
		$page_args = array_merge($args, array(
				'meta_title' => $document->get_title(), 
				'body_id' => 'body_sect_' . $document_key,
				'meta_description' => $document->get_meta_description(), 
				'meta_keywords' => $document->get_meta_keywords(),

				'title' => $document->get_title(),
				'content' => $content,
				'img_tiles' => $img_tiles
			));

		parent::run_single($document, $page_args);
	}

}
?>