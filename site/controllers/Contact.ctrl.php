<?php
class ContactCtrl extends CustomCtrl {
	protected $mod = 'Contact';
	protected $class = 'Contact';


	protected function run_default($args = array(), $action) {
		switch ($action) {
			case 'ajax_subscribe': 	$this->run_ajax_subscribe($args, $action); break;
			case 'map':				$this->run_map($args); break;

			default:				$this->run_single(false, array($action));
		}

	}


	protected function run_map($args) {
		$title = $this->lng->text('contact:map');
		$body_id = 'body_contact_map';

		$page_args = array(
				'meta_title' => $title,
				'title' => $title,
				'body_id' => $body_id,
			);
		$views = array_merge($page_args, $this->tpl->get_view('contact/contact_map', $page_args));
		$this->tpl->page_draw($views);
	}

	protected function run_ajax_subscribe($args = array(), $action) {
		if ($this->get_input('action', '') == 'subscribe') {
			$data = array(
					'subscribe'		=> $this->get_input('subscribe', '', false, 'lower'),
					'target'		=> $this->get_input('target', '', true),
				);

			$error_fields = $this->validate_data($data, array(
					'email' 		=> array('string', false, 1, 100),
				));

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['subscribe'], $error_fields, $error);

			$object = new $this->class();

			// fill the object
			$object->set_email($data['subscribe']);
			$object->set_ip($_SERVER['REMOTE_ADDR']);

			$object->set_section_key('subscriber');
			$object->set_active(1);

			if (!sizeof($error)) {
				$object->update();
				$data = array('success' => true);

			} else {
				$data = array('error' => 'Unknow');
			}

		} else {
			$data = array('error' => 'No action');
		}

		header("Content-type: application/json");
		echo json_encode($data);
	}

	protected function run_single($object, $args = array()) {
		$object = new $this->class();

		if (isset($_SESSION[$this->app->module_key . '_var'])) {
			$object = unserialize($_SESSION[$this->app->module_key . '_var']);
			unset($_SESSION[$this->app->module_key . '_var']);
		}

		$page_args = array_merge($args, array(
				'meta_title' => $this->lng->text('contact'),
				'body_id' => 'body_contact',
				'meta_description' => $this->lng->meta('contact:description'),
				'meta_keywords' => $this->lng->meta('contact:keywords'),

				'title' => $this->lng->text('contact'),
				'object' => $object,
			));

		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'contact') {
			$data = array(
					'first_name'	=> $this->get_input('first_name', '', true, 'caps'),
					//'last_name'		=> $this->get_input('last_name', '', true, 'caps'),
					'email'			=> $this->get_input('email', '', false, 'lower'),
					'message'		=> $this->get_input('message', '', true),
					'response'		=>
				$this->get_input('g-recaptcha-response', '', true),
				);

			$error_fields = $this->validate_data($data, array(
					'first_name' 	=> array('string', false, 1),
					'email' 		=> array('string', false, 1, 60),
					'message' 		=> array('string', false, 1),
				));

			//Verification - reCaptcha 3
			$approved = 0;
			$url = "https://www.google.com/recaptcha/api/siteverify";
			$data_api = [
				'secret' 	=> '6LeqmDsaAAAAAIt-JV0dr0SQgZVIr40FNiH68yqE',
				'response'	=> $data['response'],
				'remoteip'	=> $_SERVER['REMOTE_ADDR']
			];

			$client = curl_init($url);
			curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($client, CURLOPT_POST, true);
			curl_setopt($client, CURLOPT_POSTFIELDS,  http_build_query($data_api));
			$response = curl_exec($client);
			$result = json_decode($response,true);

			if ($result['success'] == true && $result['score'] >= 0.6 && $result['action'] == 'submit') {
				$approved = 1;
			}
			//End Verification

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class();
			$object->set_missing_fields($error_fields);

			// fill the object

			$object->set_first_name($data['first_name']);
			//$object->set_last_name($data['last_name']);
			$object->set_email($data['email']);

			$object->set_message(substr($data['message'], 0, 1000)); // TODO: lenght
			$object->set_ip($_SERVER['REMOTE_ADDR']);
			$object->set_approved($approved);

			$object->set_section_key('contact');
			$object->set_active(1);

			$this->save($object, $error);

		} else {
			$this->app->redirect($this->app->go($this->app->module_key, true));
		}
	}

	protected function save(&$object, $error, $action = []) {
		if (sizeof($error)) {
			$error_msgs = $this->lng->all();
			$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
				return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
			}, $error);

			$_SESSION['error_msg'] = $error_msg;
			$_SESSION[$this->app->module_key . '_var'] = serialize($object);

		} else {
			// save the record
			$object->update();

			//Send the email
			$this->send_email($object);

			$_SESSION['success_msg'] = $this->lng->text('contact:received', $object->get_first_name());
		}

		header('Location: ' . $this->app->go($this->app->module_key));
		exit;

	}

	protected function send_email(&$object) {
		if ($object->get_approved() == 1) {
			$this->notify('', [
				'name' 		=> $object->get_first_name(),
				'email' 	=> $object->get_email(),
				'comment'	=> $object->get_message()
			]);
		}
	}

}
?>