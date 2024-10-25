<?
abstract class AdminCtrl extends BaseCtrl {
	protected $cfg;
	protected $lng;
	protected $tpl;

	protected $mod = '';
	protected $mod_key = '';
	protected $class = '';
	protected $single_view = '';
	protected $multiple_view = '';

	protected $id = false;
	protected $object = false;


	public function run($args) {
		error_log('Entró');
		$this->class = ($this->class) ? $this->class : $this->mod;
		$this->mod_key = strtolower($this->mod);

		$action = array_shift($args);
		switch ($action) {
			case 'new': 		$this->run_new($args); break;
			case 'edit': 		$this->run_edit($args); break;
			case 'delete': 		$this->run_delete($args); break;
			case 'activate': 	$this->run_activate($args); break;
			case 'save': 		$this->run_save($args); break;

			case 'ajax_rows': 	$this->run_ajax_rows($args); break;

			default: 			$this->run_default($args);
		}
	}

	protected function run_default($args) {
		$this->run_multiple($args);
	}


	protected function run_delete($args) {
		$id = array_shift($args);
		$object = new $this->class();
		$object->delete($id);

		$method = array_shift($args);
		if ($method == 'ajax') {
			echo 1;
		} else {
			$_SESSION['success_msg'] = $this->lng->text('form:deleted');
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_activate($args) {
		$id = array_shift($args);
		$object = new $this->class($id);
		$object->retrieve($id, false);
//var_dump($object); exit;
		$object->set_active(($object->get_active()) ? 0 : 1);
		$object->update();

		$method = array_shift($args);
		if ($method == 'ajax') {
			echo $object->get_active();
		} else {
			$_SESSION['success_msg'] = $this->lng->text(($object->get_active()) ? 'form:activated' : 'form:deactivated');
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}


	protected function run_save($args = []) {
		header('Location: ' . $this->app->go($this->app->module_key));
		exit;
	}

	protected function save(&$object, $error, $action = 'go_list') {
		if (sizeof($error)) {
			$error_msgs = $this->lng->all();
			$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

			$tmp_var = 'tmp_' . strtolower($this->app->module_key);

			$_SESSION[$tmp_var] = serialize($object);
//echo var_dump($object);
//echo '<br><br><br><br><br>';
//echo var_dump($_SESSION[$tmp_var]); exit;
			$_SESSION['error_msg'] = (sizeof($error)) ? implode('<br />', $error_msg) : '';

			if ($action == 'return') {
				return false;

			} else {
				$go_error = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
				$go_error = $this->app->go($this->app->module_key, false, $go_error);
				header('Location: ' . $go_error);
				exit;
			}

		} else {
			// save the record
			$object->update();

			$_SESSION['success_msg'] = $this->lng->text('form:saved');

			if ($action == 'go_list') {
				$go_success = $this->app->go($this->app->module_key);
				header('Location: ' . $go_success);
				exit;

			} else if ($action == 'return') {
				return true;

			} else {
				$go_success = $this->app->go($this->app->module_key, false, '/edit/' . $object->get_id());
				header('Location: ' . $go_success);
				exit;
			}
		}
	}

	protected function run_ajax_rows($objects = false) {
		$data = array(
				'page'			=> $this->request_var('page', 1),
				'sort_field'	=> $this->request_var('sort_field', 'id'),
				'sort_order'	=> $this->request_var('sort_order', 'desc'),
				'filter'		=> $this->request_var('filter', '', true),
				'limit'			=> $this->request_var('limit', '50'), // TODO: limit should be taken from grid_setup
			);

		$grid_setup = json_decode(stripslashes($_POST['grid_setup']), true);
		$page_args = json_decode(stripslashes($_POST['page_args']), true);

		if (!$objects) {
			$objects = new $this->class();
		}

		$filter = false;
		if ($data['filter']) {
			$filter = array(stripcslashes($data['filter']));
			$_SESSION[$this->mod_key . ':filter'] = $data['filter'];
		} else {
			unset($_SESSION[$this->mod_key . ':filter']);
		}

		if ($page_args) {
			$_SESSION[$this->mod_key . ':page_args'] = $page_args;
		}

		$count_method = (array_key_exists('count_method', $grid_setup)) ? $grid_setup['count_method'] : 'list_count';
		$record_count = $objects->$count_method(false);

		$last_page = ceil($record_count / $data['limit']);
		if ($data['page'] == -1) {
			$data['page'] = $last_page;
		}

		// new format
		$order = false;
		if ($data['sort_field'] && $data['sort_order']) {
			$order = "`{$data['sort_field']}` {$data['sort_order']}";
		}
		$objects->set_paging($data['page'], $data['limit'], $order, $filter);


		echo $this->tpl->get_view('_output/grid_rows', array(
				'collection' => $objects,
				'grid_setup' => $grid_setup,
				'page' => $data['page'],
				'last_page' => $last_page,
				'sort_field' => $data['sort_field'],
				'sort_order' => $data['sort_order']
			));
	}


	protected function run_multiple($args) {
		$title = $this->lng->text("{$this->mod_key}:{$this->mod_key}s");
		$body_id = "body_{$this->mod_key}s";

		$page_args = array('meta_title' => $title, 'title' => $title, 'body_id' => $body_id);
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}

		$page_args['body'] = $this->tpl->get_view("{$this->mod_key}/{$this->mod_key}s", $page_args);
		$this->tpl->page_draw($page_args);
	}


	protected function run_new($args) {
		$tmp_var = 'tmp_' . strtolower($this->app->module_key);
		if (isset($_SESSION[$tmp_var])) {
			$object = unserialize($_SESSION[$tmp_var]);
			unset($_SESSION[$tmp_var]);
		} else {
			$object = new $this->class();
		}
		$this->run_single($object, $args);
	}

	protected function run_edit($args) {
		$tmp_var = 'tmp_' . strtolower($this->app->module_key);
		if (isset($_SESSION[$tmp_var])) {
			$object = unserialize($_SESSION[$tmp_var]);
			unset($_SESSION[$tmp_var]);
		} else {
			$id = array_shift($args);
			$object = new $this->class();
			$object->retrieve($id, false);
		}
		$this->run_single($object, $args);
	}

	protected function run_single($object, $args = false) {
		$meta_title = $this->lng->text("{$this->mod_key}:{$this->mod_key}") . ': ' . (($object->get_id()) ? $object->get_string() : '[' . $this->lng->text("{$this->mod_key}:new") . ']');
		$title = $this->lng->text("{$this->mod_key}:{$this->mod_key}") . ': <em>' . (($object->get_id()) ? $object->get_string() : '[' . $this->lng->text("{$this->mod_key}:new") . ']') . '</em>';
		$body_id = "body_{$this->mod_key}";

		$page_args = array('meta_title' => $meta_title, 'title' => $title, 'object' => $object, 'body_id' => $body_id);
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}

		$page_args['body'] = $this->tpl->get_view("{$this->mod_key}/{$this->mod_key}", $page_args);
		$this->tpl->page_draw($page_args);
	}


}
?>
