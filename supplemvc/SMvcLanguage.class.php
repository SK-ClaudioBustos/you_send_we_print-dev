<?php
class SMvcLanguage {
	private $setting;

	private $lang_texts = array();
	private $lang_metas = array();
	private $lang_modules = array();

	private $lang_iso;
	private $lang_root;
	private $lang_mods_lang;


	// constructor

	public function __construct($lang_root, $setting) {
		$this->setting = $setting;
		$this->lang_root = $lang_root;
		$this->lang_iso = $setting->language;
		$this->load_modules();
	}


	// property set

	public function set_lang_iso($value) { $this->lang_iso = $value; }


	// property get

	public function get_lang_iso() { return $this->lang_iso; }
	public function get_lang_texts() { return $this->lang_texts; }
	public function get_lang_metas() { return $this->lang_metas; }


	// methods

	public function add_lang($module) {
		$file = $this->lang_root . '/' . $this->lang_iso . '/' . strtolower($module) . '.lang.php';
		if ((@include $file) !== false) {
			$this->lang_texts = array_merge($this->lang_texts, $lang_module);
			$this->lang_metas = array_merge($this->lang_metas, $meta_module);
		}
	}

	public function meta($key, $return_key = true ) {
		return (!empty($this->lang_metas[$key])) ? $this->lang_metas[$key] : (($return_key) ? '{' . $key . '}' : '');
	}

	public function text() {
		$args = func_get_args();
		$key = array_shift($args);

		if (empty($this->lang_texts[$key])) {
			return '{' . ((strlen($key) > 12) ? substr($key, 0, 11) . '&raquo;}' : $key . '}');

		} else if (sizeof($args) > 0) {
			eval('$return = sprintf($this->lang_texts[$key], "' . implode('", "', $args) . '");');
			return $return;

		} else {
			return $this->lang_texts[$key];
		}
	}


	public function all() {
		return $this->lang_texts;
	}


	// module management

	public function load_modules() {
		$file = $this->lang_root . '/' . $this->lang_iso . '/' . '_mods.lang.php';
//echo $file;
//exit;
		if ((@include $file) !== false) {
			$this->lang_modules = $lang_mods;
		}

		if ($this->setting->multilanguage) {
			// Load all lang mods for translation
			foreach($this->setting->languages as $lang)	{
				$file = $this->lang_root . '/' . $lang . '/' . '_mods.lang.php';
				$lang_mod = array();

				if ((@include $file) !== false) {
					foreach($lang_mods as $lang_key => $key) {
						if (is_array($key)) {
							$key = implode('/', $key);
						}
						$lang_mod[$key] = $lang_key;
					}
				}
				$this->lang_mods_lang[$lang] = $lang_mod;
			}
		} else {
			$lang_mod = array();
			foreach($lang_mods as $lang_key => $key) {
				if (is_array($key)) {
					$key = implode('/', $key);
				}
				$lang_mod[$key] = $lang_key;
			}
			$this->lang_mods_lang[$this->lang_iso] = $lang_mod;
		}
	}

	public function safe_module($module) {
		if (array_key_exists($module, $this->lang_modules)) {
			return $this->lang_modules[$module];
		}
		return false;
	}

	public function page_url($page_key, $language_key) {
		if (in_array($language_key, $this->setting->languages)
				&& array_key_exists($page_key, $this->lang_mods_lang[$language_key])) {
			return $this->lang_mods_lang[$language_key][$page_key];

		} else {
			return false;
		}
	}
}
?>
