<?php
class SitemapCtrl extends CustomCtrl {
	protected $mod = 'Sitemap';


	protected function run_default($args = array(), $action) {
		switch ($action) {
			default:				$this->run_multiple($args);
		}
	}


	protected function run_multiple($args = []) {
		$title = $this->lng->text('menu:sitemap');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_sitemap',
				'meta_description' => $this->lng->meta('sitemap:description'),
				'meta_keywords' => $this->lng->meta('sitemap:keywords'),
				'title' => $title,
			));

		parent::run_multiple($page_args);
	}

}
?>