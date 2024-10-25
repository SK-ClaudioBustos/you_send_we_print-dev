<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemCtrl
 * GENERATION DATE:  2019-06-11
 * -------------------------------------------------------
  *
 */

class ItemCtrl extends CustomCtrl {
	protected $mod = 'Item';
	protected $class = 'Item';


	protected function run_default($args, $action) {
		switch ($action) {
			case 'ajax_upload': 	$this->authorize('run_ajax_upload', $args, "perm:{$this->mod_key}"); break;

			default:				$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		$date = date_create($objects->get_price_date());
		$date_f = date_format($date, "m/d/Y") == '11/30/-0001' ? '00-00-0000' : date_format($date, "m/d/Y");
		return array(
				'',
				$objects->get_active(),

				$objects->get_item_code(),
				$objects->get_title(),
				$objects->get_item_list(),
				$objects->get_price(),
				$date_f,
				$objects->get_weight(),
				$objects->get_calc_by()
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = array('item_code', '`tbl_item`.`title`', 'item_list_key', '`tbl_item`.`filter_word`');
		$args['active_only'] = false;

		$filter = array();
		if ($item_list_key = $this->get_input('item_list_key', '')) {
			$filter[] = "`item_list_key` = '{$item_list_key}'";
			$_SESSION[$this->mod_key . ':item_list_key'] = $item_list_key;
		}
		$args['filter'] = $filter;

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_multiple($args = []) {
		$item_list_key = false;
		if (isset($_SESSION[$this->mod_key . ':item_list_key'])) {
			$item_list_key = $_SESSION[$this->mod_key . ':item_list_key'];
		}

		$item_lists = new ItemList();
		$item_lists->set_paging(1, 0, '`item_list_key` ASC');

		$args = array(
				'item_lists' => $item_lists,
				'item_list_key' => $item_list_key,
			);
		parent::run_multiple($args);
	}

	protected function run_single($object, $args = false) {
		$item_list = new ItemList();
		$item_list->retrieve_by('item_list_key', $object->get_item_list_key());

		$item_lists = new ItemList();
		$item_lists->set_paging(1, 0, '`item_list_key` ASC');

		$cut_items = new Item();
		$cut_items->set_paging(1, 0, '`item_code` ASC', array("`item_list_key` = 'cut-type'"));

		$item_cut = new ItemCut();
		$item_cut->set_paging(1, 0, false, array("`item_id` = {$object->get_id()}"));

		$item_cuts = array();
		while($item_cut->list_paged()) {
			$item_cuts[(string)$item_cut->get_cut_id()] = '';
		}

		$calc_by_list = Item::calc_by_list();
		$calc_bys = array();
		foreach($calc_by_list as $calc) {
			$calc_bys[$calc] = $this->lng->text('calc:' . $calc);
		}

		$args = array(
				'item_list' => $item_list,
				'item_lists' => $item_lists,
				'calc_bys' => $calc_bys,
				'cut_items' => $cut_items,
				'item_cuts' => $item_cuts
			);
		parent::run_single($object, $args);
	}

	protected function run_ajax_upload($args) {
		$folder = $this->cfg->path->data . '/item/';
		$filename = time();

		$result = $this->save_attach($folder, 'file', $this->app->file_extensions, $filename, $original_name);

		if ($result === true) {
			$url = $this->cfg->url->data . '/item/' . $filename;
			header("Content-type: application/json");
			echo json_encode(array('location' => $url));

		} else {
			header('HTTP/1.1 500 Server Error');
		}
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'item_code' => $this->get_input('item_code', '', true),
					'item_key' => $this->get_input('item_key', '', true),
					'item_list_key' => $this->get_input('item_list_key', '', true),
					'title' => $this->get_input('title', '', true),
					'filter_word' => $this->get_input('filter_word', '', true),

					'description' => $this->get_input('description', '', true),
					'price' => $this->get_input('price', 0.00),

					'max_width' => $this->get_input('max_width', 0.00),
					'max_length' => $this->get_input('max_length', 0.00),
					'max_absolute' => $this->get_input('max_absolute', 0),

					'calc_by' => $this->get_input('calc_by', '', true),
					'weight' => $this->get_input('weight', 0.00),

					'active' => $this->get_input('active', 0),
					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'title' 		=> array('string', false, 1),
					'item_list_key'	=> array('string', false, 1),
				//	'price' 		=> array('num', false),
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

			if ($data['id'] == 0) {
				$object->set_price_date(date('Y-m-d'));
			} else {
				if ($object->get_price() != $data['price']) {
					$object->set_price_date(date('Y-m-d'));
				}
			}


			// fill the object
			$object->set_item_code($data['item_code']);
			$object->set_item_key($data['item_key']);
			$object->set_item_list_key($data['item_list_key']);
			$object->set_title($data['title']);
			$object->set_filter_word($data['filter_word']);
			$object->set_description($data['description']);
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
			$this->app->redirect($go, true);

		} else {
			$this->app->redirect($this->app->go($this->app->module_key));
		}
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$filter = false;
		if ($item_list_key = $this->get_input('item_list_key', '')) {
			$filter = array("`item_list_key` = '{$item_list_key}'");
		}

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`title` ASC", $filter);

		$header = array(
				$this->lng->text('item:item_code'),
				$this->lng->text('item:title'),
				$this->lng->text('item:item_list_key'),
				$this->lng->text('item:price'),
				$this->lng->text('item:weight'),
				$this->lng->text('item:calc_by'),
				$this->lng->text('item:max_width'),
				$this->lng->text('item:max_length'),
				$this->lng->text('item:max_absolute'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_item_code(),
					html_entity_decode($objects->get_title()),
					$objects->get_item_list_key(),
					$objects->get_price(),
					$objects->get_weight(),
					$objects->get_calc_by(),
					$objects->get_max_width(),
					$objects->get_max_length(),
					($objects->get_max_absolute()) ? '✔' : '',
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
