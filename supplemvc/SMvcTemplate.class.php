<?php
class SMvcTemplate {
	private $cfg;


	public function __construct() {
		$this->cfg = &CustomApp::$config;
	}



	public function get_css($module_key = false) {
		return $this->cfg->app->root_lang . '/css' . (($module_key) ? '/' . strtolower($module_key) : '') . '/' . $this->cfg->setting->css_version . '.css';
	}

	public function get_script($module_key = false) {
		return $this->cfg->app->root_lang . '/script' . (($module_key) ? '/' . strtolower($module_key) : '') . '/' . $this->cfg->setting->script_version . '.js';
	}

	public function get_lang($module_key = false) {
		return $this->cfg->app->root_lang . '/lang' . (($module_key) ? '/' . strtolower($module_key) : '') . '/' . $this->cfg->setting->lang_version . '.js';
	}

	public function get_img($module_key = false) {
	}



	public function get_view($view, $vars = array(), $return_array = false) {
		if (file_exists($path = $this->cfg->path->views . '/' . $this->cfg->setting->viewtype . '/' . $view . '.view.php')) {
			ob_start();

			// Template, Language and Config
			$tpl = $this;
			$cfg = $this->cfg;
			$lng = $this->cfg->lang;
			$app = $this->cfg->app;
			$utl = $this->cfg->util;

			// Load variables
			if (is_array($vars)) {
				foreach ($vars as $key => $value) {
					$$key = $value;
				}
			}
			include ($path);

			$html = ob_get_clean();

			// look for sub views
			$doc = new DOMDocument();
			@$doc->loadHTML('<?xml encoding="UTF-8">' . $html);

			$tags = $doc->getElementsByTagName('view');
			$views = array();
			foreach ($tags as $tag) {
				$views[$tag->getAttribute('key')] = $this->get_node($tag);
			}

			if (sizeof($views)) {
				return $views;

			} else if($return_array) {
				return array('body' => $html);

			} else {
				return $html;
			}

		} else {
			error_log('>>> SUPPLEMVC [View doesnt exist]' . $path);
			return false;
		}
	}

	public function page_draw($args, $layout = 'default') {
		//  if ( extension_loaded( 'zlib' ) AND (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) ) {
	    	// ob_start('ob_gzhandler');
	    // }

    	$success_msg = $error_msg = '';

		if (isset($_SESSION['error_msg'])) {
			$error_msg = $_SESSION['error_msg'];
			unset($_SESSION['error_msg']);
		}
		if (isset($_SESSION['success_msg'])) {
			$success_msg = $_SESSION['success_msg'];
			unset($_SESSION['success_msg']);
		}

		// defaults
		$page_args = array(
				'body_id' => '',
				'meta_title' => '',
				'meta_description' => '',
				'meta_keywords' => '',
				'error_msg' => $error_msg,
				'success_msg' => $success_msg
			);

		// override
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}

		header('Content-type: text/html; charset=UTF-8');
		header('Cache-Control: no-cache, max-age=604800');
		echo $this->get_view('_layouts/' . $layout, $page_args);
	}


	protected function file_get_contents_utf8($fn) {
		$content = file_get_contents($fn);
		return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
	}

	private function get_node($node){
		if ($value = $node->getAttribute('value')) {
			 return trim(html_entity_decode($value, ENT_NOQUOTES, 'UTF-8'), "/ \t\n\r\0\x0B");
		} else {
			$doc = new DOMDocument();

			foreach ($node->childNodes as $child) {
				$doc->appendChild($doc->importNode($child, true));
			}
			return html_entity_decode($doc->saveHTML(), ENT_NOQUOTES, 'UTF-8');
		}
	}

}
?>