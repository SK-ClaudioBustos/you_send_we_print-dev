<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/supplemvc/SMvcApplication.class.php');

// optional libraries
require_once($_SERVER['DOCUMENT_ROOT'] . '/supplemvc/libraries/PhPass/PasswordHash.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/supplemvc/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/supplemvc/libraries/PHPExcel/Classes/PHPExcel_StringBinder.php');


class CustomApp extends SMvcApplication {
	// Override methods
	protected function load_config() {
		switch ($this->setting->domain) {
			case '2018.yousendweprint.com':
			case 'www.2018.yousendweprint.com':
			case '2018t.yousendweprint.com':
			case 'www.2018t.yousendweprint.com':
			case '2020.yousendweprint.com':
			case 'www.2020.yousendweprint.com':
				$this->setting->site = 'YouSendWePrint - Test';
				$this->setting->cookie_prefix = 'yswpt';
				break;
			default:
				$this->setting->site = 'YouSendWePrint';
				$this->setting->cookie_prefix = 'yswp';
		}

		$this->setting->multilanguage = false;
		$this->setting->languages = array('en');
		$this->setting->language = 'en';
		$this->setting->language_default = 'en';

		date_default_timezone_set('America/New_York');

		// minify version - TODO: move to _mainCtrl and get from property
		$this->setting->css_version = '000049';
		$this->setting->script_version = '000049';
		$this->setting->lang_version = '000049';
	}

	protected function init_db() {
		$this->database->connect('yousen5_yousendweprintdev3', 'root', '', 'localhost', 'tbl_');
		// switch ($this->setting->domain) {
		// 	case '2018.yousendweprint.com':
		// 	case 'www.2018.yousendweprint.com':
		// 	case '2018t.yousendweprint.com':
		// 	case 'www.2018t.yousendweprint.com':
		// 	case '2020.yousendweprint.com':
		// 	case 'www.2020.yousendweprint.com':
		// 		$this->database->connect('yousen5_yousendweprint-test', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 		break;
		// 	case 'dev.yousendweprint.com':
		// 	case 'www.dev.yousendweprint.com':
		// 		$this->database->connect('yousen5_yousendweprintDev3', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 		break;
		// 	default:
		// 		$this->database->connect('yousen5_yousendweprint', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// }
	}

}
?>
