<?php
class SessionCtrl extends CustomCtrl {

	public function run($args = []) {
		$action = array_shift($args);
		switch ($action) {
			case 'confirm': 	$this->run_login($args, true); break;
			case 'remember': 	$this->run_remember($args); break;
			case 'remind': 		$this->run_remind($args); break;
			case 'reset': 		$this->run_reset($args); break;
			case 'logout': 		$this->run_logout($args); break;
			case 'login_rmb': 	$this->run_login_rmb($args); break;

			default: 			$this->run_login($args);
		}
	}


	protected function run_login($args, $captcha = false) {
		if (!$this->app->user_id) {
			if ($this->get_input('action', '') == 'login') {
				// save
				$this->login_save();

			} else {
				$title = $this->lng->text('login:title');
				$body_id = 'body_enter';
				$object = new User();
				$login_var = false;

				if (isset($_SESSION['login_var'])) {
					$login_var = $_SESSION['login_var'];
					unset($_SESSION['login_var']);
				}

				$publickey = '';
				if ($captcha) {
					$publickey = $this->app->captcha_public;
				}

				$login_token = $this->get_form_token('login');
				$remind_token = $this->get_form_token('remind');

				$page_args = array(
						'meta_title' => $title,
						'title' => $title,
						'body_id' => $body_id,
						'login_token' => $login_token,
						'remind_token' => $remind_token,
						'publickey' => $publickey,
						'object' => $object,
						'login_var' => $login_var,
					);
//print_r($page_args);
//exit;
				$views = array_merge($page_args, $this->tpl->get_view('session/login', $page_args));
				$this->tpl->page_draw($views);
			}

		} else {
			$this->app->redirect($this->app->go('Home'));
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

		// save target if exists
		$target = $this->app->go('Home');
		if (isset($_SESSION['logout_target'])) {
			$target = $_SESSION['logout_target'];
			unset($_SESSION['logout_target']);
		}

		// restart session
		session_destroy();
		session_start();

		header('Location: ' . $target);
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
					$title = $this->lng->text('reset:title');
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
					$this->tpl->page_draw($views);
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

	protected function run_remind() {
		// check form token
		if (true) { // $this->check_form_token('remind')) {
			$data = array(
					'email'		=> $this->get_input('email', '', false, 'lower'),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'email'		=> array('string', false, 1, 100),
				));

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error);

			if (sizeof($error)) {
				// error
				$_SESSION['login_var'] = array(
						'email' => $data['email'],
					);
				$_SESSION['error_msg'] = $this->lng->text('EMAIL_INVALID_EMAIL');

			} else {
				$user = new User();
				if ($user->retrieve_by('email', $data['email'])) {
					// set activation key
					$act_key = $this->get_uid($this->app->user_id);
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
					$this->utl->notify(array(
							'to' => array($data['email'] => $user->get_username()),
							'subject' => $views['subject'],
							'body' => $views['body']
						));
				}

				// inform anyway
				$_SESSION['success_msg'] = $this->lng->text('notify:remind_success');
			}

			$this->app->redirect($this->app->go('Session/login'), true);

		} else {
			// invalid token
			$_SESSION['login_var'] = array('alert' => 'danger', 'msg' => $this->lng->text('ERROR:INVALID_TOKEN'));
			header('Location: ' . $this->app->go('Session/login'));
			exit;

		}
	}

	protected function run_remember($args) {
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

		if ($session->get_id()) {
			// session record exists

			if (date('Y-m-d H:i:s') <= $session->get_time_limit()) {
				$user_base = substr($session_key, 0, strlen($session_key) - 28);
				$user_id = base_convert($user_base, 36, 10);

				if ($user_id == $session->get_user_id()) {
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
					'target'			=> $this->get_input('target', '', true),

					'recaptcha_field'	=> $this->get_input('g-recaptcha-response', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'username' 		=> array('string', false, 1, 20),
					'user_password' => array('string', false, 1, 20),
				));
			$error = $this->missing_fields($error_fields);

			// warning - override $_SESSION['goto']
			if ($data['target']) {
				$goto = $data['target'];
			}

			// verify if user must use captcha
			$user = new User();
			$user->retrieve_by('username', $data['username']);
			$req_captcha = ($user->get_login_attempts() >= $this->app->user_max_login_attemps);

			// set session var, removed if login success
			$_SESSION['login_var'] = array(
					'username' => $data['username'],
					'remember' => $data['remember'],
				);

			if ($req_captcha) {
				// verify if captcha form was used
				if (!$data['recaptcha_field']) {
					// captcha was required but standard login was used
					$_SESSION['error_msg'] = $this->lng->text('ERROR:FAIL_CAPTCHA_FORM');
					$this->app->redirect($this->app->go('Session/confirm'), true);

				} else  {
					// captcha required
					if (!$this->valid_captcha()) {
						$error[] = 'INVALID_CAPTCHA';
					}
				}
			}
//error_log(print_r($data, true));
//error_log('$req_captcha: ' . $req_captcha);
//error_log(print_r($error, true));

			if (sizeof($error)) {
				// missing fields or captcha error
				$_SESSION['error_msg'] = $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL');
				if ($req_captcha) {
					$this->app->redirect($this->app->go('Session/confirm'), true);
				} else {
					$this->app->redirect($this->app->go(), true);
				}

			} else {
				if ($this->new_session($data['username'], $data['user_password'], $data['remember'])) {
					// login ok
					unset($_SESSION['login_var']);
					$this->app->redirect($goto, true);

				} else {
					// login fail - TODO: count IP access
					// increase attemps and redirect if needed
					$attempts = $user->add_login_attempt($data['username']);

					if ($attempts == $this->app->user_max_login_attemps) {
						// captcha first time
						$_SESSION['error_msg'] = $this->lng->text('ERROR:FAIL_CAPTCHA_FORM');
						$this->app->redirect($this->app->go('Session/confirm'), true);

					} else if ($req_captcha || $attempts > $this->app->user_max_login_attemps) {
						// more captcha
						$_SESSION['error_msg'] = $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL');
						$this->app->redirect($this->app->go('Session/confirm'), true);

					} else {
						// normal login
						$_SESSION['error_msg'] = $this->lng->text(($req_captcha) ? 'ERROR:FAIL_CAPTCHA' : 'ERROR:FAIL');
						$this->app->redirect($this->app->go());
					}
				}

			}
		} else {
			// invalid token
			$_SESSION['login_var'] = array(
					'alert' => 'danger',
					'msg' => $this->lng->text('ERROR:INVALID_TOKEN')
				);
			header('Location: ' . $this->app->go());
			exit;
		}
	}

	private function error_log($error) {
//		if ($this->debug) {
			error_log('>>> SUPPLEMVC ' . $error);
//		}
	}

}
?>