<?php
abstract class SystemCtrl {
	protected $cfg;


	public function __construct() {
		$this->cfg = &CustomApp::$config;
	}


	abstract public function run($params);

}
?>