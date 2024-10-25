<?php
abstract class BaseCtrl {
	protected $cfg;
	protected $lng;
	protected $tpl;
	protected $app;
	protected $utl;
	protected $db;

	protected $id = false;
	protected $object = false;
	protected $error_msg = false;
	protected $success_msg = false;


	public function __construct() {
		$this->cfg = &CustomApp::$config;
		$this->lng = $this->cfg->lang;
		$this->tpl = $this->cfg->template;
		$this->app = $this->cfg->app;
		$this->utl = $this->cfg->util;

		if (CustomApp::$db) {
			$this->db = CustomApp::$db->get_instance();
		} else {
			$this->db = null;
		}
	}


	abstract public function run($params);



	// Transactions

	public function transaction_begin() {
		$this->db->beginTransaction();
	}

	public function transaction_commit() {
		$this->db->commit();
	}

	public function transaction_rollback() {
		$this->db->rollback();
	}


	// Util

	public function missing_fields($error_fields, $error_key = 'FRM_ERR_REQUIRED') {
		$error = array();
		if (sizeof($error_fields)) {
			$error[] = $error_key;
		}
		return $error;
	}

	public function arg_shift(&$args, $default) {
		$arg = array_shift($args);
		return (is_null($arg)) ? $default : $arg;
	}

	protected function set_cookie($name, $value, $expire = 0) { // 0 = expire at the end of the session
		if ($expire === false) {
			$expire = time() + 60 * 60 * 24 * 365; // one year
		}
		setcookie($this->cfg->setting->cookie_prefix . '_' . $name, $value, $expire, '/');
	}

	protected function get_cookie($input, $default, $multibyte = false, $format = false) {
		$full = $this->cfg->setting->cookie_prefix . '_' . $input;

		return $this->get_input($full, $default, false, false, true);
	}

	protected function del_cookie($name) {
		setcookie($this->cfg->setting->cookie_prefix . '_' . $name, '', time()-60*60*24, '/');
	}


	protected function get_url_arg(&$args, $default, $multibyte = false, $format = false) {
		$var = array_shift($args);

		if (is_null($var)) {
			return $default;
		}

		$type = gettype($default);
		$this->set_var($var, $var, $type, $multibyte, $format);

		return $var;
	}

	public function get_input($input, $default, $multibyte = false, $format = false, $cookie = false) {
		// $source = 'request|cookie|url'

		if (!$cookie && isset($_COOKIE[$input])) {
			if (!isset($_GET[$input]) && !isset($_POST[$input])) {
				return (is_array($default)) ? array() : $default;	// <<<<< return
			}
			$_REQUEST[$input] = isset($_POST[$input]) ? $_POST[$input] : $_GET[$input];
		}

		$super_global = ($cookie) ? '_COOKIE' : '_REQUEST';
//error_log(print_r($GLOBALS, true));
		if (!isset($GLOBALS[$super_global][$input]) || is_array($GLOBALS[$super_global][$input]) != is_array($default)) {
			return (is_array($default)) ? array() : $default; 		// <<<<< return
		}

		$var = $GLOBALS[$super_global][$input];
		if (!is_array($default)) {
			$type = gettype($default);

		} else {
			$type = gettype($default[0]);
		}

		if (is_array($var)) {
			$_var = $var;
			$var = array();

			foreach ($_var as $key => $value) {
				$this->set_var($var[$key], $value, $type, $multibyte, $format);
			}

		} else {
			$this->set_var($var, $var, $type, $multibyte, $format);
		}

		return $var;
	}

	protected function set_var(&$result, $var, $type, $multibyte = false, $format = false) {
		settype($var, $type);
		$result = $var;

		if ($type == 'string') {
			$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r"), array("\n", "\n"), $result), ENT_COMPAT, 'UTF-8'));

			if (!empty($result)) {
				// Make sure multibyte characters are wellformed
				if ($multibyte) {
					if (!preg_match('/^./u', $result)) {
						$result = '';
					}
					if ($format) {
						switch ($format) {
							case 'upper': $result = mb_strtoupper($result); break;
							case 'lower': $result = mb_strtolower($result); break;
							case 'caps': $result = mb_convert_case(mb_strtolower($result), MB_CASE_TITLE); break;
						}
					}
				} else {
					// no multibyte, allow only ASCII (0-127)
					$result = preg_replace('/[\x80-\xFF]/', '?', $result);
					if ($format) {
						switch ($format) {
							case 'upper': $result = strtoupper($result); break;
							case 'lower': $result = strtolower($result); break;
							case 'caps': $result = ucwords(strtolower($result)); break;
						}
					}
				}
			}
		}
	}

	public function validate_data($data, $val_ary) {
		$error = array();

		foreach ($val_ary as $var => $val_seq) {
			if (!is_array($val_seq[0])) {
				$val_seq = array($val_seq);
			}

			foreach ($val_seq as $validate) {
				$function = array_shift($validate);
				array_unshift($validate, $data[$var]);
				if ($result = call_user_func_array(array($this, 'validate_' . $function), $validate)) {
					$error[] = $var;
				}
			}
		}
		return $error;
	}

	// Not found

	protected function run_not_found($args = false, $layout = 'default') {
		$title = $this->lng->text('not_found:title');
		$body_id = 'body_not_found';

		$page_args = array(
				'meta_title' => $title,
				'title' => $title,
				'body_id' => $body_id,
			);

		if ($args) {
			$page_args = array_merge($page_args, $args);
		}

		$page_args['body'] = $this->tpl->get_view('_output/not_found', $page_args);
		header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
		$this->tpl->page_draw($page_args, $layout);
	}


	// form token CSRF

	protected function check_form_token($form_key) {
		// false => no tokens, 'low' => one token per user, 'medium' => one token per form type, 'high' one token per form
		$level = $this->app->form_security_level;

		if (!$level) {
			return true;

		} else {
			if ($tokens = (isset($_SESSION['form_tokens'])) ? $_SESSION['form_tokens'] : false) {
				if (isset($tokens[$form_key])) {
					if ($name = $tokens[$form_key]['name']) {
						if ($value = $this->request_var($name, '')) {
							if ($value == $tokens[$form_key]['value']) {
								// it's valid, invalidate it
								unset($_SESSION['form_tokens'][$form_key]);
								return true;
							}
						}

					}
				}
			}
		}

		return false;
	}

	protected function get_form_token($form_key, $max_qty = 5) {
		// false => no tokens, 'low' => one token per user, 'medium' => one token per form type, 'high' one token per form
		$level = $this->app->form_security_level;

		if (!$level) {
			// empty token
			return array('name' => '', 'value' => '');

		} else {
			// create a pair field / value
			$token = array(
					'name' => $this->utl->get_token(12, true),
					'value' => $this->utl->get_token(32),
				);

			// stores up to $max_qty tokens in session
			$tokens = (isset($_SESSION['form_tokens'])) ? $_SESSION['form_tokens'] : array();

			if (sizeof($tokens) > $max_qty) {
				// it's supposed that it will exceed only by one
				array_shift($tokens);
			}

			// add to array
			$tokens[$form_key] = $token;
			$_SESSION['form_tokens'] = $tokens;

			return $token;
		}
	}

	protected function valid_captcha() {
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
				'secret'   => $this->app->captcha_secret,
				'response' => $_POST['g-recaptcha-response'],
				'remoteip' => $_SERVER['REMOTE_ADDR']
			);
		$post_data = http_build_query($data);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
			'Content-Length: ' . strlen($post_data)));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

		$result = curl_exec($curl);
		curl_close($curl);

		return json_decode($result)->success;
	}

	protected function valid_captchaK() {
		try {
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array(
					'secret'   => $this->app->captcha_secret,
					'response' => $_POST['g-recaptcha-response'],
					'remoteip' => $_SERVER['REMOTE_ADDR']
				);

			$options = array(
					'http' => array(
							'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
							'method'  => 'POST',
							'content' => http_build_query($data)
						)
				);

			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
error_log(print_r($data, true));
error_log($result);
			return json_decode($result)->success;

		} catch (Exception $e) {
error_log(print_r($e, true));
			return null;
		}
	}

	protected function get_date($data, $field, &$error_fields) {
		$date = '';
		if ($data[$field]) {
			if ($this->utl->date_valid($data[$field], $this->app->date_format)) {
				$date = $this->utl->date_format($data[$field], false, $this->app->db_date_format, $this->app->date_format);

			} else {
				$error_fields[] = $field;
			}
		}
		return $date;
	}


	// Validate


	/**
	* Validate String
	*
	* @return	boolean|string	Either false if validation succeeded or a string which will be used as the error message (with the variable name appended)
	*/
	protected function validate_string($string, $optional = false, $min = 0, $max = 0) {
		if (empty($string) && $optional) {
			return false;
		}

		if ($min && mb_strlen(htmlspecialchars_decode($string)) < $min) {
			return 'TOO_SHORT';
		} else if ($max && mb_strlen(htmlspecialchars_decode($string)) > $max) {
			return 'TOO_LONG';
		}

		return false;
	}

	/**
	* Validate Number
	*
	* @return	boolean|string	Either false if validation succeeded or a string which will be used as the error message (with the variable name appended)
	*/
	protected function validate_num($num, $optional = false, $min = 0, $max = 1E99) {
		if (empty($num) && $optional) {
			return false;
		}

		if ($num < $min) {
			return 'TOO_SMALL';
		} else if ($num > $max) {
			return 'TOO_LARGE';
		}

		return false;
	}

	/**
	 * Validate Phone Number
	 *
	 * @return	boolean|string	Either false if validation succeeded or a string which will be used as the error message (with the variable name appended)
	*/
	protected function validate_phone($phone, $optional = false) {
		if (empty($phone) && $optional) {
			return false;
		}
		//validation accepts spaces, dashes, and parentheses
		if (!preg_match('/^[0-9\s\-\(\)\+]+$/', $phone)) {
			return 'INVALID_PHONE';
		}

		return false;
	}

	/**
	* Validate Date
	* @param String $string a date in the dd-mm-yyyy format
	* @return	boolean
	*/
	protected function validate_date($date_string, $optional = false) {
		// date/hour
		$date_hour = explode(' ', $date_string);

		// date
		$date = explode('-', $date_hour[0]);

		if ((empty($date) || sizeof($date) != 3) && $optional) {
			return false;

		} else if ($optional) {
			for ($field = 1; $field <= 2; $field++) {
				$date[$field] = (int)$date[$field];
				if (empty($date[$field])) {
					$date[$field] = 1;
				}
			}
			$date[0] = (int)$date[0];
			// assume an arbitrary leap year
			if (empty($date[0])) {
				$date[2] = 1980;
			}
		}
		if (sizeof($date) != 3 || !checkdate($date[1], $date[2], $date[0])) {
			return 'INVALID';
		}

		return false;
	}


	/**
	* Validate Match
	*
	* @return	boolean|string	Either false if validation succeeded or a string which will be used as the error message (with the variable name appended)
	*/
	protected function validate_match($string, $optional = false, $match = '') {
		if (empty($string) && $optional) {
			return false;
		}

		if (empty($match)) {
			return false;
		}

		if (!preg_match($match, $string)) {
			return 'WRONG_DATA';
		}

		return false;
	}


	/**
	* Check to see if email address is banned or already present in the DB
	*
	* @param string $email The email to check
	* @param string $allowed_email An allowed email, default being $user->data['user_email']
	*
	* @return mixed Either false if validation succeeded or a string which will be used as the error message (with the variable name appended)
	*/
	protected function validate_email($email, &$error_fields, &$error, $email_field = 'email') {
		$email_preg = '(?:[a-z0-9\'\.\-_\+\|]|&amp;)+@[a-z0-9\-]+\.(?:[a-z0-9\-]+\.)*[a-z]+';
		if (!in_array($email_field, $error_fields)) {
			if (!preg_match('/^' . $email_preg . '$/i', $email)) {
				$error_fields[] = $email_field;
				$error[] = 'EMAIL_INVALID_EMAIL';
			}
		}
	}

	protected function validate_cuit($cuit, &$error_fields, &$error, $cuit_field = 'cuit') {
		$cuit = substr_replace($cuit, '-', 2, 0);
		$cuit = substr_replace($cuit, '-', -1, 0);

		if (!CuitValidator::isValid($cuit)) {
			$error_fields[] = $cuit_field;
			if (!in_array('CUIT_INVALID_CUIT', $error_fields)) {
				$error[] = 'CUIT_INVALID_CUIT';
			}
		}
	}

	protected function validate_cbu($cbu, &$error_fields, &$error, $cbu_field = 'cbu') {
		if (!Cbu::isValid($cbu)) {
			$error_fields[] = $cbu_field;
			if (!in_array('CBU_INVALID_CBU', $error_fields)) {
				$error[] = 'CBU_INVALID_CBU';
			}
		}
	}


}
?>