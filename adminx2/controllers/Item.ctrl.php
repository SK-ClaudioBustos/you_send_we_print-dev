<?php
class ItemCtrl extends AdminCtrl {
	protected $mod = 'Item';


	protected function run_multiple($args) {
		$filter = $page_args = $item_list_key = false;

		if (isset($_SESSION[$this->mod_key . ':filter'])) {
			$filter = $_SESSION[$this->mod_key . ':filter'];
		}

		if (isset($_SESSION[$this->mod_key . ':page_args'])) {
			$page_args = $_SESSION[$this->mod_key . ':page_args'];
			$item_list_key = $page_args['item_list_key'];
		}

		$lists = new ItemList();
		$lists->set_paging(1, 0, '`item_list_key` ASC');

		$item_lists = array();
		while ($lists->list_paged()) {
			$item_lists[$lists->get_item_list_key()] = $lists->get_title();
		}

		$args = array('filter' => $filter, 'item_lists' => $item_lists, 'item_list_key' => $item_list_key, 'page_args' => $page_args);
		parent::run_multiple($args);
	}

	protected function run_single($object, $args = false) {
		$item_lists = new ItemList();
		$item_lists->set_paging(1, 0, '`item_list_key` ASC');

		$cut_items = new Item();
		$cut_items->set_paging(1, 0, '`item_code` ASC', array("`item_list_key` = 'cut-type'"));

		$item_cut = new ItemCut();
		$item_cut->set_paging(1, 0, false, array("`item_id` = {$object->get_id()}"));

		$item_cuts = array();
		while($item_cut->list_paged()) {
			$item_cuts[(string)$item_cut->get_cut_id()] = ''; // (($item_cut->get_item_code()) ? '[' . $item_cut->get_item_code() . '] ' : '') . $item_cut->get_item();
		}

		$calc_bys = Item::calc_by_list();
		$args = array(
				'item_lists' => $item_lists,
				'calc_bys' => $calc_bys,
				'cut_items' => $cut_items,
				'item_cuts' => $item_cuts
			);
		parent::run_single($object, $args);
	}


	protected function run_save($args) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'			=> $this->get_input('title', '', true),
					'item_code'		=> $this->get_input('item_code', '', true),
					'description'	=> $this->get_input('description', '', true),
					'item_list_key'	=> $this->get_input('item_list_key', '', true, 'lower'),
					'price'			=> $this->get_input('price', 0.00),

					'max_width'		=> $this->get_input('max_width', 0.00),
					'max_length'	=> $this->get_input('max_length', 0.00),
					'max_absolute'	=> $this->get_input('max_absolute', 0),

					'calc_by'		=> $this->get_input('calc_by', ''),
					'weight'		=> $this->get_input('weight', 0.00),

					'active'		=> $this->get_input('active', 0),
					'id'			=> $this->get_input('id', 0),
				);
//print_r($data);
//exit;
			$error_fields = $this->validate_data($data, array(
					'title' 		=> array('string', false, 1),
					'item_list_key'	=> array('string', false, 1),
					'price' 		=> array('num', false),
				));

			if ($data['item_list_key']) {
				$item_list = new ItemList();
				$item_list->retrieve_by('item_list_key', $data['item_list_key']);
				if ($item_list->get_calc_by() == 'variable') {
					$calc_field = $this->validate_data($data, array(
							'calc_by' => array('string', false, 1),
						));
					$error_fields = array_merge($error_fields, $calc_field);
				}
			}

			$error = $this->missing_fields($error_fields);

			$object = new $this->class();
			$object->retrieve($data['id'], false);
			$object->set_missing_fields($error_fields);

			$object->set_item_code($data['item_code']);
			$object->set_title($data['title']);
			$object->set_description($data['description']);
			$object->set_item_list_key($data['item_list_key']);
			$object->set_price($data['price']);

			$object->set_max_width($data['max_width']);
			$object->set_max_length($data['max_length']);
			$object->set_max_absolute($data['max_absolute']);

			$object->set_calc_by($data['calc_by']);
			$object->set_weight($data['weight']);

			$object->set_active($data['active']);

			if ($this->save($object, $error, 'return')) {
				// save items
				$cut_items = new Item();
				$cut_items->set_paging(1, 0, '`item_code` ASC', array("`item_list_key` = 'cut-type'"));

				$item_cut = new ItemCut();
				$item_cut->set_paging(1, 0, false, array("`item_id` = {$object->get_id()}"));

				$item_cuts = array();
				while($item_cut->list_paged()) {
					$item_cuts[(string)$item_cut->get_cut_id()] = $item_cut->get_id();
				}
//print_r($item_cuts);
//print_r($_POST);
//exit;
				while($cut_items->list_paged()) {
					$item_cut = new ItemCut();

					if (array_key_exists('itm_' . $cut_items->get_id(), $_POST)) {
						if (!array_key_exists((string)$cut_items->get_id(), $item_cuts)) {
							// new item_cut
							$item_cut->set_item_id($object->get_id());
							$item_cut->set_cut_id($cut_items->get_id());
							$id = $item_cut->update();
						}

					} else {
						if (array_key_exists((string)$cut_items->get_id(), $item_cuts)) {
							$item_cut->delete($item_cuts[(string)$cut_items->get_id()]);
						}
					}
				}

			} else {
			}

			$go = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
			$go = $this->app->go($this->app->module_key, false, $go);
			header('Location: ' . $go);
			exit;


		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;

		}
	}

}
?>