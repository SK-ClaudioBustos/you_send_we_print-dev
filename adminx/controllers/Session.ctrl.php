<?php
class SessionCtrl extends CustomCtrl {

	public function run($args = []) {
		$action = array_shift($args);
		switch ($action) {
			case 'confirm': 	$this->run_login($args, true); break;
			case 'signup': 		$this->run_signup($args); break;
			case 'remember': 	$this->run_remember($args); break;
			case 'remind': 		$this->run_remind($args); break;
			case 'reset': 		$this->run_reset($args); break;
			case 'logout': 		$this->run_logout($args); break;
			case 'login_rmb': 	$this->run_login_rmb($args); break;

			default: 			$this->run_login($args);
		}
	}


	protected function run_login($args, $captcha = false) {
		if ($this->get_input('action', '') == 'login') {
			// save
			//$this->login_save($user, $activation_key);

		} else {

			$title = '';
			$body_id = 'body_enter';

			if (isset($_SESSION['login_var'])) {
				$login_var = $_SESSION['login_var'];
				unset($_SESSION['login_var']);

				if ($signup = isset($login_var['signup'])) {
					 // signup
					$object = unserialize($login_var['signup_obj']);
					unset($login_var['signup_obj']);

				} else {
					$object = new User();
				}
			} else {
				$object = new User();
			}

			$publickey = '';
			if ($captcha) {
				$publickey = $this->app->captcha_public;
			}

			$countries = new Country();
			$countries->set_paging(1, 0, '`country` ASC');

			$login_token = $this->get_form_token('login');
			$signup_token = $this->get_form_token('signup');
			$remind_token = $this->get_form_token('remind');

			$page_args = array(
					'meta_title' => $title,
					'title' => $title,
					'body_id' => $body_id,
					'login_token' => $login_token,
					'signup_token' => $signup_token,
					'remind_token' => $remind_token,
					'publickey' => $publickey,
					'countries' => $countries,
					'signup' => $signup,
					'object' => $object,
					'login_var' => $login_var,
				);
			$views = array_merge($page_args, $this->tpl->get_view('session/login', $page_args));
			$this->tpl->page_draw($views, 'enter');
		}
	}

	protected function run_logout($args) {
		if ($user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])]) {
			// remove all 'remember' sessions
			$session = new Session();
			$session->delete_by('user_id', $user_id);
		}

		// invalidate 'remember' cookies
		if ($k = $this->get_cookie('k', '')) {
		   $this->del_cookie('k');
		}

		// restart session
		session_destroy();
		session_start();

		header('Location: /'); // . $this->app->go('Session/login'));
		exit;
	}

	protected function run_login_rmb($args) {
		if ($this->get_input('action', '') == 'login_rmb') {
			$this->run_login_rmb_save($args);

		} else {
			$title = '';
			$body_id = 'body_login_rmb';
			$target = $_SESSION['session_target'];

			if (isset($_SESSION['login_var'])) {
				$login_var = $_SESSION['login_var'];
				unset($_SESSION['login_var']);
			}

			$page_args = array(
					'meta_title' => $title,
					'title' => $title,
					'body_id' => $body_id,
					'target' => $target,
					'login_var' => $login_var,
				);

			$views = array_merge($page_args, $this->tpl->get_view('session/login_rmb', $page_args));
			$this->tpl->page_draw($views, 'enter');
		}
	}

	protected function run_login_rmb_save($args) {
		$data = array(
				'username'			=> $this->get_input('username', '', true, 'lower'),
				'password'			=> $this->get_input('password', '', true),
				'target'			=> $this->get_input('target', '', true),
			);

		// validate required
		$error_fields = $this->validate_data($data, array(
				'username'	=> array('string', false, 1, 20),
				'password'	=> array('string', false, 1, 20),
			));

		$error = $this->missing_fields($error_fields);

		// validate current pw
		$user = new User();
		if ($user->login($data['username'], $data['password'], $_SERVER['REMOTE_ADDR'])) {
			// login ok, remove $_SESSION['logged_by_remember']
			unset($_SESSION['logged_by_remember']);

		} else {
			$error[] = $this->lng->text('ERROR:FAIL');
		}

		if (sizeof($error)) {
			$_SESSION['error_msg'] = $this->lng->text('ERROR:FAIL');
		}

		$this->app->redirect($data['target']);
	}

	protected function run_reset($args) {
		if ($activation_key = array_shift($args)) {

			$user = new User();
			if ($user->retrieve_by_activation_key(array($activation_key, date('Y-m-d H:i:s')))) {
				// key is valid

				if ($this->get_input('action', '') == 'reset') {
					// save
					$this->reset_save($user, $activation_key);

				} else {
					// show reset form
					$title = '';
					$body_id = 'body_reset';

					if (isset($_SESSION['login_var'])) {
						$login_var = $_SESSION['login_var'];
						unset($_SESSION['login_var']);
					}

					$token = $this->get_form_token('reset');
					$username = ($this->app->user_show_username_on_reset) ? $user->get_username() : '';

					$page_args = array(
							'meta_title' => $title,
							'title' => $title,
							'body_id' => $body_id,
							'token' => $token,
							'username' => $username,
							'activation_key' => $activation_key,
							'login_var' => $login_var,
						);
					$views = array_merge($page_args, $this->tpl->get_view('session/reset', $page_args));
					$this->tpl->page_draw($views, 'enter');
				}

			} else {
				// invalid key
				$_SESSION['login_var'] = array(
						'alert' => 'danger',
						'msg' => $this->lng->text('ERROR:RESET_INVALID_KEY'),
					);
				header('Location: ' . $this->app->go('Session/login'));
				exit;
			}

		} else {
			// no activation key
			$_SESSION['login_var'] = array(
					'alert' => 'danger',
					'msg' => $this->lng->text('ERROR:RESET_INVALID_KEY'),
				);
			header('Location: ' . $this->app->go('Session/login'));
			exit;
		}

	}

	protected function run_signup() {
		// check form token
		$object = new User();
		if ($this->check_form_token('signup')) {
			$data = array(
					'first_name'		=> $this->get_input('first_name', '', true, 'caps'),
					'last_name'			=> $this->get_input('last_name', '', true, 'caps'),
					'email'				=> $this->get_input('email', '', false, 'lower'),

					'country_key'		=> $this->get_input('country_key', ''),
					'city_id'			=> $this->get_input('city_id', 0),

					'username'			=> $this->get_input('username', '', true, 'lower'),
					'password'			=> $this->get_input('password', '', true),
					'rpassword'			=> $this->get_input('rpassword', '', true),

					'time_offset'		=> $this->get_input('time_offset', 0),
					'dst'				=> $this->get_input('dst', 0),

					'active'			=> $this->get_input('active', 0),

					'id'				=> $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'username'	=> array('string', false, 1),
					'password'	=> array('string', false, $this->app->user_pw_len_min, $this->app->user_pw_len_max),
					'email'		=> array('string', false, 1, 100),
				));

			// TODO: pw match

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error);



			$object->set_missing_fields($error_fields);
			$existing = $object->verify($data['username'], $data['email']);
			if ($existing['username']) {
				$error[] = 'ERROR_USERNAME_EXISTS';
				$error_fields[] = 'username';
			}
			if ($existing['email']) {
				$error[] = 'ERROR_EMAIL_EXISTS';
				$error_fields[] = 'email';
			}

			// fill the object
			$object->set_username($data['username']);
			$object->set_password($data['password']);

			$object->set_first_name($data['first_name']);
			$object->set_last_name($data['last_name']);
			$object->set_email($data['email']);

			$object->set_country_key($data['country_key']);
			$object->set_city_id($data['city_id']);

			$object->set_time_offset($data['time_offset']);
			$object->set_dst($data['dst']);

			$object->set_signup_ip($_SERVER['REMOTE_ADDR']);
			$object->set_signup_time(date('Y-m-d H:i:s'));

			$object->set_role_id(Role::enum('user'));
			$object->set_active(($this->app->user_approval) ? 0 : 1);

			if (sizeof($error)) {
				// error
				$error_msgs = $this->lng->all();
				$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

				$_SESSION['login_var'] = array(
						'signup' => true,
						'signup_obj' => serialize($object),
						'alert' => 'danger',
						'msg' => implode('<br />', $error_msg),
					);

			} else {
				// save the record
				$object->update();

				$_SESSION['login_var'] = array(
						'username' => $data['username'],
						'alert' => 'success',
						'msg' => $this->lng->text('signup:success'),
					);
			}

			header('Location: ' . $this->app->go('Session/login'));
			exit;

		} else {
			// invalid token
			$_SESSION['login_var'] = array(
					'signup' => true,
					'signup_obj' => serialize($object),
					'alert' => 'danger',
					'msg' => $this->lng->text('ERROR:INVALID_TOKEN'),
				);
			header('Location: ' . $this->app->go('Session/login'));
			exit;

		}

	}

	protected function run_remind() {
		// check form token
		if ($this->check_form_token('remind')) {
			$data = array(
					'email'				=> $this->get_input('email', '', false, 'lower'),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'email'		=> array('string', false, 1, 100),
				));

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error);
			$error_msg = [];

			if (sizeof($error)) {
				// error
				$_SESSION['login_var'] = array(
						'remind' => true,
						'alert' => 'danger',
						'msg' => implode('<br />', $error_msg),
					);

			} else {
				$user = new User();
				if ($user->retrieve_by_email($data['email'])) {
					// set activation key
					$act_key = $this->get_uid($user->get_id());
					$act_limit = $this->utl->date_modify(date('Y-m-d H:i:s'), '+1 day', false, 'Y-m-d H:i:s');
					$act_limit_txt = $this->utl->date_format($act_limit, '-3:00', $this->app->datetime_format);

					$user->set_activation_key($act_key);
					$user->set_activation_limit($act_limit);
					$user->update();

					$views = $this->tpl->get_view('_email/remind', array(
							'username' => $user->get_username(),
							'sitename' => $this->cfg->setting->site,
							'url' => $this->app->go('Session/reset', false, '/' . $act_key),
							'limit' => $act_limit_txt,
						));

					// TODO: fix arguments
//					$this->utl->notify(false, array($data['email'] => $user->get_username()), $views['subject'], $views['body']);
				}

				// inform anyway
				$_SESSION['login_var'] = array(
						'alert' => 'success',
						'msg' => $this->lng->text('notify:remind_success'),
					);
			}

			header('Location: ' . $this->app->go('Session/login'));
			exit;

		} else {
			// invalid token
			$_SESSION['login_var'] = array('alert' => 'danger', 'msg' => $this->lng->text('ERROR:INVALID_TOKEN'));
			header('Location: ' . $this->app->go('Session/login'));
			exit;

		}
	}

	protected function run_remember($args) {
error_log('SessionCtrl / run_remember');
		$session_key = $this->get_cookie('k', '');

		$session = new Session();
		$session->retrieve_by('session_key', $session_key);

		// if redirect, store it before restart session
		if (isset($_SESSION['remember_target'])) {
			$goto = $_SESSION['remember_target'];
			unset($_SESSION['remember_target']);
		} else {
			$goto = $this->app->go('Home');
		}
error_log('SessionCtrl / run_remember / goto: ' . $goto);

		if ($session->get_id()) {
			// session record exists
error_log('SessionCtrl / run_remember / record exists');

			if (date('Y-m-d H:i:s') <= $session->get_time_limit()) {
				$user_base = substr($session_key, 0, strlen($session_key) - 28);
				$user_id = base_convert($user_base, 36, 10);

				if ($user_id == $session->get_user_id()) {
error_log('SessionCtrl / run_remember / session_key match id from record');
					// id from session_key match id from record
					session_destroy();
					session_start();

					// keep the user logged
					$_SESSION[md5($_SERVER['REMOTE_ADDR'])] = $user_id;
					$_SESSION['logged_by_remember'] = true;

					// renew 'remember' cookie
					$new_key = $this->get_uid($user_id);
					$this->set_cookie('k', $new_key, time()+60*60*24*30);

					// delete previous keys
					$session->delete_by('user_id', $user_id);

					// set a new session key
					$session = new Session();
					$session->set_user_id($user_id);
					$session->set_session_key($new_key);
					$session->set_time_limit($this->utl->date_modify(date('Y-m-d H:i:s'), '+1 month', false, 'Y-m-d H:i:s'));
					$session->update();

					// new user instance
					$user = new User($user_id);
					$this->app->user = $user;
					$this->app->user_id = $user->get_id();
					$this->app->username = $user->get_username();

				} else {
					// ids don't match, delete key preventively
					$session->delete();
					$this->del_cookie('k');
				}

			} else {
				// key expired
				$session->delete();
				$this->del_cookie('k');
			}

		} else {
			// key doesn't exist, remove cookie
			$this->del_cookie('k');

			$this->error_log('Invalid session_key: ' . $session_key);
		}

		header('Location: ' . $goto);
		exit;
	}

	private function reset_save($object, $activation_key) {
		$data = array(
				'username'			=> $this->get_input('username', '', true, 'lower'),
				'password'			=> $this->get_input('password', '', true),
				'rpassword'			=> $this->get_input('rpassword', '', true),

				'activation_key'	=> $this->get_input('activation_key', '', true),
			);

		if ($activation_key != $data['activation_key']) {

			// validate required
			$error_fields = $this->validate_data($data, array(
					'username'	=> array('string', false, 1),
					'password'	=> array('string', false, $this->app->user_pw_len_min, $this->app->user_pw_len_max),
					'rpassword'	=> array('string', false, $this->app->user_pw_len_min, $this->app->user_pw_len_max),
				));

			$error = $this->missing_fields($error_fields);

			$object->set_missing_fields($error_fields);

			$object->set_username($data['username']);
			$object->set_password($data['password']);

			if (sizeof($error)) {
				// error
				$error_msgs = $this->lng->all();
				$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

				$_SESSION['login_var'] = array(
						'object' => serialize($object),
						'alert' => 'danger',
						'msg' => implode('<br />', $error_msg),
					);

				header('Location: ' . $this->app->go());
				exit;

			} else {
				// save the record
				$object->set_activation_key('');
				$object->set_activation_limit('');
				$object->set_login_attempts(0);
				$object->set_attempt_ip('');
				$object->set_attempt_time('');

				$object->update();

				$_SESSION['login_var'] = array(
						'username' => $data['username'],
						'alert' => 'success',
						'msg' => $this->lng->text('reset:success'),
					);
			}

			header('Location: ' . $this->app->go('Session/login'));
			exit;

		} else {
			// invalid key
			$_SESSION['login_var'] = array(
					'alert' => 'danger',
					'msg' => $this->lng->text('ERROR:RESET_INVALID_KEY'),
				);
			header('Location: ' . $this->app->go('Session/login'));
			exit;

		}
	}

	private function login_save() {
		// if redirect, store it before restart session
		if (isset($_SESSION['goto'])) {
			$goto = $_SESSION['goto'];
			unset($_SESSION['goto']);
		} else {
			$goto = $this->app->go('Home');
		}

		// check form token
		$valid = $this->check_form_token('login');

		// restart session
		session_destroy();
		session_start();

		if ($valid) {
			// invalidate previous 'remember' cookies and sessions
			$session_key = $this->get_cookie('k', false);
			if ($session_key !== false) {
				$session = new Session();
				$session->delete_by('session_key', $session_key);

				$this->del_cookie('k');
			}

			// login form data
			$data = array(
					'username'			=> $this->get_input('username', '', true, 'lower'),
					'user_password'		=> $this->get_input('password', '', true),
					'remember'			=> $this->get_input('remember', 0),

					'recaptcha_field'	=> $this->get_input('recaptcha_field', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'username' 		=> array('string', false, 1, 20),
					'user_password' => array('string', false, 1, 20),
				));
			$error = $this->missing_fields($error_fields);

			// verify if user must use captcha
			$user = new User();
			$user->retrieve_by_username($data['username']);
			$req_captcha = ($user->get_login_attempts() >= $this->app->user_max_login_attemps);

			if ($req_captcha) {
				// verify if captcha form was used
				if (!$data['recaptcha_field']) {
					// captcha was required but standard login was used
					$_SESSION['login_var'] = array(
							'username' => $data['username'],
							'remember' => $data['remember'],
							'alert' => 'warning',
							'msg' => $this->lng->text('ERROR:FAIL_CAPTCHA_FORM'
						));

					header('Location: ' . $this->app->go('Session/confirm'));
					exit;

				} else  {
					// captcha required
					if (!$this->valid_captcha()) {
						$error[] = 'INVALID_CAPTCHA';
					}

				}
			}

			if (sizeof($error)) {
				// missing fields or captcha error
				$_SESSION['login_var'] = array('username' => $data['username'], 'remember' => $data['remember'],
						'alert' => 'danger', 'msg' => $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL'));
				if ($req_captcha) {
					header('Location: ' . $this->app->go('Session/confirm'));
				} else {
					header('Location: ' . $this->app->go());
				}
				exit;

			} else {
				if ($this->new_session($data['username'], $data['user_password'], $data['remember'])) {
					// login ok
					header('Location: ' . $goto);
					exit;

				} else {
					// login fail

					// TODO: count IP access

					// increase attemps and redirect if needed
					$attempts = $user->add_login_attempt($data['username']);

					if ($attempts == $this->app->user_max_login_attemps) {
						// captcha first time
						$_SESSION['login_var'] = array('username' => $data['username'], 'remember' => $data['remember'],
								'alert' => 'warning', 'msg' => $this->lng->text('ERROR:FAIL_CAPTCHA_FORM'));
						header('Location: ' . $this->app->go('Session/confirm'));

					} else if ($attempts > $this->app->user_max_login_attemps) {
						// more catcha
						$_SESSION['login_var'] = array('username' => $data['username'], 'remember' => $data['remember'],
								'alert' => 'danger', 'msg' => $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL'));
						header('Location: ' . $this->app->go('Session/confirm'));

					} else {
						// normal login
						$_SESSION['login_var'] = array('username' => $data['username'], 'remember' => $data['remember'],
								'alert' => 'danger', 'msg' => $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL'));
						header('Location: ' . $this->app->go());
					}
					exit;
				}

			}
		} else {
			// invalid token
			$_SESSION['login_var'] = array('alert' => 'danger', 'msg' => $this->lng->text('ERROR:INVALID_TOKEN'));
			header('Location: ' . $this->app->go());
			exit;
		}
	}

	private function get_uid($user_id) {
	    $id_part = base_convert($user_id, 10, 36);
	    return $id_part . $this->utl->get_token(28);
	}

	private function new_session($username, $password, $remember = false) {
		$user = new User();
		if ($user_id = $user->login($username, $password, $_SERVER['REMOTE_ADDR'])) {

			$user->reset_login_attempts();

			$_SESSION[md5($_SERVER['REMOTE_ADDR'])] = $user_id;

			if ($remember) {
				// set a cookie

				$new_key = $this->get_uid($user_id);
				$this->set_cookie('k', $new_key, time()+60*60*24*30); // 30 days

				// set a session key
				$session = new Session();
				$session->set_user_id($user_id);
				$session->set_session_key($new_key);
				$session->set_time_limit($this->utl->date_modify(date('Y-m-d H:i:s'), '+1 month', false, 'Y-m-d H:i:s'));
				$session->update();
			}

			$this->app->user = $user;
			$this->app->user_id = $user->get_id();
			$this->app->username = $user->get_username();

			return true;
		}
		return false;
	}




	private function error_log($error) {
//		if ($this->debug) {
			error_log('>>> SUPPLEMVC ' . $error);
//		}
	}

}
?>