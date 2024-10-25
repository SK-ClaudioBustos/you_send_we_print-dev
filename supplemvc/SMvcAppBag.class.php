<?php
class SMvcAppBag extends SMvcPropertyBag {
	private $setting;
	private $lang;


	public function __construct($setting, $lang) {
		$this->setting = $setting;
		$this->lang = $lang;
	}


	public function	go($page_key = false, $language_key = false, $page_args = '') {
		if (!$page_key) {
			$page_key = $this->page_key;
			// if it's the current page, keep the args
			$page_args = ($args = $this->page_args) ? '/' . $args : '';
		}

		if ($this->setting->multilanguage) {
			if (!$language_key) {
				$language_key = $this->setting->language;
			}
			$language = '/' . $language_key;
		} else {
			$language_key = $this->setting->language;
			$language = '';
		}
		if ($url = $this->lang->page_url($page_key, $language_key)) {
			if ($page_key == 'Home') {
				return ($language_key == $this->setting->language_default) ? $this->root : $this->root_lang;
			} else {
				return $this->root . $language . '/' . $url . $page_args;
			}
		} else {
			if ($page_key == 'Home') {
				return ($language_key == $this->setting->language_default) ? $this->root : $this->root_lang;
			} else {
				// echo $page_key . ' [invalid AppBag->go()] '; // <<< Tmp
				error_log('Lang: ' . $language_key . ' | ' . $page_key . ' [invalid AppBag->go()] ');
				return 'Lang: ' . $language_key . ' | ' . $page_key . ' [invalid AppBag->go()] ';
			}
		}
	}

	public function redirect($url, $allow_itself = false) {
		if (($url == $this->app->page_full) && !$allow_itself) {
			error_log('Redirect to itself:' . $url);

		} else if (!$url) {
			error_log('Redirect no url');

		} else {
			header('Location: ' . $url);
			exit;
		}
	}

}
?>