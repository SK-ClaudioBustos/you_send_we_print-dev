<?php
class HomeCtrl extends CustomCtrl {

	protected function run_default($args, $action = '') {
		$page_args = array(
				//'meta_title' => $title,
				'meta_title' => 'AdminX',
				'title' => '&nbsp;',
				//'body_id' => $body_id,
				'body_id' => 'home_adminx',
			);

		$page_args = array_merge($page_args, $this->tpl->get_view('home/home', $page_args));
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}
		$this->tpl->page_draw($page_args);
	}

}
?>