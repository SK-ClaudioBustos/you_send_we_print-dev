<?php
require_once('supplemvc/SMvcApplication.class.php');

require_once('supplemvc/libraries/PhPass/PasswordHash.php');
require_once('supplemvc/libraries/UrlSlug/url_slug.php');
require_once('site/libraries/RocketShipIt/ups/RocketShipIt.php');
require_once('site/libraries/ShipEngine/ShipEngine.php');
require_once('site/libraries/MobileDetect/Mobile_Detect.php');

require_once('parameters.php');


class CustomApp extends SMvcApplication {
	// Override methods
	protected function load_config() {
		$this->setting->site = 'YouSendWePrint';

		$this->setting->multilanguage = false;
		$this->setting->languages = array('en');
		$this->setting->language = 'en';
		$this->setting->language_default = 'en';

		// minify version
		$this->setting->css_version = '000338';
		$this->setting->script_version = '000338';
		$this->setting->lang_version = '000338';

		// img extensions
		$this->setting->upl_extensions = 'jpg|jpeg|pdf|png|ai';
		$this->setting->img_extensions = 'jpg|png|gif|tif|webp|ai';
		$this->setting->img_filter = '*.jpg';
		$this->setting->img_filter_text = 'JPG Files (*.jpg)';

		$this->setting->cookie_prefix = 'yswp';

		date_default_timezone_set('America/New_York');

		$this->setting->blixflow = 'http://www.blixflow.com';
	}

	protected function set_url_folders() {
		parent::set_url_folders();
		$this->url->backoffice = '/adminx';
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
		// 	    $this->database->connect('yousen5_yousendweprint-test', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 	    break;
		// 	case 'dev.yousendweprint.com':
		// 	case 'www.dev.yousendweprint.com':
		// 	   // $this->database->connect('yousen5_yousendweprintDev', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 		$this->database->connect('yousen5_yousendweprintDev3', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		// 	    break;
		// 	default:
		// 		$this->database->connect('yousen5_yousendweprint', 'root', '', 'localhost', 'tbl_');
		// }
	}

}

?>
