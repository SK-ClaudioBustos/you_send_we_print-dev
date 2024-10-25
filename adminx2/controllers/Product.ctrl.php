<?php
class ProductCtrl extends AdminCtrl {
	protected $mod = 'Product';


	protected function run_multiple($args) {
		$filter = $page_args = $parent_path = false;

		if (isset($_SESSION[$this->mod_key . ':filter'])) {
			$filter = $_SESSION[$this->mod_key . ':filter'];
		}

		if (isset($_SESSION[$this->mod_key . ':page_args'])) {
			$page_args = $_SESSION[$this->mod_key . ':page_args'];
			$parent_path = $page_args['parent_path'];
		}

		$product = new Product();
		$parents = $product->list_parents();

		$args = array('parents' => $parents, 'filter' => $filter, 'parent_path' => $parent_path, 'page_args' => $page_args);
		parent::run_multiple($args);
	}

	protected function run_single($object, $args = false) {
		$parents = $object->list_parents();

		// remove the product key
		$path = explode('/', $object->get_parent_path());
		$section = $path[1]; // [0] is an empty element

		$parent = false;
		if (substr_count($object->get_parent_path(), '/') == 3) {
			// has parent
			$parent = new Product();
			$parent->retrieve($object->get_parent_id(), false);
		}

		$sizes = $provider_id = $fineart = false;
		if (in_array($object->get_measure_type(), array('standard', 'std-ctm'))
				|| ($parent && in_array($parent->get_measure_type(), array('standard', 'std-ctm')))) {
			$sizes = new Size();
			$sizes->set_paging(1, 0, "`format` ASC, `width` ASC, `height` ASC", array("`product_id` = {$object->get_id()}"));

			$fineart = ($section == 'fine-art');
		}

		if ($object->get_measure_type() == 'standard' || ($parent && $parent->get_measure_type() == 'standard')) {
			$provider_id = $object->get_provider_id();			
		}

		$children = $is_parent = false;
		if ($object->has_children()) {
			$products = new Product();
			$products->set_parent_key($object->get_product_key());

			$children = array();
			while ($products->list_children()) {
				$children[(string)$products->get_id()] = $products->get_title();
			}

			$is_parent = (substr_count($object->get_parent_path(), '/') == 2);
		}

		$measure_types = array(
				'fixed' => 'Fixed',
				'fixd-fixd' => 'Fixed, Fixed Quantities',
				'standard' => 'Standard',
				'custom' => 'Custom',
				'std-ctm' => 'Standard-Custom',
			);

		$featureds = array(
				'new' => 'New',
				'sale' => 'Sale',
			);

		$folder = $this->cfg->url->data . '/artspec/' . sprintf('%06d', $object->get_id()) . '/';
		$attach = json_decode($object->get_attachment(), true);

		$disclaimers = new Document();
		$disclaimers->set_paging(1, 0, array("`title` ASC"), array(
				"`section_key` = 'disclaimer'",
				"`featured` = 0",
			));

		$providers = new Provider();
		$providers->set_paging(1, 0, array("`provider` ASC"));

		$args = array(
				'is_parent' => $is_parent,
				'parents' => $parents,
				'parent' => $parent,
				'children' => $children,
				'folder' => $folder,
				'attach' => $attach,

				'sizes' => $sizes,
				'provider_id' => $provider_id,
				'fineart' => $fineart,

				'measure_types' => $measure_types,
				'providers' => $providers,
				'disclaimers' => $disclaimers,
				'featureds' => $featureds,
			);
		parent::run_single($object, $args);
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

	protected function run_save($args) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'				=> $this->get_input('title', '', true),
					'product_code'		=> $this->get_input('product_code', '', true),
					'parent_path'		=> $this->get_input('parent_path', '', true),
					'measure_type'		=> $this->get_input('measure_type', '', true),
					'disclaimer_id'		=> $this->get_input('disclaimer_id', 0),

					'short_description'	=> $this->get_input('short_description', '', true),
					'description'		=> $this->get_input('description', '', true),
					'details'			=> $this->get_input('details', '', true),
					'specs'				=> $this->get_input('specs', '', true),

					'base_price'		=> $this->get_input('base_price', 0.00),
					'weight'			=> $this->get_input('weight', 0.00),
					'width'				=> $this->get_input('width', 0.00),
					'height'			=> $this->get_input('height', 0.00),

					'price_from'		=> $this->get_input('price_from', 0.00),
					'use_stock'			=> $this->get_input('use_stock', 0),
					'stock_min'			=> $this->get_input('stock_min', 0),

					'discounts'			=> $this->get_input('discounts', '', true),
					'turnarounds'		=> $this->get_input('turnarounds', '', true),

					'label'				=> $this->get_input('label', array( '' ), true),
					'remove'			=> $this->get_input('remove', array( 0 )),

					'provider_id'		=> $this->get_input('provider_id', 0),
					'provider_name'		=> $this->get_input('provider_name', '', true),
					'provider_code'		=> $this->get_input('provider_code', '', true),
					'provider_url'		=> $this->get_input('provider_url', '', true),

					'featured'			=> $this->get_input('featured', '', true),

					'meta_description'	=> $this->get_input('meta_description', '', true),
					'meta_keywords'		=> $this->get_input('meta_keywords', '', true),
					'active'			=> $this->get_input('active', 0),

					'id'				=> $this->get_input('id', 0),
				);
//print_r($data); exit;

			if (isset($_POST['sizes_str'])) {
				$sizes = json_decode(stripslashes($_POST['sizes_str']), true);
//print_r($sizes);
//exit;
			}

			$error_fields = $this->validate_data($data, array(
					'title' 		=> array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class();
			$object->retrieve($data['id'], false);
			$object->set_missing_fields($error_fields);

			// extract the last key
			$pos = strrpos($data['parent_path'], '/') + 1;
			$parent_key = substr($data['parent_path'], $pos);
error_log('101 >>> ' . $data['parent_path'] . ' | ' . $parent_key);

			//if ($parent_key != $object->get_parent_key()) {
				// get parent_id
				$parent = new Product();
				$parent->retrieve_by('product_key', $parent_key, false);
				$object->set_parent_id($parent->get_id());
			//}

			$object->set_product_code($data['product_code']);
			$object->set_title($data['title']);

			$object->set_parent_path($data['parent_path']);
			$object->set_parent_key($parent_key);

			$object->set_measure_type($data['measure_type']);

			$object->set_short_description($data['short_description']);
			$object->set_description($data['description']);
			$object->set_details($data['details']);
			$object->set_specs($data['specs']);

			$object->set_base_price($data['base_price']);
			$object->set_weight($data['weight']);
			$object->set_width($data['width']);
			$object->set_height($data['height']);

			$object->set_price_from($data['price_from']);
			$object->set_use_stock($data['use_stock']);
			$object->set_stock_min($data['stock_min']);
			$object->set_disclaimer_id($data['disclaimer_id']);

			$object->set_discounts($data['discounts']);
			$object->set_turnarounds($data['turnarounds']);

			$object->set_provider_id($data['provider_id']);
			$object->set_provider_name($data['provider_name']);
			$object->set_provider_code($data['provider_code']);
			$object->set_provider_url($data['provider_url']);

			$object->set_featured($data['featured']);
			
			$object->set_meta_description($data['meta_description']);
			$object->set_meta_keywords($data['meta_keywords']);
			$object->set_active($data['active']);

			// Sort Order
			if ($this->get_input('order_changed', 0)) {
				if ($order = $this->get_input('order', '', true)) {
					$item_list = explode('|', $order);
					$i = 1;
					foreach ($item_list as $product_id) {
						$product = new Product();
						$product->update_order($product_id, $i);
						$i++;
					}
				}
			}

			$attach = $this->save_attachs($object, $data);
			$object->set_attachment(json_encode($attach));

			if ($this->save($object, $error, 'return')) {
				if (isset($sizes)) {
					// save sizes (there are changed sizes) TODO: sizes should be a JSON
					$this->save_sizes($object, $sizes);
				}

				$go_success = $this->app->go($this->app->module_key, false, '/edit/' . $object->get_id());

				header('Location: ' . $go_success);
				exit;

			} else {
				if (isset($sizes)) {
					// TODO: serialize sizes
				}

				$go_error = ($id) ? '/edit/' . $id : '/new/';
				$go_error = $this->app->go($this->app->module_key, false, $go_error);
				header('Location: ' . $go_error);
				exit;
			}

		} else {
			// init arrays
			$req_error = array();
			$error = array();
		}
	}

	protected function save_attachs($object, $data) {
		$current = json_decode($object->get_attachment(), true);
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

		return $new;
	}

}
?>