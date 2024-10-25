<?php
class FaqCtrl extends CustomCtrl {
	protected $mod = 'Faq';
	protected $class = 'Document';


	protected function run_default($args = array(), $action = [] ) {
		$this->run_multiple($args);
	}


	protected function run_multiple($args = array()) {
		$categories = $this->utl->get_property('faq_categories', array());

		$objects = array();
		foreach ($categories as $key => $value) {
			$category_faq = new Document();
			$filter = array(
					"`section_key` = ?",
					"`category_key` = ?",
				);
			$values = array('faq', $key);
			$category_faq->set_paging(1, 0, '`order` ASC', $filter, $values);

			$objects[$key] = $category_faq;
		}

		$title = $this->lng->text('menu:faq');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_faq',
				'meta_description' => $this->lng->meta('faq:description'),
				'meta_keywords' => $this->lng->meta('faq:keywords'),
				'title' => $title,
				'categories' => $categories,
				'objects' => $objects,
			));

		parent::run_multiple($page_args);
	}

}
?>
