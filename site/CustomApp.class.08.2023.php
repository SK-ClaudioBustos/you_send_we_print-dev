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
		/*switch ($this->setting->domain) {
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
		}*/
		$this->setting->site = 'YouSendWePrint';
		//$this->setting->cookie_prefix = 'yswp';

		$this->setting->multilanguage = false;
		$this->setting->languages = array('en');
		$this->setting->language = 'en';
		$this->setting->language_default = 'en';

		// minify version
		$this->setting->css_version = '000306';
		$this->setting->script_version = '000306';
		$this->setting->lang_version = '000306';

		// img extensions
		$this->setting->upl_extensions = 'jpg|jpeg|pdf|png';
		$this->setting->img_extensions = 'jpg|png|gif|tif|webp';
		$this->setting->img_filter = '*.jpg';
		$this->setting->img_filter_text = 'JPG Files (*.jpg)';

		$this->setting->cookie_prefix = 'yswp';

		date_default_timezone_set('America/New_York');

		/*switch ($this->setting->domain) {
			case '2018.yousendweprint.com':
			case 'www.2018.yousendweprint.com':
			case '2018t.yousendweprint.com':
			case 'www.2018t.yousendweprint.com':
				$this->setting->blixflow = 'http://test.blixflow.com';
				break;
			default:
				$this->setting->blixflow = 'http://www.blixflow.com';
				break;
		}*/
		$this->setting->blixflow = 'http://www.blixflow.com';
	}

	protected function set_url_folders() {
		parent::set_url_folders();
		$this->url->backoffice = '/adminx';
	}

	protected function init_db() {
		switch ($this->setting->domain) {
			case '2018.yousendweprint.com':
			case 'www.2018.yousendweprint.com':
			case '2018t.yousendweprint.com':
			case 'www.2018t.yousendweprint.com':
			case '2020.yousendweprint.com':
			case 'www.2020.yousendweprint.com':
			    $this->database->connect('yousen5_yousendweprint-test', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
			    break;
			case 'dev.yousendweprint.com':
			case 'www.dev.yousendweprint.com':
			    $this->database->connect('yousen5_yousendweprintDev', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
			    break;
			default:
				$this->database->connect('yousen5_yousendweprint', 'yousen5_blix', 'fH4mwR8p', 'localhost', 'tbl_');
		}
	}

}
