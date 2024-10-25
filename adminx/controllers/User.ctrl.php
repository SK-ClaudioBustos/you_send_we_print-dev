<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        UserCtrl
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
  *
 */

class UserCtrl extends CustomCtrl {
	protected $mod = 'User';


	protected function run_default($args, $action) {
		switch ($action) {
			case 'profile': 			$this->authorize('run_profile', $args, false); break;
			case 'prof_save': 			$this->authorize('run_prof_save', $args, false); break;

			default: 					$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args = (is_array($args)) ? $args : array();
		$args['sortfield'] = 'username';
		$args['sortorder'] = 'ASC';
		$args['active_only'] = false;
		$args['searchfields'] = 'username';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function get_row($objects, $args = [], $arg1 = [], $arg2 = []) {
		return array(
  				'',
				(int)$objects->get_active(),
				$objects->get_username(),
				$this->lng->text($objects->get_role()),
				$objects->get_email(),
				$objects->get_name(),
				$objects->get_last_time(),
				$objects->get_last_ip(),
			);
	}

	protected function run_profile($args) {
		$tmp_var = 'tmp_' . strtolower($this->cfg->app->module_key);
		if (isset($_SESSION[$tmp_var])) {
			$object = unserialize($_SESSION[$tmp_var]);
			unset($_SESSION[$tmp_var]);
		} else {
			$object = $this->app->user;
		}
		$args['profile'] = true;
		$args['logged_by_remember'] = (isset($_SESSION['logged_by_remember']) && $_SESSION['logged_by_remember']);
		$this->run_single($object, $args);
	}

	protected function run_prof_save($args) {
		$this->run_save(true);
	}

	protected function run_multiple($args = []) {
		if ($_SESSION['logged_by_remember']) {
			$_SESSION['session_target'] = $this->app->page_full;
			$this->app->redirect($this->app->go('Session/login_rmb'));

		} else {
			parent::run_multiple($args);
		}
	}

	protected function run_single($object, $args = array()) {
		if ($_SESSION['logged_by_remember'] && !$args['profile']) {
			$_SESSION['session_target'] = $this->app->page_full;
			$this->app->redirect($this->app->go('Session/login_rmb'));

		} else {
			$roles = new Role();
			$roles->set_paging(1, 0, '`role` ASC');

			$page_args = array_merge($args, array(
					'roles' => $roles,
				));
			parent::run_single($object, $page_args);
		}
	}

	protected function run_save($profile = false) {
		if ($this->get_input('action', '') == 'edit') {

			$logged_by_remember = false;

			$require_client = array(
					Role::enum('guest'),
					Role::enum('guest_no_summary'),
					Role::enum('guest_survey'),
				);

			if (!$profile) {
				$data = array(
						'username'			=> $this->get_input('username', '', true, 'lower'),
						'password'			=> $this->get_input('password', '', true),

						'first_name'		=> $this->get_input('first_name', '', true, 'caps'),
						'last_name'			=> $this->get_input('last_name', '', true, 'caps'),
						'email'				=> $this->get_input('email', '', false, 'lower'),
						'role_id'			=> $this->get_input('role_id', 0),

						'remote_access'		=> $this->get_input('remote_access', 0),
						'active'			=> $this->get_input('active', 0),

						'id'				=> $this->get_input('id', 0),
					);

				// validate required
				$error_fields = $this->validate_data($data, array(
						'username'	=> array('string', false, 1),
						'role_id'	=> array('num', false, 1),
						'email'		=> array('string', false, 1, 100),
					));

			} else {
				$data = array(
						'username'			=> $this->get_input('username', '', true, 'lower'),
						'password'			=> $this->get_input('password', '', true),

						'first_name'		=> $this->get_input('first_name', '', true, 'caps'),
						'last_name'			=> $this->get_input('last_name', '', true, 'caps'),
						'email'				=> $this->get_input('email', '', false, 'lower'),

						'cur_password'		=> $this->get_input('cur_password', '', true),

						'id'				=> $this->get_input('id', 0),
					);

				$error_fields = $this->validate_data($data, array(
						'username'	=> array('string', false, 1),
						'email'		=> array('string', false, 1, 100),
					));

				if (isset($_SESSION['logged_by_remember']) && $_SESSION['logged_by_remember']) {
					$logged_by_remember = true;
					if (!$data['cur_password']) {
						$error_fields[] = 'cur_password';
					}
				}

			}

			if (!$data['id'] && !$data['password']) {
				$error_fields[] = 'password';
			}

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class();
			$object->retrieve($data['id'], false);

			if ($logged_by_remember && $data['cur_password']) {
				// validate current pw
				if ($object->login($object->get_username(), $data['cur_password'])) {
					// login ok, remove $_SESSION['logged_by_remember']
					unset($_SESSION['logged_by_remember']);

				} else {
					$error_fields[] = 'cur_password';
					$error[] = $this->lng->text('ERROR:INVALID_CURRENT_PW');
				}
			}

			if ($data['password'] && (strlen($data['password']) < $this->app->user_password_len_min || strlen($data['password']) > $this->app->user_password_len_max)) {
				$error_fields[] = 'password';
				$error[] = $this->lng->text('ERROR:INVALID_PW_LENGTH');
			}

			// fill the object
			$object->set_username($data['username']);
			$object->set_password($data['password']);

			$object->set_first_name($data['first_name']);
			$object->set_last_name($data['last_name']);
			$object->set_email($data['email']);

			if (!$profile) {
				$object->set_role_id($data['role_id']);

				$object->set_remote_access($data['remote_access']);
				$object->set_active($data['active']);

				if ($data['password']) {
					// if pw is changed by admin, attemps are reseted
					$object->set_login_attempts(0);
					$object->set_attempt_ip('');
					$object->set_attempt_time('');
				}
			}

			if (!sizeof($error)) {
				// verify username and email
				$existing = $object->verify($object->get_username(), $object->get_email(), $object->get_id());
				//if (in_array('username', $existing)) {
				if ($existing['username']) {
					$error[] = $this->lng->text('ERROR:ERROR_USERNAME_EXISTS');
					$error_fields[] = 'username';
				}
				//if (in_array('email', $existing)) {
				if ($existing['email']) {
					$error[] = $this->lng->text('ERROR:ERROR_EMAIL_EXISTS');;
					$error_fields[] = 'email';
				}
			}

			$object->set_missing_fields($error_fields);

			if ($this->save($object, $error, 'return')) {
				if (!$profile) {
					header('Location: ' . $this->app->go($this->app->module_key));
				} else {
					header('Location: ' . $this->app->go($this->app->module_key . '/profile'));
				}
			} else {
				if (!$profile) {
					$go_error = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
					$go_error = $this->app->go($this->app->module_key, false, $go_error);
					header('Location: ' . $go_error);
				} else {
					header('Location: ' . $this->app->go($this->app->module_key . '/profile'));
				}
			}

			exit;

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

}
?>
