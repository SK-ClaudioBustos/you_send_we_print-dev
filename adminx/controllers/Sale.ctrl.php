<?php
class SaleCtrl extends CustomCtrl {
	protected $mod = 'Sale';
	protected $class = 'SaleProduct';


	protected function run_default($args, $action) {
		switch ($action) {
			case 'download': 		$this->authorize('run_download', $args, false); break;

			case 'ajax_action': 	$this->authorize('run_ajax_action', $args, false); break;
			case 'ajax_date': 		$this->authorize('run_ajax_date', $args, false); break;
			case 'ajax_comment': 	$this->authorize('run_ajax_comment', $args, false); break;

			case 'user':	 		$this->authorize('run_multiple', $args, "perm:{$this->mod_key}_list"); break;

			default:
				if ($action) {
					$this->run_not_found($args);
				} else {
					$this->authorize('run_multiple', $args, "perm:{$this->mod_key}_list");
				}
		}
	}


	protected function run_multiple($args = []) {
		$title = $this->lng->text('object:multiple');

		if ($user_id = (int)array_shift($args)) {
		}

		$body_id = "body_{$this->mod_key}s";

		$date_from = ($user_id) ? $this->utl->date_modify(date('Y-m-d'), '-1 year') : $this->utl->date_modify(date('Y-m-d'), '-15 day');
		$date_to = date('Y-m-d');

		$sources = array('' => '[' . $this->lng->text('form:all') . ']', 'yswp' => 'YouSendWePrint.com', 'wp' => 'WorkProcess');

		$page_args = array(
				'meta_title' => $title,
				'title' => $title,
				'body_id' => $body_id,
				'user_id' => $user_id,
				'status' => $this->app->status,
				'date_from' => $date_from,
				'date_to' => $date_to,
				'sources' => $sources,
			);
		$page_args = (is_array($args)) ? array_merge($page_args, $args) : $page_args;

		$content = $this->tpl->get_view("{$this->mod_key}/{$this->mod_key}s", $page_args, true);
		$page_args = array_merge($page_args, $content);
		$this->tpl->page_draw($page_args);
	}

	protected function run_single($object, $args = false) {
		$sale = new Sale($object->get_sale_id());

		if ($sale->get_id()) {
			$sale_url = $this->cfg->setting->frontend . '/order/' . $sale->get_hash();
			$invoice_url = $this->cfg->setting->frontend . '/invoice/' . $sale->get_hash();
			$work_order_url = $this->cfg->setting->frontend . '/work-order/' . $sale->get_hash();

			$date_sold = $this->date_format($sale->get_date_sold(), false, 'm/d/Y  g:i A');
			$date_confirm = ($object->get_date_confirm() != '0000-00-00 00:00:00') ? $this->date_format($object->get_date_confirm(), false, 'm/d/Y  g:i A') : '-';
			$date_due = ($object->get_date_due() != '0000-00-00 00:00:00') ? $this->date_format($object->get_date_due()) : '-';

			$bill_address = new SaleAddress();
			$bill_address->retrieve_by_sale($sale->get_id(), $bill_address->address_type_enum('bill'));

			$shipping = new SaleShipping();
			$ship_address = new SaleAddress();
			$ship_address->retrieve_by_sale($sale->get_id(), $ship_address->address_type_enum('ship'));

			$shipping->retrieve_by_sale($object->get_sale_id());
			$shipping_by = $this->lng->text('sale:sale');

			$items = new Item();
			$items->set_paging(1, 0, '`item_id` ASC');
			while($items->list_paged()) {
				$item_arr[$items->get_id()] = (($items->get_item_code()) ? '[' . $items->get_item_code() . '] ' : '') . $items->get_title();
			}

			$images = new Image();
			$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$object->get_id()}"));

			$img_proofs = $this->get_proofs($object->get_id());
			$proof = new Proof();

			$page_args = array_merge($args, array(
					'sale' => $sale,
					'sale_product_wp' => $sale_product_wp,
					'date_sold' => $date_sold,
					'date_confirm' => $date_confirm,
					'date_due' => $date_due,
					'wholesaler' => $wholesaler,
					'bill_address' => $bill_address,
					'ship_address' => $ship_address,
					'shipping' => $shipping,
					'shipping_by' => $shipping_by,
					'items' => $item_arr,
					'images' => $images,
					'proofs' => $img_proofs,
					'proof' => $proof,
					'sale_url' => $sale_url,
					'invoice_url' => $invoice_url,
					'work_order_url' => $work_order_url,
					'user' => $this->app->user,
				));
			parent::run_single($object, $page_args);

		} else {
			$this->run_not_found($args);

		}
	}

	protected function run_download($args) {
		// TODO: file_exist
		$folder = array_shift($args);
		$file = array_shift($args);
		$filename = $this->cfg->setting->img_root . '/sale/' . $folder . '/' . $file;

		echo $this->tpl->get_view('sale/download', array('filename' => $filename));
	}

	protected function run_ajax_date($args) {
		if ($id = array_shift($args)) {
			$date_due = $this->request_var('date_due', '');

			$sale_product = new SaleProduct();
			$sale_product->update_fields($id, 'date_due', $date_due);
		}

	}

	protected function run_ajax_comment($args) {
		if ($id = $this->request_var('id', 0)) {
			$field = $this->request_var('field', '');
			$comment = $this->request_var('comment', '', true);

			if ($field == 'comment') {
				$sale_product = new SaleProduct();
				$sale_product->update_fields($id, 'comment', $comment);
			} else {
				$sale_shipping = new SaleShipping();
				$sale_shipping->update_fields($id, 'shipping_comment', $comment);
			}
		}

	}

	protected function run_ajax_action($args) {
		if (($id = array_shift($args)) && ($action = $this->request_var('action', '', true))) {

			$sale_product = new SaleProduct($id);
			switch ($action) {
				case 'ac_confirm':
					// not used
				case 'ac_production':
					$sale_product->set_status('st_production');
					$sale_product->update();
					break;

				case 'ac_complete':
					$sale_product->set_status('st_done');
					$sale_product->update();
					break;

				case 'ac_deliver':
					$sale_product->set_status('st_delivered');
					$sale_product->update();
					break;

				case 'ac_close':
					$sale_product->set_status('st_closed');
					$sale_product->update();
					break;

				case 'ac_suspend':
					$sale_product->set_status('st_suspended');
					$sale_product->update();
					break;

				case 'ac_cancel':
					$sale_product->set_status('st_cancelled');
					$sale_product->update();
					break;

				default:
			}

			$result = array(
					'status' => $sale_product->get_status(),
					'status_history' => $sale_product->get_status_history(), //json_decode($sale_product->get_status_history(), true),
					'actions' => $this->app->actions[$sale_product->get_status()],
					'sale_product_id' => $id,
				);

			header("Content-type: application/json");
			echo json_encode($result);
		}
	}

	protected function run_ajax_jqgrid($args = false) {
		$sortfield = ($field = $this->request_var('sidx', '')) ? $field : 'sale_product_id';
		$sortorder = $this->request_var('sord', '');
		$sort = $sortfield . ' ' . $sortorder;

		// filter
		if ($user_id = $this->request_var('user_id', 0)) {
			// ws sales
			$filter = array(
					"`SL`.`user_id` = {$user_id}",
					"SL.`active` = 1",
				);

		} else if ($sale_id = $this->request_var('sale_id', 0)) {
			$filter = array("`sale_id` = {$sale_id}");

		} else if ($sale_product_id = $this->request_var('sale_product_id', 0)) {
			$filter = array("`sale_product_id` = {$sale_product_id}");

		} else if ($job_id = $this->request_var('job_id', 0)) {
			$filter = array("`job_id` = {$job_id}");

		} else {
			$data = array(
					'from' => $this->request_var('date_from', ''),
					'to' => $this->request_var('date_to', ''),
					'status' => $this->request_var('status', ''),
					'client' => $this->request_var('client', '', true),
				);

			$filter = array();
			if ($data['from']) {
				$from = $this->date_format($data['from'], false, 'Y-m-d', 'm/d/Y');
				$filter[] = "`date_sold` >= '{$from}'";
			}
			if ($data['to']) {
				$to = $this->date_format($data['to'], false, 'Y-m-d', 'm/d/Y');
				$filter[] = "`date_sold` <= '{$to} 23:59:59'";
			}
			if ($data['status']) {
				$in = "'" . str_replace("-", "', '", $data['status']) . "'";
				$filter[] = "`tbl_sale_product`.`status` IN ({$in})";
			}
			if ($data['client']) {
				$filter[] = "(`SA`.`last_name` LIKE '%{$data['client']}%' OR `WS`.`company` LIKE '%{$data['client']}%')";
			}
			if ($source = $this->request_var('source', '')) {
				$filter[] = "`source` = '{$source}'";
			}
			if (!sizeof($filter)) {
				$filter = false;
			}

		}

		$spec = array(
				'page' => $this->request_var('page', 1),
				'limit' => $this->request_var('rows', 100),
				'filter' => $filter,
				'sort' => $sort,
			);

		$this->set_cookie('sale-grid', json_encode($spec), time()+60*60);

		$sale_products = new SaleProduct();
		$sale_products->set_paging($spec['page'], $spec['limit'], $spec['sort'], $spec['filter']);
		$row_count = $sale_products->list_count();
		$page_count = ($row_count && $spec['limit']) ? ceil($row_count / $spec['limit']) : 0;

		$rows = array();
		$i = 0;
		while($sale_products->list_paged()) {
	  		$row = array(
	  				'id' => $sale_products->get_id(),
	  				'cell' => $this->get_row($sale_products),
	  			);
			$rows[] = $row;
			$i++;
		}

		header("Content-type: application/json");
		echo json_encode(array(
				'page' => $spec['page'],
				'total' => $page_count,
				'records' => $row_count,
				'rows' => $rows
			));
	}


	protected function get_row($sale_products) {
		return array(
	  			'',
				sprintf('%06d', $sale_products->get_sale_id()) . ' | ' . $this->date_format($sale_products->get_date_sold(), false, 'm/d/Y  g:i A') . ' | '
						. (($ws = $sale_products->get_company()) ? $ws : $sale_products->get_last_name()),
				sprintf('%06d', $sale_products->get_id()),

				$sale_products->get_status(),
				($sale_products->get_date_due() != '0000-00-00 00:00:00') ? $sale_products->get_date_due() : '',
				($sale_products->get_date_confirm() != '0000-00-00 00:00:00') ? $sale_products->get_date_confirm() : '',

				$sale_products->get_job_name(),
				($sale_products->get_source() == 'wp')
						? sprintf('%06d', $sale_products->get_job_id()) . ' ' . $sale_products->get_product()
						: $sale_products->get_product(),

				($sale_products->get_source() == 'wp') ? '0' : $sale_products->get_quantity(),
				($sale_products->get_source() == 'wp') ? '0' : $sale_products->get_total_sqft(),
				$sale_products->get_product_total(),
  			);
	}

	protected function run_save($args = []) {
		// save proof
		if ($this->request_var('action', '') == 'proof') {

			ini_set('max_execution_time', 300);

			$proof_upload = new FileUpload();
			$proof_upload->set_field('filename');

			if ($proof_upload->is_uploaded()) {

				$data = array(
						'sale_product_id' => $this->request_var('sale_product_id', 0),
						'sale_id' => $this->request_var('sale_id', 0),
						'image_id' => $this->request_var('image_id', 0),
						'description' => $this->request_var('description', '', true),
					);

				$folder = $this->cfg->setting->img_root . '/sale/' . sprintf('%08d', $data['sale_id']);
				if (!file_exists($folder)) {
					@mkdir($folder, 0777, true);
				}

				$filename = $proof_upload->get_original_name();
				$image_size = number_format($proof_upload->get_size() / 1024, 2);

				$proof = new Proof();
				$proof->set_sale_product_id($data['sale_product_id']);
				$proof->set_image_id($data['image_id']);
				$proof->set_description($data['description']);
				$proof->set_filename($filename);
				$proof->set_size($image_size);
				$proof->set_active(1);
				$proof_id = $proof->update();

				$newname = sprintf('p%08d', $data['sale_product_id']) . '_' . sprintf('%08d', $proof_id);

				$proof_upload->set_extensions($this->cfg->setting->img_extensions);
				$proof_upload->set_folder($folder);
				$proof_upload->set_filename($newname);

				if (!$proof_upload->save(true)) {
					echo $proof_upload->get_error(); // << Ver

				} else {
					$proof->set_newname($newname . '.' . $proof_upload->get_extension());
					$proof->set_md5($proof_upload->get_md5());

					$this->save($proof, $error, $data);
				}

			} else {
				// no image?
			}

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function save(&$object, $error, $data) {
		if (sizeof($error)) {
			$error_msgs = $this->lng->all();
			$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

			$tmp_var = 'tmp_' . strtolower($this->app->module_key);

			$_SESSION[$tmp_var] = serialize($object);
			$_SESSION['error_msg'] = (sizeof($error)) ? implode('<br />', $error_msg) : '';

			$go_success = $this->app->go($this->app->module_key, false, '/edit/' . $object->get_sale_product_id() . '#tab_1_5');
			header('Location: ' . $go_error);
			exit;

		} else {
			// save the record
			$object->update();

			// verify if all proof are ready
			$sale_product = new SaleProduct($data['sale_product_id']);
			if ($sale_product->all_proof_ready()) {
				if ($sale_product->get_status() != 'st_wait_appr') {
					// update status
					$sale_product->set_status('st_wait_appr');
					$sale_product->set_status_customer('st_wait_appr');
					$sale_product->update();

					// notify customer
					$sale = new Sale($sale_product->get_sale_id());
					$bill_address = new SaleAddress();
					$bill_address->retrieve_by_sale($sale->get_id(), $bill_address->address_type_enum('bill'));

					$url = $this->cfg->setting->frontend . '/order/' . $sale->get_hash();

					$views = $this->tpl->get_view('_email/proof_ready', array(
							'name' => $bill_address->get_last_name(),
							'url' => $url,
						));

					$this->notify(
							array($this->app->notify_yswp_email => $this->app->notify_yswp_name),
							array($bill_address->get_email() => $bill_address->get_last_name()),
							$views['subject'], $views['body']
						);
				}
			}

			$_SESSION['success_msg'] = $this->lng->text('form:saved');

			$go_success = $this->app->go($this->app->module_key, false, '/edit/' . $object->get_sale_product_id() . '#tab_1_5');
			header('Location: ' . $go_success);
			exit;
		}
	}

	private function get_proofs($sale_product_id) {
		$images = new Image();
		$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$sale_product_id}"));

		$img_proofs = array();

		while($images->list_paged()) {
			$img_proofs[(string)$images->get_id()] = array();

			$proofs = new Proof();
			$proofs->set_paging(1, 0, array('`image_id` ASC', '`proof_id` DESC'), array("`sale_product_id` = {$sale_product_id}", "`image_id` = {$images->get_id()}"));

			while($proofs->list_paged()) {
				$img_proofs[(string)$images->get_id()][] = $proofs->to_array();
			}
		}

		return $img_proofs;
	}

}
?>