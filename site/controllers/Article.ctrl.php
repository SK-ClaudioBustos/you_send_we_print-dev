<?php
class ArticleCtrl extends CustomCtrl {
	protected $mod = 'Article';

	protected $articles;
	protected $title = '';
	protected $url = '';


	public function run($args = array()) {
		$this->class = ($this->class) ? $this->class : $this->mod;
		$this->mod_key = strtolower($this->mod);

		if (!$action = array_shift($args)) {
			$this->run_default(array(1));
		} else {
			switch ($action) {
				case 'p':		$this->run_default($args); break;
				default:		$this->run_single(false, array($action)); // article key
			}
		}
	}


	protected function run_default($args = [], $action = '') {
		$this->run_multiple($args);
	}


	protected function run_multiple($args = array()) {
		$articles = new Article();
		$articles->set_section_key('article');

		$records_page = 10;
		$record_count = $articles->list_count();

		if (!$page = (int)array_shift($args)) {
			$page = 1;
		}
		$articles->set_paging($page, $records_page, '`date_begin` DESC');

		$title = $this->lng->text('object:multiple');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_article',
				'meta_description' => $this->lng->meta('article:description'),
				'meta_keywords' => $this->lng->meta('article:keywords'),

				'title' => $title,
				'articles' => $articles,
				'record_count' => $record_count,
				'records_page' => $records_page,
				'page' => $page,
			));

		parent::run_multiple($page_args);
	}


	protected function run_single($object, $args = array()) {
		$article_key = $this->get_url_arg($args, '', true);

		$article = new Article();
		$article->retrieve_by(
				array('document_key', 'lang_iso'),
				array($article_key, $this->cfg->setting->language)
			);

		$content = html_entity_decode($article->get_content());
		$page_args = array_merge($args, array(
				'meta_title' => $article->get_title(),
				'body_id' => 'body_article',
				'title' => $article->get_title(),
				'meta_description' => $article->get_meta_description(),
				'meta_keywords' => $article->get_meta_keywords(),

				'date_begin' => $article->get_date_begin(),
				'brief' => $article->get_brief(),
				'content' => $content,
				'source' => $article->get_source_url(),
			));

		parent::run_single($article, $page_args);
	}

}
?>
