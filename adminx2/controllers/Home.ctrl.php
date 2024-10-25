<?php
class HomeCtrl extends BaseCtrl {
	protected $mod = 'Home';


	public function run($args) {
		$action = array_shift($args);
		switch ($action) {
			case 'logout': 	$this->run_logout($args); break;
			case 'login': 	$this->run_login($args); break;

			default: 		$this->run_default($args);
		}
	}


	private function run_default($args) {
		$body = $this->tpl->get_view('home/home');
		$this->tpl->page_draw(array('body' => $body));
	}


	private function run_logout($args) {
		session_destroy();
		header('Location: /');
		exit;
	}
}
?>