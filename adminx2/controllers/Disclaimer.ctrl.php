<?php
class DisclaimerCtrl extends AdminCtrl {
	protected $mod = 'Disclaimer';
	protected $class = 'Document';


	protected function run_ajax_rows($objects = false) {
		$objects = new $this->class();
		$objects->set_section_key('disclaimer');

		parent::run_ajax_rows($objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'				=> $this->get_input('title', '', true),
					'document_key'		=> $this->get_input('document_key', '', true, 'lower'),
					'content'			=> $this->get_input('content', '', true),
					'featured'			=> $this->get_input('featured', 0), // used for main disclaimer

					'id'				=> $this->get_input('id', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'title' 			=> array('string', false, 1),
//					'document_key' 		=> array('string', false, 1),
					'content' 			=> array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			$object->set_title($data['title']);
			$object->set_section_key('disclaimer');
			$object->set_document_key($data['document_key']);
			$object->set_content($data['content']);
			$object->set_featured($data['featured']);
			$object->set_lang_iso('en');
			$object->set_active(1);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;

		}
	}

}
?>