<?php
class SMvcPath {
	private $root;
	private $app;
	private $folders = array();


	public function __set($index, $value) {
		if ($index == 'root') {
			$this->root = $value;
		} else if ($index == 'app') {
			$this->app = $value;
		} else {
			$this->folders[$index] = $value;
		}
	}

	public function __get($index) {
		if ($index == 'root') {
			return $this->root;
		} else if ($index == 'app') {
			return $this->app;
		} else if (array_key_exists($index, $this->folders)) {
			return $this->root . $this->folders[$index];
		} else {
			return '';
		}
	}
}
?>