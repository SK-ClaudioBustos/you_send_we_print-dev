<?php
abstract class SMvcApplication {
	public static $config;
	public static $db;

	protected $app_folder = ''; 	// real folder where the app is located
	protected $app_root = '';		// real folder where the index is located
	protected $root_level = 0;		//

	protected $setting;
	protected $path;
	protected $url;
	protected $util;

	protected $database;
	protected $language;
	protected $template;

	protected $request_uri;
	protected $params;
	protected $page_args = array();

	protected $module_key;
	protected $page_key;

	protected $debug;

	protected $system_mods = array('Image', 'Image2', 'Css', 'Script', 'Lang');
	protected $minify_mods = array('Css', 'Script');


	public function __construct($app_folder, $debug = false) {
		mb_internal_encoding('UTF-8');

		$this->load_libs();

		// class loaders
		spl_autoload_register(array($this, 'loader_system'));
		spl_autoload_register(array($this, 'loader_base'));
		spl_autoload_register(array($this, 'loader_custom'));
		spl_autoload_register(array($this, 'loader_mailer'));
		spl_autoload_register(array($this, 'loader_user'));

		$this->debug = $debug;

		// settings urls and paths
		$this->setting = new SMvcPropertyBag();

		$this->set_domain();
		$this->load_config();

		$this->app_folder = $app_folder;
		$this->path = new SMvcPath();
		$this->set_path_root();
		$this->set_path_folders();

		$this->url = new SMvcPath();
		$this->set_url_root();
		$this->set_url_folders();

		$this->app_root = $this->get_app_root();

		// parsing
		$this->parse_params();
		$this->parse_language();
		$this->language = new SMvcLanguage($this->path->language, $this->setting);

		$this->init_viewtype();
		$this->parse_module();

		// static config
		self::$config = new SMvcPropertyBag();

		self::$config->setting = $this->setting;
		self::$config->app_folder = $this->app_folder;
		self::$config->path = $this->path;
		self::$config->url = $this->url;
		self::$config->lang = $this->language;

		$this->util = new SMvcUtil();
		self::$config->util = $this->util;

		if (!in_array($this->module_key, $this->system_mods) || $this->module_key == 'Lang') {

			// init application
			$lang = ($this->setting->multilanguage) ? '/' . $this->setting->language : '';
			$app = new SMvcAppBag($this->setting, $this->language);

			$app->root = $this->app_root;
			$app->root_lang = $app->root . $lang;

			// util app vars
			$app->page = $this->request_uri;
			$app->page_lang = $lang . $app->page;
			$app->page_full = $app->root_lang . $app->page;
			$app->page_key = $this->page_key;
			$app->page_args = implode('/', $this->page_args);
			$app->module_key = $this->module_key;

			self::$config->app = $app;

			$template = new SMvcTemplate();
			self::$config->template = $template;

			if ($this->module_key == 'Lang') {
				// lang controller
				if ($arg = array_shift($this->page_args)) {
					$arg = explode('.', $arg);
					$arg = $arg[0];
					if (is_numeric($arg)) {
						$this->language->add_lang('_main');
					} else {
						$this->language->add_lang($arg);
					}
				} else {
					$this->language->add_lang('_main');
				}

			} else {
				// other app controller
				$this->language->add_lang('_main');

				$this->database = new SMvcDatabase();
				$this->init_db();
				self::$db = $this->database; // null if no db is used

				// Main controller, if it exists
				if ($controller = $this->get_controller(true)) {
					$controller->run($this->params);
				}
			}

		}

		if (in_array($this->module_key, $this->minify_mods)) {
			$this->init_minify();
		}

		// Module
		$controller = $this->get_controller();
		$controller->run($this->params);
	}


	// Private Methods --------------------------------------------------------

	// Parameters
	private function parse_params() {
		// remove first / and last / if exist
		$params = trim($_SERVER['REQUEST_URI'], "/ \t\n\r\0\x0B");
		$params = ($params) ? explode('/', $params) : array();

		// remove folders from the root
		for ($level = 1; $level <= $this->root_level; $level++) {
			array_shift($params);
		}
		$this->params = $params;
	}

	private function parse_language() {
		$this->setting->language = $this->setting->language_default;

		if ($this->setting->multilanguage) {
			if (!sizeof($this->params)) {
				// home, do nothing

			} else {
				$language_key = array_shift($this->params);
				if (in_array($language_key, $this->setting->languages)) {
					$this->setting->language = $language_key;
					$this->request_uri = (sizeof($this->params)) ? '/' . implode('/', $this->params) : '';
				} else if ($language_key == 'image') {
					// special case, image could not have language
					$this->request_uri = '/image' . ((sizeof($this->params)) ? '/' . implode('/', $this->params) : '');
					array_unshift($this->params, 'image');
				} else {
					// invalid language
					$this->request_uri = (sizeof($this->params)) ? '/' . implode('/', $this->params) : '';
					$this->params = array('invalid_language', 'not_found');
				}
			}
		} else {
			$this->request_uri = (sizeof($this->params)) ? '/' . implode('/', $this->params) : '';
		}
	}

	private function parse_module() {
		$module_lang = array_shift($this->params);

		$this->page_args = $this->params;
		switch ($module_lang) {
			case false:
			case 'invalid_language':
				$page_key = 'Home';
				$module_key = 'Home';
				break;

			case 'image':
				$page_key = '';
				$module_key = 'Image';
				break;

			case 'css':
				$page_key = '';
				$module_key = 'Css';
				break;

			case 'script':
				$page_key = '';
				$module_key = 'Script';
				break;

			case 'lang':
				$page_key = '';
				$module_key = 'Lang';
				break;

			default:
				if (!$page_key = $this->language->safe_module($module_lang)) {
					// invalid/not_found
					$this->error_log('[Wrong module_key] ' . $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['REQUEST_URI']);
					$page_key = 'Home';
					$module_key = 'Home';
					$this->params = array('not_found');

				} else if (strpos($page_key, '/') !== false) {
					$module_key = explode('/', $page_key);
					list($module_key, $param) = $module_key;
					array_unshift($this->params, $param);

				} else {
					$module_key = $page_key;

				}
		}

		$this->page_key = $page_key;
		$this->module_key = $module_key;

		if (!$module_key) {
			$this->error_log('[Missing module_key] ' . $_SERVER['REQUEST_URI']);
			header('Location: /');
			exit;
		}
	}


	// Controller
	private function get_controller($main = false) {
		if ($main) {
			// main control
			$module_key = 'Main';
			$file = $this->path->controllers . '/_Main.ctrl.php';

		} else {
			// other controller
			$module_key = $this->module_key;
			if (in_array($module_key, $this->system_mods)) {
				$file = $this->path->supplemvc . '/controllers/' . $module_key . '.ctrl.php';
			} else {
				$file = $this->path->controllers . '/' . $module_key . '.ctrl.php';
			}
		}

		if (file_exists($file)) {
			require_once($file);
			$class = $module_key . 'Ctrl';
			$controller = new $class();

			$this->language->add_lang($module_key);

			return $controller;

		} else {
			if ($main) {
				return false;

			} else {
				$this->error_log($file . ' [Controller Not found] ' . $_SERVER['REQUEST_URI']);
				header('Location: /');
				exit;
			}
		}
	}


	private function error_log($error) {
		if ($this->debug) {
			error_log('>>> SUPPLEMVC ' . $error);
		}
	}

	// Class Loaders
	private function loader_system($class_name) {
		$path = dirname(__FILE__);
		if (substr($class_name, 0, 4) == 'SMvc' && file_exists($file = $path . '/' . $class_name . '.class.php')) {
			require_once $file;
		}
	}

	private function loader_base($class_name) {
		$path = dirname(__FILE__);
		if (file_exists($file = $path . '/base/' . $class_name . '.class.php')) {
			require_once $file;
		}
	}

	private function loader_custom($class_name) {
		if (substr($class_name, 0, 6) == 'Custom') {
			switch (substr($class_name, 6)) {
				case 'Class':	$file = $this->path->model . '/_Custom.class.php'; break;
				case 'Db':		$file = $this->path->model . '/_CustomDb.class.php'; break;
				case 'Ctrl':	$file = $this->path->controllers . '/_Custom.ctrl.php'; break;
			}
			if (file_exists($file)) {
				include_once $file;
			}
		}
	}

	private function loader_mailer($class_name) {
		if (in_array($class_name, array('PHPMailer', 'SMTP', 'POP3'))) {
			if (file_exists($file = $this->path->mailer . '/class.' . strtolower($class_name) . '.php')) {
				include_once $file;
			}
		}
	}

	private function loader_user($class_name) {
		$folder = (substr($class_name, -2, 2) == 'Db') ? $this->path->modeldb : $this->path->model;
		if (file_exists($file = $folder . '/' . $class_name . '.class.php')) {
			include_once $file;
		} else {
			$this->error_log('[Class not found]' . $file);
		}
	}


	// Public Methods --------------------------------------------------------------------



	// Overridable Methods ---------------------------------------------------------------

	// Domain
	protected function set_domain() {
		$this->setting->domain = $_SERVER['HTTP_HOST'];
	}

	// Libs
	protected function load_libs() {

	}

	// App Config
	protected function load_config() {
		$this->setting->site = 'Site Name';

		$this->setting->multilanguage = false;
		$this->setting->languages = array('en');
		$this->setting->language_default = 'en';
	}


	// App root (where index.php is located)
	protected function get_app_root() {
		$protocol = (!isset($_SERVER['HTTPS'])) ? 'http' : ($_SERVER['HTTPS'] ? 'https' : 'http');
		$this->setting->protocol = $protocol;
		$folder = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
		$this->root_level = substr_count($folder, '/'); // - 1; //<< TODO: HostDeal requiere -1
		return $protocol . '://' . $_SERVER['HTTP_HOST'] . $folder;
	}


	// App paths
	protected function set_path_root() {
		$this->path->root = $_SERVER['DOCUMENT_ROOT'];
	}

	protected function set_path_folders() {
		$this->path->supplemvc = '/supplemvc';

		$this->path->lib = '/supplemvc/libraries';
		$this->path->mailer = '/supplemvc/libraries/PHPMailer';

		$this->path->model = '/model';
		$this->path->modeldb = '/modeldb';
		$this->path->includes = '/includes';
		$this->path->util = '/util';
		$this->path->data = '/data';

		$this->path->cache = $this->app_folder . '/cache';
		$this->path->scripts = $this->app_folder . '/scripts';
		$this->path->language = $this->app_folder . '/language';
		$this->path->controllers = $this->app_folder . '/controllers';
		$this->path->views = $this->app_folder . '/views';
		$this->path->style = $this->app_folder . '/style';
	}


	// App urls
	protected function set_url_root() {
		$protocol = (!isset($_SERVER['HTTPS'])) ? 'http' : ($_SERVER['HTTPS'] ? 'https' : 'http');
		$this->url->root = $protocol . '://' . $_SERVER['HTTP_HOST'];
	}

	protected function set_url_folders() {
		$this->url->index = 'index.php';
		$this->url->data = '/data';

		$this->url->scripts = $this->app_folder . '/scripts';
		$this->url->images = $this->app_folder . '/images';
		$this->url->views = $this->app_folder . '/views';

		$this->url->phpThumb = '/supplemvc/libraries/phpThumb';
	}

	// App Objects

	protected function init_db() {
	}

	protected function init_viewtype() {
		$this->setting->viewtype = 'default';
	}

	protected function init_minify() {
		// include utility class for verifying missing files
		require_once($this->path->supplemvc . '/libraries/RelativePath/RelativePath.php');

		// minify
		$path = $this->path->supplemvc . '/libraries/Minify';
		set_include_path($path . PATH_SEPARATOR . get_include_path());
		require_once('Minify.php');
		Minify::setCache(realpath($path . '/cache'), true);
	}

}
?>
