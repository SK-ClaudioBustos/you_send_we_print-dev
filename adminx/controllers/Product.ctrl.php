<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductCtrl
 * GENERATION DATE:  2018-06-21
 * -------------------------------------------------------
  *
 */

class ProductCtrl extends CustomCtrl {
	protected $mod = 'Product';
	protected $class = 'Product';


	protected function run_default($args, $action) {
		switch ($action) {
			case 'ajax_upload': 	$this->authorize('run_ajax_upload', $args, "perm:{$this->mod_key}"); break;

			default:				$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		$parent_groups = '';
		if (in_array($objects->get_product_type(), array('product-single', 'product-multiple'))) {
			$parent_groups = $objects->get_groups();

		} else if (in_array($objects->get_product_type(), array('group', 'subproduct'))) {
			$parent_groups = $objects->get_parent();
		}

		$date = date_create($objects->get_price_date());
		$date_f = date_format($date, "m/d/Y") == '11/30/-0001' ? '00-00-0000' : date_format($date, "m/d/Y");

		return array(
				'',
				$objects->get_active(),

				$objects->get_product_code(),
				$objects->get_string(),
				$objects->get_product_type(),
				$objects->get_measure_type(),
				$objects->get_standard_type(),
				$date_f,
				$parent_groups,
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $return = false, $override = false) {
		$args['searchfields'] = array(
				'`tbl_product`.`product_code`', '`tbl_product`.`title`', '`tbl_product`.`product_type`',
				'`tbl_product`.`product_key`', '`PR`.`title`', '`GP`.`title`'
			);
		$args['list_paged'] = 'list_paged_full';
		$args['list_count'] = 'list_count_full';
		$args['active_only'] = false;

		$filter = array();
		$product_id = $this->get_input('product_id', '');
		if ($product_id) {
			$product = new Product();
			$product->retrieve($product_id, false);

			$filter_prod = "`tbl_product`.`product_id` = {$product_id}";
			switch($product->get_product_type()) {
				case 'category':
				case 'product-multiple':
					$filter = array("({$filter_prod} || `tbl_product`.`parent_id` = {$product_id})");
					break;

				case 'group':
					$filter = array("({$filter_prod} || `PG`.`group_id` = {$product_id})");
					break;

				case 'product-single':
					$filter = array($filter_prod);
					break;
			}

			//$filter[] = "`product_id` = '{$product_id}'";
			$_SESSION[$this->mod_key . ':product_id'] = $product_id;
		}
		$args['filter'] = $filter;

		if ($product_id) {
			parent::run_ajax_jqgrid($args, $objects);
		} else {
			$result = parent::run_ajax_jqgrid($args, $objects, true, 0);
			$this->sort_products($result, $this->get_input('page', 1));
			echo json_encode($result);
		}

		//$this->run_ajax_jqgrid2($args, $objects);
	}

	protected function sort_products (&$result, $offset = 1) {
		$rows = $result['rows'];
		$categories = [];
		$groups = [];
		$multiple_products = [];
		$subproducts = [];
		$new_result = [];

		//Get Categiries and groups
		foreach ($rows as $row) {
			if ($row['cell'][8] == '') {
				$categories[$row['cell'][3]] = $row;
				if ($row['cell'][4] == 'category') {
					$groups[$row['cell'][3]] = [];
				}
			} elseif ($row['cell'][4] == 'group') {
				$multiple_products[$row['cell'][3]] = [];
				$subproducts[$row['cell'][3]] = [];
			} elseif ($row['cell'][4] == 'product-multiple') {
				$subproducts[$row['cell'][3]] = [];
			}
		}

		//Get Multiple Products and Subproducts of groups
		foreach ($rows as $row) {
			$parent = explode(' / ', $row['cell'][8])[0];
			if ($row['cell'][4] == 'group') {
				$groups[$row['cell'][8]][] = $row;
			} elseif ($row['cell'][4] == 'product-multiple') {
				$multiple_products[$parent][] = $row;
			} elseif (($row['cell'][4] == 'subproduct') || ($row['cell'][4] == 'product-single')) {
				if (array_key_exists($parent, $subproducts)) {
					$subproducts[$parent][] = $row;
				}
			}
		}
		//var_dump($groups);
		//var_dump($multiple_products);
		//var_dump($subproducts);die;
		foreach ($categories as $key => $row) {
			$new_result[] = $row;
			if ($row['cell'][4] == 'category') {
				array_splice($new_result, count($new_result) , 0, $groups[$key]);
			}
		}

		foreach ($multiple_products as $key => $row) {
			$pos = array_search($key, array_column(array_column($new_result, 'cell'), 3));
			array_splice($new_result, $pos + 1, 0, $row);
		}

		foreach ($subproducts as $key => $row) {
			$pos = array_search($key, array_column(array_column($new_result, 'cell'), 3));
			array_splice($new_result, $pos + 1, 0, $row);
		}
		//var_dump(($result['rows']));die;
		$result['rows'] = array_slice($new_result, $offset*100 -100, 100);
	}
	/*
	protected function run_ajax_jqgrid2($args = array(), $objects = false)
	{
		$page = $this->get_input('page', 1);
		$limit = $this->get_input('rows', 100);

		$active_only = (isset($args['active_only'])) ? $args['active_only'] : true;
		$hide_deleted = (isset($args['hide_deleted'])) ? $args['hide_deleted'] : true;

		$get_row = (isset($args['get_row'])) ? $args['get_row'] : 'get_row';
		$get_id = (isset($args['get_id'])) ? $args['get_id'] : 'get_id';
		$list_count = (isset($args['list_count'])) ? $args['list_count'] : 'list_count';
		$list_paged = (isset($args['list_paged'])) ? $args['list_paged'] : 'list_paged';

		$filter = (isset($args['filter'])) ? $args['filter'] : array();
		$values = (isset($args['values'])) ? $args['values'] : array();

		$result = (isset($args['result'])) ? $args['result'] : array(); // other result to be passed to client

		if ($args['sort']) {
			$sort = $args['sort'];
		} else {
			$sortfield = ($field = $this->get_input('sidx', '')) ? $field : $args['sortfield'];
			$sortorder = ($order = $this->get_input('sord', '')) ? $order : $args['sortorder'];
			$sort = $sortfield . ' ' . $sortorder;
		}

		if ($args['search']) {
			$filter = array_merge($filter, $args['search']);
		} else {
			$searchfields = (isset($args['searchfields'])) ? $args['searchfields'] : false;
			$searchdata = $this->get_input('search', '', true);

			$search = array();
			if ($searchfields && $searchdata) {
				if (!is_array($searchfields)) {
					$searchfields = array($searchfields);
				}

				foreach ($searchfields as $searchfield) {
					$search[] = "{$searchfield} LIKE '%{$searchdata}%'";
				}

				$filter = array_merge($filter, array('(' . implode(' OR ', $search) . ')'));
			}
		}

		$filter = array_merge($filter, ['`tbl_product`.`parent_id` = 0']);

		$objects = new Product();
		$objects_inner = new Product();

		$objects->set_paging($page, $limit, $sort, $filter, $values);

		$row_count = $objects->{$list_count}($active_only, $hide_deleted);
		$page_count = ($row_count && $limit) ? ceil($row_count / $limit) : 0;

		array_pop($filter);

		$rows = array();
		while ($db_row = $objects->{$list_paged}($active_only, $hide_deleted)) {
			$row = array(
				'id' => $objects->{$get_id}(),
				'cell' => $this->{$get_row}($objects, $db_row, $args),
			);
			$rows[] = $row;
			$this->check_children($objects,$rows);
			/*$inner_filter = array_merge($filter, ['`tbl_product`.`parent_id` = ' . $objects->{$get_id}(), '`tbl_product`.`product_type` not in ("category","group")']);
			error_log(json_encode($inner_filter));
			$objects_inner->set_paging($page, $limit, $sort, $inner_filter, $values);
			while ($db_row = $objects_inner->{$list_paged}($active_only, $hide_deleted)) {
				$row = array(
					'id' => $objects->{$get_id}(),
					'cell' => $this->{$get_row}($objects, $db_row, $args),
				);
				$rows[] = $row;
			}*/ /*
		}

		$result = array_merge($result, array(
			'page' => $page,
			'total' => $page_count,
			'records' => $row_count,
			'rows' => $rows
		));

		header("Content-type: application/json");
		echo json_encode($result);
	}
	*/



	protected function run_multiple($args = []) {
		$product_id = false;
		if (isset($_SESSION[$this->mod_key . ':product_id'])) {
		    $product_id = $_SESSION[$this->mod_key . ':product_id'];
		}

		$products = $this->get_parent_list();

		$args = array(
				'products' => $products,
				'product_id' => $product_id,
			);
		parent::run_multiple($args);
	}

	protected function run_download($args) {
		if ($id = $this->get_url_arg($args, 0)) {
			$object = new $this->class($id);
			$page_args = array(
					'file' => $object->get_filename(),
					'filename' => $object->get_original_name(),
					'folder' => 'product',
				);
			if ($object->get_id() && $page_args['file']) {
				parent::run_download($page_args);
			} else {
				// ?
			}
		}
	}

	protected function get_parent_list() {
		$parent_list = array();
		$sep = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		$categories = new Product();
		$categories->set_paging(1, 0, "`product_order` ASC", array("`product_type` = 'category'"));
		while ($categories->list_paged(false)) {
			$parent_list[(string)$categories->get_id()] = $categories->get_title();

			$groups = new Product();
			$groups->set_paging(1, 0, "`product_order` ASC", array(
					"`product_type` = 'group'",
					"`parent_id` = {$categories->get_id()}",
				));

			while ($groups->list_paged(false)) {
				$parent_list[(string)$groups->get_id()] = $sep . $groups->get_title();

				$product_groups = new ProductGroup();
				$product_groups->set_paging(1, 0, "`product_order` ASC", array("`group_id` = {$groups->get_id()}"));

				while ($product_groups->list_paged_product(false)) {
					// use rand token because product could be duplicated
					$parent_list[(string)$product_groups->get_product_id() . '-' . $this->utl->get_token(4)] = $sep . $sep . $product_groups->get_product();
				}
			}
		}

		return $parent_list;
	}

	protected function run_single($object, $args = array()) {
		$product_types = $this->utl->get_property('product_type', array());
		$measure_types = $this->utl->get_property('measure_type', array());
		$standard_types = $this->utl->get_property('standard_type', array());

		// form
		$product_fields = $this->utl->get_property('product_fields', array());

		$item_list = new ItemList();
		$item_list->set_paging(1, 0, "`title` ASC", array("`standard` = 1"));
		$item_lists = array();
		while($item_list->list_paged()) {
			$item_lists[$item_list->get_item_list_key()] = $item_list->get_title();
		}

		$features = array(
				'proof' => $this->lng->text('product:proof'),
				'packaging' => $this->lng->text('product:packaging'),
			);

		$form_lists = array(
				'item_lists' => $item_lists,
				'features' => $features,
			);

		$parent = $children = false;
		switch($object->get_product_type()) {
			case 'category':
				$children = new Product();
				$children->set_paging(1, 0,
						array("`product_order` ASC", "`product_id` ASC"), // for first order
						array("`parent_id` = {$object->get_id()}")
					);
				break;

			case 'group':
				$parents = new Product();
				$parents->set_paging(1, 0, "`title` ASC", array("`product_type` = 'category'"));

				$product_group = new ProductGroup();
				$product_group->set_paging(1, 0, false, array("`group_id` = {$object->get_id()}"));
				$ids = $product_group->list_products(false);

				if ($ids) {
					$children = new Product();
					$children->set_paging(1, 0,
							array("`product_order` ASC", "`product_id` ASC"), // for first order
							array("`product_id` IN ({$ids})"));
				}
				break;

			case 'product-multiple':
				$children = new Product();
				$children->set_paging(1, 0,
						array("`product_order` ASC", "`product_id` ASC"), // for first order
						array("`parent_id` = {$object->get_id()}"));
				// <<<<< no break, continue

			case 'product-single':
				$measure_type = $object->get_measure_type();
				$standard_type = $object->get_standard_type();

				$parents = array();
				$groups = new Product();
				$groups->set_paging(1, 0, array("`parent` ASC", "`title` ASC"), array("`tbl_product`.`product_type` = 'group'"));
				while($groups->list_paged_group(false)) {
					$parents[(string)$groups->get_id()]	= (($groups->get_parent()) ? $groups->get_parent() : $this->lng->text('product:no_category'))
							. ' > ' . $groups->get_title();
				}

				$product_groups = array();
				$product_group = new ProductGroup();
				$product_group->set_paging(1, 0, false, array("`product_id` = {$object->get_id()}"));
				while($product_group->list_paged()) { // TODO: inactive groups?
					$product_groups[(string)$product_group->get_id()] = $product_group->get_group_id();
				}

				$disclaimers = new Document();
				$disclaimers->set_paging(1, 0, array("`title` ASC"), array(
						"`section_key` = 'disclaimer'",
						"`featured` = 0",
					));

				$featureds = $this->utl->get_property('product_featured', array());
				break;

			case 'subproduct':
				$parents = new Product();
				$parents->set_paging(1, 0, "`title` ASC", array("`product_type` = 'product-multiple'"));
				if ($object->get_parent_id()) {
					$parent = new Product();
					$parent->retrieve($object->get_parent_id(), false);
					$measure_type = $parent->get_measure_type();
					$standard_type = $parent->get_standard_type();
				}
				break;
		}

		$folder = $this->cfg->url->data . '/artspec/' . sprintf('%06d', $object->get_id()) . '/';
		$attach = $object->get_attachment();

		$providers = new Provider();
		$providers->set_paging(1, 0, array("`provider` ASC"));

		$provider_id = $sizes = false;
		if (($object->get_product_type() == 'product-single' && $object->get_measure_type() == 'standard')
				|| ($object->get_product_type() == 'subproduct' && $parent && $parent->get_measure_type() == 'standard')) {
			$provider_id = $object->get_provider_id();
		}
//var_dump($object); die();
		if (($object->get_product_type() == 'product-single' && in_array($object->get_measure_type(), array('standard', 'std-ctm','shirts')))
				|| ($object->get_product_type() == 'subproduct' && $parent && in_array($parent->get_measure_type(), array('standard','std-ctm', 'shirts')))
			) {
			$sizes = new Size();
			if ($object->get_measure_type() == 'shirts')
				$sizes->set_paging(1, 0, "`format` ASC", array("`product_id` = {$object->get_id()}"));
			else
				$sizes->set_paging(1, 0, "`format` ASC, `width` ASC, `height` ASC", array("`product_id` = {$object->get_id()}"));
		}


		$page_args = array(
				'parents' => $parents,
				'parent' => $parent,
				'product_groups' => $product_groups,

				'children' => $children,
				'folder' => $folder,
				'attach' => $attach,

				'sizes' => $sizes,
				'provider_id' => $provider_id,

				'measure_type' => $measure_type,
				'standard_type' => $standard_type,

				'measure_types' => $measure_types,
				'standard_types' => $standard_types,
				'product_types' => $product_types,
				'featureds' => $featureds,

				'product_fields' => $product_fields,
				'form_lists' => $form_lists,

				'providers' => $providers,
				'disclaimers' => $disclaimers,
			);

		parent::run_single($object, $page_args);
	}

	protected function run_ajax_upload($args) {
		$folder = $this->cfg->path->data . '/product/';
		$filename = time();

		$result = $this->save_attach($folder, 'file', $this->app->file_extensions, $filename, $original_name);

		if ($result === true) {
			$url = $this->cfg->url->data . '/product/' . $filename;
			header("Content-type: application/json");
			echo json_encode(array('location' => $url));

		} else {
			header('HTTP/1.1 500 Server Error');
		}
	}

	protected function get_form() {
		$product_fields = $this->utl->get_property('product_fields', array());

		$form = array();

		foreach($product_fields as $product_field) {
			if ($product_field['count']) {
				// field multiple -------------------------------------------------------

				// get checked checkboxes
				$checked = $this->get_input('form_' . $product_field['field'], array( 0 ));
				if ($product_field['options']) {
					$lists = $this->get_input('form_' . $product_field['field'] . '_list', array( '' ), true);

					foreach($checked as $idx) {
						$field = array(
								'field' => $product_field['field'] . '-' . $idx,
								'option' => $lists[$idx],
							);
						$form[] = $field;
					}

				} else {
					foreach($checked as $idx) {
						$field = array(
								'field' => $product_field['field'] . '-' . $idx,
							);
						$form[] = $field;
					}
				}

			} else {
				// field single ---------------------------------------------------------

				if ($this->get_input('form_' . $product_field['field'], 0)) {
					$field = array(
							'field' => $product_field['field'],
						);

					if ($product_field['options']) {
						if ($product_field['multiple']) {
							$field['options'] = $this->get_input('form_' . $product_field['field'] . '_list', array( '' ), true);

						} else {
							$field['option'] = $this->get_input('form_' . $product_field['field'] . '_list', '', true);
						}

					}

					$form[] = $field;
				}

			}
		}

		return json_encode($form, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title' => $this->get_input('title', '', true),
					'product_type' => $this->get_input('product_type', '', true),

					'id' => $this->get_input('id', 0),
				);
//var_dump($this); die;
			if ($data['id']) {
				$data = array_merge($data, array(
						'product_code' => $this->get_input('product_code', '', true),
						//'product_key' => $this->get_input('product_key', '', true), // automatic

						'measure_type' => $this->get_input('measure_type', '', true),
						'standard_type' => $this->get_input('standard_type', '', true),
						'product_order' => $this->get_input('product_order', 0),
						'disclaimer_id' => $this->get_input('disclaimer_id', 0),
						'featured' => $this->get_input('featured', '', true),

						'parent_id' => $this->get_input('parent_id', 0),		// groups / subproducts
						'group_id' => $this->get_input('group_id', array( 0 )),	// products

                    	'provider_id' =>  $this->get_input('provider_id',0),		// if provider set
					
						'product_form' => $this->get_input('product_form', '', true),

						'short_description' => $this->get_input('short_description', '', true),
						'description' => $this->get_input('description', '', true),
						'details' => $this->get_input('details', '', true),
						'specs' => $this->get_input('specs', '', true),
						'attachment' => $this->get_input('attachment', '', true),

						'meta_title' => $this->get_input('meta_title', '', true),
						'meta_description' => $this->get_input('meta_description', '', true),
						'meta_keywords' => $this->get_input('meta_keywords', '', true),

						'base_price' => $this->get_input('base_price', 0.00),
						'setup_fee' => $this->get_input('setup_fee', 0.00),
						'minimum' => $this->get_input('minimum', 0.00),
						'price_from' => $this->get_input('price_from', 0.00),

						'width' => $this->get_input('width', 0.00),
						'height' => $this->get_input('height', 0.00),
						'weight' => $this->get_input('weight', 0.00),
						'volume' => $this->get_input('volume', 0),

						'use_stock' => $this->get_input('use_stock', 0),
						'stock_min' => $this->get_input('stock_min', 0),

						'discounts' => $this->get_input('discounts', '', true),
						'turnarounds' => $this->get_input('turnarounds', '', true),
						'sizes' => $this->get_input('sizes', '', true),

						'active' => $this->get_input('active', 0),
						'group_home' => $this->get_input('group_home', 0),

						'label' => $this->get_input('label', array( '' ), true),
						'remove' => $this->get_input('remove', array( 0 )),

						'order_changed' => $this->get_input('order_changed', 0),
						'order' => $this->get_input('order', '', true),
					));

				if (isset($_POST['sizes_str'])) {
					$sizes = json_decode(stripslashes($_POST['sizes_str']), true);
				}
			}

//print_r($sizes);
//exit;
			// validate required
			$error_fields = $this->validate_data($data, array(
					'title' => array('string', false, 1),
					'product_type' => array('string', false, 1),
				));

			// TODO: group must have parent_id?
			if ($data['id'] && $data['product_type'] && in_array($data['product_type'], array('product-single', 'product-multiple'))) {
				$error_fields = array_merge($error_fields, $this->validate_data($data, array(
						'measure_type' => array('string', false, 1),
						'standard_type' => array('string', false, 1),
					)));
			}

			$error = $this->missing_fields($error_fields);

			$object = new $this->class();
			$object->retrieve($data['id'], false);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_title($data['title']);
			$object->set_product_type($data['product_type']);
			// $object->set_product_key($data['product_key']); // automatic

			$object->set_active($data['active']);
			$object->set_group_home($data['group_home']);

			/* if ($data['id'] == 0) {
				$object->set_price_date(date('Y-m-d'));
			} else {
				if ($object->get_base_price() != $data['base_price'] ||
					$object->get_minimum() != $data['minimum'] ||
					$object->get_price_from() != $data['price_from']) {
					$object->set_price_date(date('Y-m-d'));
				}
			} */
			$object->set_price_date(date('Y-m-d'));

			$process_groups = false;
			if ($object->get_id()) {
				$object->set_product_code($data['product_code']);

				$object->set_measure_type($data['measure_type']);
				$object->set_standard_type($data['standard_type']);
				$object->set_disclaimer_id($data['disclaimer_id']);
				$object->set_featured($data['featured']);

				$object->set_parent_id($data['parent_id']);

				$object->set_short_description($data['short_description']);
				$object->set_description($data['description']);
				$object->set_specs($data['specs']);
				$object->set_details($data['details']);
				$object->set_attachment($data['attachment']);

				$object->set_meta_title($data['meta_title']);
				$object->set_meta_description($data['meta_description']);
				$object->set_meta_keywords($data['meta_keywords']);

				$object->set_base_price($data['base_price']);
				$object->set_setup_fee($data['setup_fee']);
				$object->set_minimum($data['minimum']);
				$object->set_price_from($data['price_from']);

				$object->set_width($data['width']);
				$object->set_height($data['height']);
				$object->set_weight($data['weight']);
				$object->set_volume($data['volume']);

				$object->set_discounts($data['discounts']);
				$object->set_turnarounds($data['turnarounds']);

				$object->set_use_stock($data['use_stock']);
				$object->set_stock_min($data['stock_min']);

				// children sort order
				$i = 1;
				if ($data['order_changed']) {


					if ($data['order']) {
						$product_list = explode('|', $data['order']);
						$product = new Product();
						foreach ($product_list as $product_id) {
							$product->update_order($product_id, $i);
							$i++;
						}
					}

				} else {
					// order didn't change, save it anyway
					$children = new Product();
					$children->set_paging(1, 0,
							array("`product_order` ASC", "`product_id` ASC"), // for first order
							array("`parent_id` = {$object->get_id()}")
						);

					while($children->list_paged(false)) {
						$children->update_order($children->get_id(), $i);
						$i++;
					}
				}

				//$attach = $this->save_attachs($object, $data);
				//$object->set_attachment(json_encode($attach));

				// categories
				if ($data['product_type'] == 'category') {
					$object->set_product_order($data['product_order']);

				//} else if ($data['product_type'] == 'subproduct') {
				//    $parent = new Product();
				//    $parent->retrieve($data['parent_id'], false);

				//    if ($parent->get_measure_type() == 'fixd-fixd') {
				//        // discounts are fixed quantities

				//    }
				}

				// groups
				if (in_array($data['product_type'], array('product-single', 'product-multiple'))) {
					$group_ids = array();
					if ($object->get_id() && in_array($data['product_type'], array('product-single', 'product-multiple'))) {
						$product_group = new ProductGroup();
						$product_group->set_paging(1, 0, false, array("`product_id` = {$object->get_id()}"));
						if ($ids = $product_group->list_groups(false)) {
							$group_ids = explode(',', $ids);
						}
					}
					// TODO: serialize groups?
					$process_groups = true;
				}

				// form
				$form = $this->get_form();
				$object->set_form($form);
			}
//print_r($object->to_array());
//exit;
			if ($this->save($object, $error, 'return')) {
				// groups

				if (in_array($data['product_type'], array('product-single', 'product-multiple'))) {
					if ($process_groups) {
						foreach($group_ids as $group_id) {
							if (!in_array($group_id, $data['group_id'])) {
								// removed
								$product_group = new ProductGroup();
								$product_group->delete_by(array('product_id', 'group_id'), array($object->get_id(), $group_id));
							}
						}
						foreach($data['group_id'] as $group_id) {
							if (!in_array($group_id, $group_ids)) {
								// added
								$product_group = new ProductGroup();
								$product_group->set_product_id($object->get_id());
								$product_group->set_group_id($group_id);
								$product_group->update();
							}
						}
					}
				}

				// sizes
				if (isset($sizes)) {
					// (there are changed sizes) TODO: sizes should be a JSON
					$this->save_sizes($object, $sizes);
				}
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

	protected function save_sizes($object, $sizes) {
		foreach ($sizes as $id => $size_arr) {
			$update = false;

			if ((int)$id < 0) {
				// new size
				$size =  new Size();
				$update = true;

			} else {
				// edit
				$size =  new Size((int)$id);

				if ($size_arr['deleted']) {
					$size->delete((int)$id);

				} else {
					$update = true;
				}
			}

			if ($update) {
				$size->set_product_id($object->get_id());
				$size->set_format($size_arr['format']);
				$size->set_width($size_arr['width']);
				$size->set_height($size_arr['height']);

				$size->set_price_a($size_arr['price_a']);
				$size->set_price_b($size_arr['price_b']);
				$size->set_price_c($size_arr['price_c']);
				$size->set_price_d($size_arr['price_d']);

				$size->set_provider_price($size_arr['provider_price']);
				$size->set_provider_weight($size_arr['provider_weight']);

				$size->update();
			}
		}
	}

	protected function save_attachs($object, $data) {
		$current = $object->get_attachment();
//print_r($object->to_array());
//exit;
		if (!is_array($current)) {
			$current = array();
		}
		$new = array();
		$folder = $this->cfg->path->data . '/artspec/' . sprintf('%06d', $object->get_id()) . '/';

		for($i = 1; $i <= 4; $i++) {
			if (in_array($i, $data['remove'])) {
				// don't carry to new, remove file
				@unlink($folder . $current[(string)$i]['file']);

			} else {
				$file_upload = new FileUpload();
				$file_upload->set_extensions($this->app->spec_extensions);
				$file_upload->set_field('attach' . $i);
				if ($file_upload->is_uploaded()) {
					// upload/replace
					$file_upload->set_folder($folder);
					//$file_upload->set_filename($filename);

					if (!$file_upload->save(true)) {
						error_log('File Upload Error: ' . $file_upload->get_error()); // << Ver
					} else {
						$index = sizeof($new) + 1;
						$new[(string)$index] = array(
								'label' => $data['label'][$i - 1], // zero based
								'file' => $file_upload->get_filename() . '.' . $file_upload->get_extension(),
							);
					}

				} else if (isset($current[(string)$i])) {
					// copy file, replace label, compact
					$index = sizeof($new) + 1;
					$new[(string)$index] = array(
							'label' => ($label = $data['label'][$i - 1]) ? $label : $current[(string)$i]['label'],
							'file' => $current[(string)$i]['file'],
						);
				}
			}
		}
//print_r($new);
//exit;
		return $new;
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`product_id` ASC", $filter);

		$header = array(
				$this->lng->text('product:product_code'),
				$this->lng->text('product:product_key'),
				$this->lng->text('product:parent_id'),
				$this->lng->text('product:parent_key'),
				$this->lng->text('product:path'),
				$this->lng->text('product:product'),
				$this->lng->text('product:form'),
				$this->lng->text('product:short_description'),
				$this->lng->text('product:description'),
				$this->lng->text('product:details'),
				$this->lng->text('product:specs'),
				$this->lng->text('product:meta_title'),
				$this->lng->text('product:meta_description'),
				$this->lng->text('product:meta_keywords'),
				$this->lng->text('product:product_order'),
				$this->lng->text('product:measure_type'),
				$this->lng->text('product:standard_type'),
				$this->lng->text('product:base_price'),
				$this->lng->text('product:width'),
				$this->lng->text('product:height'),
				$this->lng->text('product:weight'),
				$this->lng->text('product:volume'),
				$this->lng->text('product:discounts'),
				$this->lng->text('product:turnarounds'),
				$this->lng->text('product:attachment'),
				$this->lng->text('product:minimum'),
				$this->lng->text('product:price_from'),
				$this->lng->text('product:use_stock'),
				$this->lng->text('product:stock_min'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_product_code(),
					$objects->get_product_key(),
					$objects->get_parent(),
					$objects->get_parent_key(),
					$objects->get_path(),
					$objects->get_product(),
					$objects->get_form(),
					$objects->get_short_description(),
					$objects->get_description(),
					$objects->get_details(),
					$objects->get_specs(),
					$objects->get_meta_title(),
					$objects->get_meta_description(),
					$objects->get_meta_keywords(),
					$objects->get_product_order(),
					$objects->get_measure_type(),
					$objects->get_standard_type(),
					$objects->get_base_price(),
					$objects->get_width(),
					$objects->get_height(),
					$objects->get_weight(),
					$objects->get_volume(),
					$objects->get_discounts(),
					$objects->get_turnarounds(),
					$objects->get_attachment(),
					$objects->get_minimum(),
					$objects->get_price_from(),
					$objects->get_use_stock(),
					$objects->get_stock_min(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

	protected function check_children(Product $object, array &$rows) {
		$row = array(
			'id' => $object->get_id(),
			'cell' => $this->get_row($object, $object),
		);
		$rows[] = $row;
		if ($object->has_children()) {
			while ($object->list_children()) {
				$this->check_children($object, $rows);
			}
		}
	}
}
?>
