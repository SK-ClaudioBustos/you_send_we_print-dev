<?php
// ADMINX /////////////////////////////////////////////////////////////////////////

include ('../supplemvc/SMvcApplication.class.php');
// <Include here function files (function classes are prefered)>

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

		// minify version
		$this->setting->css_version = '000011';
		$this->setting->script_version = '000011';
		$this->setting->lang_version = '000011';

		$this->setting->cookie_prefix = 'blx';

		$this->setting->date_format = 'm/d/Y';
	}

	protected function init_db() {
		$this->database->connect('yousen5_yousendweprintdev3', 'root', '', 'localhost', 'tbl_');
		// switch ($this->setting->domain) {
		// 	case 'test.yousendweprint.com':
		// 	case 'www.test.yousendweprint.com':
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
		// 		$this->database->connect('yousen5_yousendweprintDev', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 		break;
		// 	default:
		// 		$this->database->connect('yousen5_yousendweprint', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// }
	}

	protected function set_url_folders() {
		parent::set_url_folders();

		$this->url->tinymce_folder = $this->app_folder . '/scripts/tiny_mce_3.5.0.1';
	}
}
?>
