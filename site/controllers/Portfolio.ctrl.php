<?php
class PortfolioCtrl extends CustomCtrl {
	protected $mod = 'Portfolio';


	protected function run_default($args = array(), $action) {
		switch ($action) {
			case 'ajax_gallery':	$this->run_ajax_gallery($args); break;

			case 'canvas':			$this->canvas($args); break;

			default:				$this->run_multiple($args);

		}
	}

	protected function run_ajax_gallery($args) {
		if ($group_id = $this->get_input('group_id', 0)) {

			// get image list
			$path = $this->cfg->path->data . '/portfolio/' . sprintf('%06d', $group_id) . '/';
			$url = '/image/portfolio/' . sprintf('%06d', $group_id) . '/0/';

			$gallery = array();
			if (is_dir($path)) {
				$images = scandir($path);

				foreach ($images as $image) {
					if ($image != '.' && $image != '..' && is_file($path . '/' . $image)) {
						$gallery[] = array(
								'src' => $url . $image,
							);
					}
				}
			}

			header("Content-type: application/json");
			echo stripslashes(json_encode($gallery));
		}
	}

	protected function run_multiple($args = []) {
		$title = $this->lng->text('menu:portfolio');
		$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_portfolio',
				'meta_description' => $this->lng->meta('portfolio:description'),
				'meta_keywords' => $this->lng->meta('portfolio:keywords'),
				'title' => $title,
			));

		parent::run_multiple($page_args);
	}

	protected function canvas($args) {
		$title = $this->lng->text('menu:canvas');
		$page_args = array_merge($args, array(
			'meta_title' => $title,
			'title' => $title,
			'body_id' => 'body_canvas',
			'meta_description' => $this->lng->meta('faq:portfolio'),
			'meta_keywords' => $this->lng->meta('faq:portfolio'),
			'username' => $user = $this->app->user->get_username()
		));
		$page_args = array_merge($page_args, $this->tpl->get_view('portfolio/canvas', $page_args));
		$this->tpl->page_draw($page_args);
	}

	protected function run_single($object, $args = array()) {
		$section = array_shift($args);
		$group_key = array_shift($args);

		$title = $this->app->menu_groups[$section][$group_key];

		$groups = $this->app->menu_groups;
		$items = $this->app->menu_items[$section][$group_key];

		if (!$product_key = array_shift($args)) {
			$product_keys = array_keys($items);
			$product_key = $product_keys[0];
		}
		$product = $items[$product_key];

		$body = $this->tpl->get_view('portfolio/portfolio', array(
				'title' => $title,
				'groups' => $groups,
				'items' => $items,
				'section' => $section,
				'group_key' => $group_key,
				'product_key' => $product_key,
				'product' => $product,
			));

		$this->tpl->page_draw(array(
				'meta_title' => $this->lng->text('menu:portfolio'),
				'body' => $body,
				'body_id' => 'body_portfolio',
				'meta_description' => $this->lng->meta('faq:portfolio'),
				'meta_keywords' => $this->lng->meta('faq:portfolio'),
			));
	}

}
?>