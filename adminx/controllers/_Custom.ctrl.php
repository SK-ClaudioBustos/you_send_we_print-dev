<?php
abstract class CustomCtrl extends BaseCtrl {
	protected $mod = '';
	protected $mod_key = '';
	protected $class = '';


	public function run($args = array()) {
		$this->class = ($this->class) ? $this->class : $this->mod;
		$this->mod_key = strtolower($this->mod);

		//$action = array_shift($args);
		$action = $this->get_url_arg($args, '');
		switch ($action) {
			case 'new':			$this->authorize('run_new', $args, "perm:{$this->mod_key}_edit"); break;
			case 'edit': 		$this->authorize('run_edit', $args, "perm:{$this->mod_key}_view"); break; // <<<< perm view
			case 'delete': 		$this->authorize('run_delete', $args, "perm:{$this->mod_key}_edit"); break;
			case 'activate': 	$this->authorize('run_activate', $args, "perm:{$this->mod_key}_edit"); break;

			case 'save': 		$this->authorize('run_save', $args, "perm:{$this->mod_key}_edit"); break;
			case 'download':	$this->authorize('run_download', $args, "perm:{$this->mod_key}_edit"); break;

			case 'export': 		$this->authorize('run_export', $args, "perm:{$this->mod_key}"); break;
			case 'ajax_jqgr': 	$this->authorize('run_ajax_jqgrid', $args, "perm:{$this->mod_key}"); break;

			default: 			$this->run_default($args, $action);
		}
	}


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function authorize($method, $args = false, $perm = false) {
		if (!$perm || $this->app->user->perm($perm)) {
//echo 'yes';
//exit;
			$this->{$method}($args);
		} else {
//echo 'no ' . $perm;
//exit;
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	protected function run_multiple($args = array()) {
		$title = $this->lng->text('object:multiple');
		$body_id = "body_{$this->mod_key}s";

		$page_args = array('meta_title' => $title, 'title' => $title, 'body_id' => $body_id);
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}
		$content = $this->tpl->get_view("{$this->mod_key}/{$this->mod_key}s", $page_args, true);
		$page_args = array_merge($page_args, $content);
		$this->tpl->page_draw($page_args);
	}


	protected function run_new($args = array()) {
		$tmp_var = 'tmp_' . strtolower($this->app->module_key);
		if (isset($_SESSION[$tmp_var])) {
			$object = unserialize($_SESSION[$tmp_var]);
			unset($_SESSION[$tmp_var]);
		} else {
			$object = new $this->class();
		}
		$this->run_single($object, $args);
	}

	protected function run_edit($args = array()) {
		$tmp_var = 'tmp_' . strtolower($this->app->module_key);
		//$id = array_shift($args);
		$id = $this->get_url_arg($args, 0);

		if (isset($_SESSION[$tmp_var])) {
			$object = unserialize($_SESSION[$tmp_var]);
			unset($_SESSION[$tmp_var]);
		} else {
			$object = new $this->class();
			$object->retrieve($id, false);
		}
		$this->run_single($object, $args);
	}

	protected function run_single($object, $args = array()) {
		$meta_title = $this->lng->text('object:single') . ': ' . (($object->get_id()) ? $object->get_string() : '[' . $this->lng->text('object:new') . ']');
		$title = $this->lng->text('object:single') . ': <em>' . (($object->get_id()) ? $object->get_string() : '[' . $this->lng->text('object:new') . ']') . '</em>';
		$body_id = "body_{$this->mod_key}";

		$page_args = array('meta_title' => $meta_title, 'title' => $title, 'object' => $object, 'body_id' => $body_id);
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}
		$content = $this->tpl->get_view("{$this->mod_key}/{$this->mod_key}", $page_args, true);
		$page_args = array_merge($page_args, $content);
		$this->tpl->page_draw($page_args);
	}

	protected function run_delete($args) {
		if ($id = $this->get_input('id', 0)) {
			$object = new $this->class();
			$object->delete($id);

			echo 1;
		}
	}

	protected function run_activate($args) {
		//$id = array_shift($args);
		$id = $this->get_url_arg($args, 0);

		$object = new $this->class($id);
		$object->retrieve($id, false);
		$object->set_active(($object->get_active()) ? 0 : 1);
		$object->update();

		//$method = array_shift($args);
		$method = $this->get_url_arg($args, '');
		if ($method == 'ajax') {
			echo $object->get_active();
		} else {
			$_SESSION['success_msg'] = $this->lng->text(($object->get_active()) ? 'form:activated' : 'form:deactivated');
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_save($args = array()) {
		header('Location: ' . $this->app->go($this->app->module_key));
		exit;
	}

	protected function run_download($args) {
		if ($args['file']) {
			// file info is provided by caller
			$file = $args['file'];
			$folder = ($args['folder']) ? '/' . $args['folder'] : '';
			$filename = ($args['filename']) ? $args['filename'] : $args['file'];
			$path = $this->cfg->path->data . (($folder) ? '/' . $folder : '') . '/' . $file;

		} else {
			// expect $args = array('folder_1', 'folder_n', 'file');
			if (sizeof($args)) {
				$file = array_pop($args);
				$folder = implode('/', $args);
			}
			$filename = $file;
			$path = $this->cfg->path->data . (($folder) ? '/' . $folder : '') . '/' . $file;
		}

		if (file_exists($path)) {
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($path));
		    readfile($path);
		    exit;

		} else {
			// ?
		}
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $return_data = false, $limit_override = 100) {
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

				foreach($searchfields as $searchfield) {
					$search[] = "{$searchfield} LIKE '%{$searchdata}%'";
				}

				$filter = array_merge($filter, array('(' . implode(' OR ', $search) . ')'));
			}
		}

		if (!$objects) {
			$objects = new $this->class();
		}
		$objects->set_paging($page, $limit_override != 100 ? $limit_override : $limit, $sort, $filter, $values);

		$row_count = $objects->{$list_count}($active_only, $hide_deleted);
		$page_count = ($row_count && $limit) ? ceil($row_count / $limit) : 0;

		$rows = array();
		while($db_row = $objects->{$list_paged}($active_only, $hide_deleted)) {
			$row = array(
	  				'id' => $objects->{$get_id}(),
	  				'cell' => $this->{$get_row}($objects, $db_row, $args),
				);
			$rows[] = $row;
		}

		$result = array_merge($result, array(
				'page' => $page,
				'total' => $page_count,
				'records' => $row_count,
				'rows' => $rows
			));
		
		if ($return_data) {
			return $result;
		} else {
			header("Content-type: application/json");
			echo json_encode($result);
		}

		//header("Content-type: application/json");
		//echo json_encode($result);
	}

	protected function get_row($objects, $db_row, $args) {
		return array();
	}

	protected function get_list($class, $order, $filter = false, $iterator = 'list_paged') {
		$objects = new $class();
		$objects->set_paging(1, 0, $order, $filter);
		$arr = array();
		while ($objects->{$iterator}()) {
			$arr[] = array((string)$objects->get_id(), $objects->get_string());
		}
		return $arr;
	}

	protected function save(&$object, $error, $action = 'go_list') {
		if (sizeof($error)) {
			$error_msgs = $this->lng->all();
			//$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);
			$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
				return  (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];}, $error);

			$tmp_var = 'tmp_' . strtolower($this->app->module_key);

			$_SESSION[$tmp_var] = serialize($object);
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


	protected function save_blob($folder, $blob, &$filename) {
		//data is like:    data:image/png;base64,asdfasdfasdf
		$splited = explode(',', substr($blob, 5), 2);
		$mime = $splited[0];
		$data = $splited[1];

		$mime_split_without_base64 = explode(';', $mime, 2);
		$mime_split = explode('/', $mime_split_without_base64[0], 2);
		
		$file = '';
		if (count($mime_split) == 2) {
			$extension = $mime_split[1];
			if ($extension == 'jpeg') {
				$extension='jpg';
			}
			$file = $filename . '.' . $extension;
		}

		if (file_put_contents($folder . $file, base64_decode($data)) !== false) {
			$filename = $file;
			return true;
		} else {
			return false;
		}
	}

	protected function save_attach($folder, $field, $extensions, &$filename, &$original_name) {
		$file_upload = new FileUpload();
		$file_upload->set_field($field);
		$file_upload->set_extensions($extensions);
		$file_upload->set_filename($filename);

		if ($file_upload->is_uploaded()) {
			if (!file_exists($folder)) {
				@mkdir($folder, 0777, true);
			}

			$file_upload->set_folder($folder);

			if (!$file_upload->save(true)) {
				return $file_upload->get_error(); // << Ver
			} else {
				$filename .= '.' . $file_upload->get_extension();
				$original_name = $file_upload->get_original_name();
				return true;
			}
		} else {
			return 'no_uploaded_file';
		}
	}


	// export Excel -------------------

	protected function get_export_excel($sheet_title, $headers, $rows, $num_cols = array()) {
		$objPHPExcel = new PHPExcel();

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle($sheet_title);

		$sheet = $objPHPExcel->getActiveSheet();
		foreach($num_cols as $col) {
			$sheet->getStyle($col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		}
		$sheet->setSelectedCell('A1');

		// set headers
		$sheet->fromArray($headers, '', 'A1');

		$last_col = $sheet->getHighestColumn();
		$height = sizeof($headers);
		$sheet->getStyle("A1:{$last_col}{$height}")->applyFromArray(
				array(
					'font'		=> array(
							'size' => 12,
							'bold' => true,
						),
					'borders'	=> array(
							'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array('rgb' => 'D4D4D4'),
								),
					),
					'fill'		=> array(
			        		'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        		'startcolor' => array('rgb' => 'F0F0F0'),
						)
				)
		);


		// set values
		$sheet->fromArray($rows, '', 'A' . (sizeof($headers) + 1));
		$sheet->setSelectedCell('A1');

		// autosize
		//foreach(range('A', $last_col) as $columnID) { // only works for single letter columns
		$last_col_index = PHPExcel_Cell::columnIndexFromString($last_col);
		for($col = 0; $col <= $last_col_index; $col++) {
			$columnID = PHPExcel_Cell::stringFromColumnIndex($col);
			$objPHPExcel->getActiveSheet()
					->getColumnDimension($columnID)
					->setAutoSize(true);
		}

		return $objPHPExcel;
	}

	protected function export_excel($objPHPExcel, $filename, $title, $type) {
		$objPHPExcel->getProperties()
				->setCreator($this->cfg->setting->site)
				->setLastModifiedBy($this->cfg->setting->site)
				->setTitle($title)
				->setSubject($title)
				->setDescription('');

		switch ($type) {
			case 'xls':
				$content_type = 'application/vnd.ms-excel';
				$writer = 'Excel5';
				break;
			case 'xlsx':
				$content_type = 'vnd.openxmlformats-officedocument.spreadsheetml.sheet';
				$writer = 'Excel2007';
				break;
			case 'pdf':
				$content_type = 'application/pdf';
				$writer = 'PDF';
				$renderer_name = PHPExcel_Settings::PDF_RENDERER_TCPDF;
				$renderer_library = $_SERVER['DOCUMENT_ROOT'] . '/supplemvc/lib/tcPDF';
				PHPExcel_Settings::setPdfRenderer($renderer_name, $renderer_library);
				break;
		}

		// app->redirect output to a client’s web browser
		header('Content-Type: application/' . $content_type);
		header('Content-Disposition: attachment;filename="' . $filename . '.' . $type . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $writer);
		$objWriter->save('php://output');
		exit;

	}

}
?>