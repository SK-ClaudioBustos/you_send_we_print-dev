<?php
class ArtspecCtrl extends CustomCtrl {
	protected $mod = 'Artspec';
	protected $class = 'Document';


	protected function run_default($args = array(), $action = []) {
		$this->run_multiple($args);
	}


	protected function run_multiple($args = array()) {
		$categories = array(
				'guidelines' => 'Artwork Guidelines'
			);

		$objects = array();
		foreach ($categories as $key => $value) {
			$category_spec = new Document();
			$category_spec->retrieve_by(
					array('document_key', 'lang_iso'),
					array('artspec-' . $key, $this->cfg->setting->language) // TODO: use section_key
				);
			$objects[$key] = array(
					'title' => $category_spec->get_title(),
					'text' => $category_spec->get_content()
				);
		}

		$title = $this->lng->text('menu:artspec');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_artspec',
				'meta_description' => $this->lng->meta('artspec:description'),
				'meta_keywords' => $this->lng->meta('artspec:keywords'),
				'title' => $title,
				'categories' => $categories,
				'objects' => $objects,
			));

		parent::run_multiple($page_args);
	}

}
?>
