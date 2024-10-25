<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ScaffoldCtrl
 * GENERATION DATE:  11.11.2013
 * -------------------------------------------------------
  *
 */

// TODO: field length


class ScaffoldCtrl extends CustomCtrl {
	protected $mod = 'Scaffold';
	protected $generate_to_root = false;


	protected function run_default($args, $action) {
		switch ($action) {
			case 'ajax_table_info':		$this->authorize('run_ajax_table_info', $args, "perm:{$this->mod_key}_edit"); break;

			default:					$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function run_ajax_table_info($args) {
		if ($table = $this->get_input('table', '', false, 'lower')) {
			$scaffold = new Scaffold();
			$result = array('fields' => $scaffold->get_field_arr($table), 'primary' => $scaffold->get_primary($table));
		} else {
			$result = array('error' => 'ERROR:NO_TABLE');
		}
		header("Content-type: application/json");
		echo json_encode($result);
	}

	protected function get_row($objects, $arg1 = [], $arg2 = []) {
		return array(
  				'',
				$objects->get_controller(),
				$objects->get_class_name(),
				$objects->get_table_name(),
				$objects->get_primary(),
				$objects->get_to_string(),
			);
	}

	protected function run_single($object, $args = false) {
		$tables = new Scaffold();

		if ($table = $object->get_table_name()) {
			$fields = $tables->get_field_arr($table);

			if (!$object->get_id()) {
				if (!$object->get_fields_grid()) {
					$object->set_fields_grid($fields);
				}
				if (!$object->get_fields_form()) {
					$object->set_fields_form($fields);
				}
			}
		} else {
			$fields = array();
		}

		$override = array('retrieve', 'retrieve_by', 'list_count', 'list_paged');

		$page_args = array_merge($args, array(
				'tables' => $tables,
				'fields' => $fields,
				'override' => $override,
			));
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'table_prefix'		=> $this->get_input('table_prefix', '', true),
					'table_name'		=> $this->get_input('table_name', '', true),
					'controller' 		=> $this->get_input('controller', '', true),
					'class_name' 		=> $this->get_input('class_name', '', true),
					'plural' 			=> $this->get_input('plural', '', true),

					'primary' 			=> $this->get_input('primary', '', true),
					'to_string'			=> $this->get_input('to_string', '', true),

					'grid_activation'	=> $this->get_input('grid_activation', 0),

					'fields_grid' 		=> $this->get_input('fields_grid', array( '' ), true),
					'fields_form'		=> $this->get_input('fields_form', array( '' ), true),
					'override'			=> $this->get_input('override', array( '' ), true),

					'generate'			=> $this->get_input('generate', 0),

					'id'				=> $this->get_input('id', 0),
			);
//print_r($data); exit;
			// validate required
			$error_fields = $this->validate_data($data, array(
					'table_name' 	=> array('string', false, 1),
					'class_name' 	=> array('string', false, 1),
					'primary' 		=> array('string', false, 1),
					'to_string' 	=> array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_table_prefix($data['table_prefix']);
			$object->set_table_name($data['table_name']);
			$object->set_controller(($data['controller']) ? $data['controller'] : $data['class_name']);
			$object->set_class_name($data['class_name']);
			$object->set_plural($data['plural']);

			$object->set_primary($data['primary']);
			$object->set_to_string($data['to_string']);

			$object->set_grid_activation($data['grid_activation']);

			$object->set_fields_grid($data['fields_grid']);
			$object->set_fields_form($data['fields_form']);
			$object->set_override($data['override']);

			$object->set_active(1);

			if ($this->save($object, $error, 'return')) {
				$this->generate($object);

				$go_success = $this->app->go($this->app->module_key);
				header('Location: ' . $go_success);
				exit;

			} else {
				$go_error = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
				$go_error = $this->app->go($this->app->module_key, false, $go_error);
				header('Location: ' . $go_error);
				exit;
			}

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function generate($object) {
		$folders = $this->create_folders($object);

		// table columns
		$fields = $properties = array();
		$dont = array('created', 'active', 'deleted'); // TODO: active?

		$has_deleted = $has_created = false;

		foreach($object->get_field_arr() as $field) {
			if ($field != $object->get_primary()) {
				if (in_array($field, $dont)) {
					switch ($field) {
						case 'active':		$has_active = true; break;
						case 'deleted':		$has_deleted = true; break;
						case 'created':		$has_created = true; break;
					}
				} else {
					$fields[] = $field;
					$properties[] = strtolower($field);
				}
			}
		}

		// field types
		$field_types = array();
		while($object->list_fields()) {
			$field_types[$object->get_field_name()] = $object->get_field_type();
		}

		// lists
		$lists = array();
		foreach($properties as $col) {
			if (substr($col, -3, 3) == '_id') {
				$lists[] = substr($col, 0, -3);
			}
		}


		$this->generate_ctrl($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
		$this->generate_lang($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
		$this->generate_class($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
		$this->generate_classdb($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);

		$this->generate_views($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
		$this->generate_css($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
		$this->generate_js($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted);
	}

	protected function create_folders($object) {
		if ($this->generate_to_root) {
			$module_folder = $this->cfg->path->root;
		} else {
			$module_folder = "{$this->cfg->path->data}/scaffold/{$object->get_controller()}";
		}

		if (!file_exists($module_folder)) {
			mkdir($module_folder, 0755, true);
		}

		$admin_folder = "{$module_folder}{$this->cfg->app_folder}";
		if (!file_exists($admin_folder)) {
			mkdir($admin_folder, 0755);
		}

		$lang_folder = "{$admin_folder}/language/{$this->cfg->setting->language}";
		if (!file_exists($lang_folder)) {
			mkdir($lang_folder, 0755, true);
		}

		$ctrl_folder = "{$admin_folder}/controllers";
		if (!file_exists($ctrl_folder)) {
			mkdir($ctrl_folder, 0755);
		}

		$folder = strtolower($object->get_controller());
		$views_folder = "{$admin_folder}/views/default/{$folder}";
		if (!file_exists($views_folder)) {
			mkdir($views_folder, 0755, true);
		}

		$model_folder = "{$module_folder}/model";
		if (!file_exists($model_folder)) {
			mkdir($model_folder, 0755);
		}

		$modeldb_folder = "{$module_folder}/modeldb";
		if (!file_exists($modeldb_folder)) {
			mkdir($modeldb_folder, 0755);
		}

		$folders = array(
				'lang' => $lang_folder,
				'ctrl' => $ctrl_folder,
				'views' => $views_folder,
				'model' => $model_folder,
				'modeldb' => $modeldb_folder,
			);
		return $folders;
	}

	protected function create_file($filename) {
		if (file_exists($filename)) {
			unlink($filename);
		}

		// open file in insert mode
		return fopen($filename, "w+");
	}

	protected function generate_ctrl($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$controller = $object->get_controller();
		$class = $object->get_class_name();
		$class_lower = strtolower($class);

		$filename = "{$folders['ctrl']}/{$controller}.ctrl.php";
		$file = $this->create_file($filename);
		$filedate = date("Y-m-d");

		// some util
		$ths = '$this';
		$id = '$id';
		$val = '$val';
		$row = '$row';
		$dat = '$data';
		$obj = '$object';

//print_r($lists); exit;
		$content = "<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        {$controller}Ctrl
 * GENERATION DATE:  {$filedate}
 * -------------------------------------------------------
  *
 */

class {$controller}Ctrl extends CustomCtrl {";

	$content .= "
	protected $" . "mod = '{$controller}';
	protected $" . "class = '{$class}';\n\n";

	if ($has_created) {
		$properties[] = 'created';
	}

	$content .= '
	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize(\'run_multiple\', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				\'\',
';

	if ($object->get_grid_activation()) {
		$content .= "				$" . "objects->get_active(),\n\n";
	}

	if ($string = $object->get_to_string()) {
		$content .= "				$" . "objects->get_{$string}(),\n";
	}

	$selected = (is_array($object->get_fields_grid())) ? $object->get_fields_grid() : array();

	foreach($selected as $col) {
		if ($col != $object->get_to_string()) {
			if (substr($col, -3, 3) == '_id') {
				// remove _id
				$col = substr($col, 0, -3);
			}
			$content .= "				$" . "objects->get_{$col}(),\n";
		}
	}

	// grid
	$content .= '			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args[\'searchfields\'] = \'' . $object->get_to_string() . '\';

		parent::run_ajax_jqgrid($args, $objects);
	}
';

	// run_single?
	if (sizeof($lists)) {
		$content .= '
	protected function run_single($object, $args = array()) {
		// temp
		$page_args = ';

		foreach ($lists as $list) {
			$content .= '$' . $list . 's = ';
		}
		$content .= 'array();

		/*';

		foreach ($lists as $list) {
			$content .= '
		$' . $list . 's = new ' . ucfirst($list) . '();
		$' . $list . 's->set_paging(1, 0, "`' . $list . '` ASC");
';
		}

		$content .= '
		*/

		$page_args = array(';

		foreach ($lists as $list) {
			$content .= '
				\'' . $list . 's\' => $' . $list . 's,';
		}

		$content .= '
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}
';

	}


	// save
	$content .= '
	protected function run_save($args = []) {
		if ($this->get_input(\'action\', \'\') == \'edit\') {
			$data = array(';

	if ($has_active) {
		$properties[] = 'active';
	}

	foreach($properties as $col) {
		if (strpos($field_types[$col], 'varchar') !== false || strpos($field_types[$col], 'text') !== false) {
			// text / textarea
			$content .= "\n					'{$col}' => {$ths}->get_input('{$col}', '', true),";
		} else if (strpos($field_types[$col], 'date') !== false) {
			// date
			$content .= "\n					'{$col}' => {$ths}->get_input('{$col}', ''),";
		} else {
			// number / boolean
			$content .= "\n					'{$col}' => {$ths}->get_input('{$col}', 0),";
		}
	}

	$content .= "\n					'id' => {$ths}->get_input('id', 0),
				);\n";

	$content .= '
			// validate required
			$error_fields = $this->validate_data($data, array(
					//\'some_string\' => array(\'string\', false, 1),
					//\'some_number\' => array(\'num\', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data[\'email\'], $error_fields, $error);

			$object = new $this->class($data[\'id\']);
			$object->set_missing_fields($error_fields);

			// fill the object';

	foreach($properties as $col) {
		$content .= "\n			{$obj}->set_{$col}({$dat}['{$col}']);";
	}

	$content .= '

			$this->save($object, $error);

		} else {
			header(\'Location: \' . $this->app->go($this->app->module_key));
			exit;
		}
	}

';

	// export
	$content .= '	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`' . $object->get_to_string() . '` ASC", $filter);

		$header = array(
';

	foreach($fields as $col) {
		$col_lower = strtolower($col);
		$content .= "				{$ths}->lng->text('{$class_lower}:{$col_lower}'),\n";
	}

	$content .= '			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(';


	foreach($fields as $col) {
		if (substr($col, -3, 3) == '_id') {
			// remove _id
			$col = substr($col, 0, -3);
		}
		$col_lower = strtolower($col);
		$content .= "\n					{$obj}s->get_{$col_lower}(),";
	}

	$content .= '
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text(\'object:multiple\'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text(\'object:multiple\')), $this->lng->text(\'object:multiple\'), $version);
	}
	';

	$content .= "
}
?>
";
		fwrite($file, $content);

	}

	protected function generate_lang($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$controller = $object->get_controller();
		$controller_lower = strtolower($controller);
		$class = $object->get_class_name();
		$class_lower = strtolower($class);
		$filename = "{$folders['lang']}/{$controller_lower}.lang.php";

		$file = $this->create_file($filename);
		$filedate = date("Y-m-d");

		$content = "<?php
/**
 *
 * -------------------------------------------------------
 * CONTENT:          {$controller} Language File
 * GENERATION DATE:  {$filedate}
 * -------------------------------------------------------
 *
 */


$" . "lang_module = array(
 ";

	$table_short = str_replace($object->get_table_prefix(), '', $object->get_table_name());

	$fields = '';
	$label = mb_convert_case($controller_lower, MB_CASE_TITLE);
	$plural = ($object->get_plural()) ? mb_convert_case($object->get_plural(), MB_CASE_TITLE) : $label . 's';

	$fields .= "		'object:single' => '{$label}',
		'object:multiple' => '{$plural}',
		'object:new' => 'New {$label}',
		'object:single_title' => '{$label} Info',\n\n";

	foreach($properties as $col) {
		$label = str_replace('_id', '', $col);
		$label = str_replace('_', ' ', mb_convert_case($label, MB_CASE_TITLE, "UTF-8"));
		$fields .= "		'{$controller_lower}:{$col}' => '{$label}',\n";
	}

	if ($has_created) {
		$fields .= "		'{$controller_lower}:created' => 'Date Created',\n";
	}
	if ($has_active) {
		$fields .= "		'{$controller_lower}:active' => 'Active',\n";
	}

	$content .= "{$fields}	);

$" . "meta_module = array();
?>
";
		fwrite($file, $content);

	}

	protected function generate_class($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$class = $object->get_class_name();
		$filename = "{$folders['model']}/{$class}.class.php";
		$file = $this->create_file($filename);
		$filedate = date("Y-m-d");

		// some util
		$ths = '$this';
		$id = '$id';
		$val = '$val';
		$row = '$row';

		$content = '';
		$content .= "<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        $class
 * GENERATION DATE:  $filedate
 * -------------------------------------------------------
 *
 */

class $class extends Base {
";

	// VARS ----------------------------------------

	$content .= "\n	// Protected Vars\n";

	$content .= "
	protected $" . "dbClass = '{$class}Db';\n";

	foreach($properties as $col) {
		$content .= "\n	protected $$col = '';";
	}

	// virtual fields
	if (sizeof($lists)) {
		$content .= "\n";
		foreach($lists as $col) {
			if (!in_array($col, $properties)) {
				$content .= "\n	protected $$col = '';";
			}
		}
	}

	// GETTERS -------------------------------------

	$content .= "\n\n\n	// Getters\n";

	if ($object->get_to_string()) {
		$content .= "\n	public function get_string() { return {$ths}->{$object->get_to_string()}; }\n";
	}

	foreach($properties as $col) {
		$content .= "\n	public function get_{$col}() { return {$ths}->{$col}; }";
	}

	// virtual fields
	if (sizeof($lists)) {
		$content .= "\n";
		foreach($lists as $col) {
			if (!in_array($col, $properties)) {
				$content .= "\n	public function get_{$col}() { return {$ths}->{$col}; }";
			}
		}
	}

	// SETTERS -------------------------------------

	$content .="\n\n\n	// Setters\n";

	foreach($properties as $col) {
		$content .= "\n	public function set_{$col}({$val}) { {$ths}->{$col} = {$val}; }";
	}

	// virtual fields
	if (sizeof($lists)) {
		$content .= "\n";
		foreach($lists as $col) {
			if (!in_array($col, $properties)) {
				$content .= "\n	public function set_{$col}({$val}) { {$ths}->{$col} = {$val}; }";
			}
		}
	}

	// FUNCTIONS -----------------------------------

	// Load

	$content .= "\n\n\n	// Public Methods\n";

	$content .= "\n\n	// Protected Methods\n";

	$content .= '
	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->' . $object->get_primary() . ');
';

	foreach($fields as $col) {
		$col_lower = strtolower($col);
		$content .= "\n			{$ths}->set_{$col_lower}({$row}->{$col});";
	}

	if ($has_created) {
		$col = 'created';
		$content .= "\n			{$ths}->set_{$col}({$row}->{$col});";
	}
	if ($has_active) {
		$col = 'active';
		$content .= "\n			{$ths}->set_{$col}({$row}->{$col});";
	}

	// virtual fields
	if (sizeof($lists)) {
		$content .= "\n";
		foreach($lists as $col) {
			if (!in_array($col, $properties)) {
				$col_lower = strtolower($col);
				$content .= "\n			{$ths}->set_{$col_lower}({$row}->{$col});";
			}
		}
	}

	$content .= '
		}
		return $this->row = $row;
	}

}
?>
';

	fwrite($file, $content);

	}

	protected function generate_classdb($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$class = $object->get_class_name();
		$filename = "{$folders['modeldb']}/{$class}Db.class.php";
		$file = $this->create_file($filename);
		$filedate = date("Y-m-d");

		$content = "<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        {$class}Db
 * GENERATION DATE:  {$filedate}
 * -------------------------------------------------------
 *
 */


class {$class}Db extends BaseDb {
";

	$table_short = str_replace($object->get_table_prefix(), '', $object->get_table_name());

	$content .= "
	// Overrided Protected vars
";

	if ($object->get_table_prefix() != 'tbl_') {
		$content .= "
	protected $" . "prefix = '{$object->get_table_prefix()}';";
	}

	$content .= "
	protected $" . "table = '{$table_short}';
	protected $" . "primary = '{$object->get_primary()}';
";

	if ($has_created) {
		$fields[] = 'created';
	}
	if ($has_active) {
		$fields[] = 'active';
	} else {
		$content .= '
	protected $has_active = false;';
	}
	if (!$has_deleted) {
		$content .= '
	protected $has_deleted = false;';
	}

	if (!$has_active || !$has_deleted) {
		$content .= "\n";
	}

	$field = 0;
	$field_str = '';
	foreach($fields as $col) {
		if ($field == 4) {
			$field_str .= "\n			";
			$field = 0;
		}
		$field++;
		$field_str .= "'{$col}' => false, ";
	}
	$field_str = substr($field_str, 0, -2);

	$content .= "
	protected $" . "fields = array(
			{$field_str}
		);
	";


	// override
	if (sizeof($override = $object->get_override())) {

		$content .= "

	// Overrided Protected methods
";

		if (array_search('retrieve', $override) !== false) {
		    // retrieve
			$content .= '
	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				\'select\' => "`{$this->prefix}{$this->table}`.*",
				\'from\' => "`{$this->prefix}{$this->table}`",
				\'where\' => array("`{$this->primary}` = ?"),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}
';
		}

		if (array_search('retrieve_by', $override) !== false) {
		    // retrieve
			$content .= '
	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				\'select\' => "`{$this->prefix}{$this->table}`.*",
				\'from\' => "`{$this->prefix}{$this->table}`",
			);
		return parent::retrieve_by($fields, $values, $active_only, $hide_deleted, $sql_parts);
	}
';
		}

		if (array_search('list_count', $override) !== false) {
		    // list_count
			$content .= '
	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				\'select_count\' => "COUNT(*) AS `record_count`",
				\'from\' => "`{$this->prefix}{$this->table}`",
				\'where\' => array(),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}
';
		}

		if (array_search('list_paged', $override) !== false) {
		    // list_paged
			$content .= '
	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				\'select\' => "`{$this->prefix}{$this->table}`.*",
				\'from\' => "`{$this->prefix}{$this->table}`",
				\'where\' => array(),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}
';
		}

	}


	$content .= "
}
?>
";
		fwrite($file, $content);

	}

	protected function generate_views($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		// multiple

		$controller = $object->get_controller();
		$controller_lower = strtolower($controller);
		$class = $object->get_class_name();
		$class_lower = strtolower($class);
		$filename = "{$folders['views']}/{$controller_lower}s.view.php";
		$file = $this->create_file($filename);

		$content = '<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view(\'_input/search_new\')?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?=$tpl->get_view(\'_output/jqgrid\')?>
		</div>
	</div>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var url_data = \'<?=$app->go($app->module_key, false, \'/ajax_jqgr/\')?>\';
		var url_edt = \'<?=$app->go($app->module_key, false, \'/edit/\')?>\';
		var url_del = \'<?=$app->go($app->module_key, false, \'/delete/\')?>\';
';

		if ($object->get_grid_activation()) {
			$content .= '		var url_act = \'<?=$app->go($app->module_key, false, \'/activate/\')?>\';
';
		}

		$content .= '
		init_multiple();
	</script>
</view>
';

		fwrite($file, $content);

		// single
		$filename = "{$folders['views']}/{$controller_lower}.view.php";
		$file = $this->create_file($filename);

		$content = '<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text(\'object:multiple\')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, \'/save\')?>" class="form form-horizontal ' . $controller_lower . '-form">
		<div class="row">
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-files-o"></i><?=$lng->text(\'object:single_title\')?></div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
';

		if ($has_created) {
			$properties[] = 'created';
		}
		if ($has_active) {
			$properties[] = 'active';
		}

		$selected = (is_array($object->get_fields_grid())) ? $object->get_fields_form() : array();

		foreach($selected as $col) {
			if (strpos($field_types[$col], 'text') !== false) {
				// textarea
				$content .= '							<?=$tpl->get_view(\'_input/textarea\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => $object->get_' . $col . '(),
									\'required\' => true, \'error\' => $object->is_missing(\'' . $col . '\'), \'ta_class\' => \'tinymce\'))?>
';

			} else if (strpos($field_types[$col], 'tinyint(1)') !== false) {
				// check
				$content .= '							<?=$tpl->get_view(\'_input/check\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => 1, \'checked\' => $object->get_' . $col . '()))?>
';

			} else if (strpos($field_types[$col], 'date') !== false) {
				// datepicker
				$content .= '							<?=$tpl->get_view(\'_input/date\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => $object->get_' . $col . '(),
									\'required\' => true, \'error\' => $object->is_missing(\'' . $col . '\')))?>
';

			} else if (strpos($col, '_id') !== false) {
				// select
				$options = '$' . substr($col, 0, -3) . 's';
				$content .= '							<?=$tpl->get_view(\'_input/select\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => $object->get_' . $col . '(),
									\'required\' => true, \'error\' => $object->is_missing(\'' . $col . '\'),
									\'options\' => '. $options . ', \'none_val\' => \'\', \'none_text\' => \'\'))?>
';

			} else if (strpos($field_types[$col], 'decimal') !== false || strpos($field_types[$col], 'int') !== false) {
				// number
				$content .= '							<?=$tpl->get_view(\'_input/text\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => $object->get_' . $col . '(),
									\'required\' => true, \'error\' => $object->is_missing(\'' . $col . '\'), \'width\' => \'small\', \'class\' => \'number\'))?>
';

			} else {
				// text
				$content .= '							<?=$tpl->get_view(\'_input/text\', array(\'field\' => \'' . $col . '\', \'label\' => \'' . $controller_lower . ':' . $col . '\', \'val\' => $object->get_' . $col . '(),
									\'required\' => true, \'error\' => $object->is_missing(\'' . $col . '\')))?>
';
			}
		}

		$content .= '						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text(\'form:save\')?></button>
									<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text(\'form:cancel\')?></a>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		init_single();
	</script>
</view>
';

		fwrite($file, $content);
	}

	protected function generate_css($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$controller = $object->get_controller();
		$controller_lower = strtolower($controller);
		$class = $object->get_class_name();
		$class_lower = strtolower($class);

		// php wrapper
		$filename = "{$folders['views']}/_css.view.php";
		$file = $this->create_file($filename);

		$content = "<?php
$" . "css = array(
		'{$controller_lower}.css'
	);
?>
";
		fwrite($file, $content);

		// css empty file
		$filename = "{$folders['views']}/{$controller_lower}.css";
		$file = $this->create_file($filename);

		$content = " ";
		fwrite($file, $content);

	}

	protected function generate_js($object, $folders, $fields, $field_types, $properties, $lists, $has_created, $has_active, $has_deleted) {
		$controller = $object->get_controller();
		$controller_lower = strtolower($controller);
		$class = $object->get_class_name();
		$class_lower = strtolower($class);

		// php wrapper
		$filename = "{$folders['views']}/_scripts.view.php";
		$file = $this->create_file($filename);

		$content = "<?php
$" . "js = array(
		'{$controller_lower}.js'
	);
?>
";
		fwrite($file, $content);

		// css empty file
		$filename = "{$folders['views']}/{$controller_lower}.js";
		$file = $this->create_file($filename);

		$content = 'function init_multiple() {
	var _grid;


	$(function() {
		var options = {
				colModel: [
';

		if ($object->get_grid_activation()) {
			$content .= "						{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
						{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },\n\n";
		} else {
			$content .= "						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },\n\n";
		}

		$selected = (is_array($object->get_fields_grid())) ? $object->get_fields_grid() : array();
		if ($string = $object->get_to_string()) {
			if ($object->get_grid_activation()) {
				$content .= "						{ name: '{$string}', index: '{$string}', label: lng_text('{$controller_lower}:{$string}'), width: 200, formatter: render_link_act },\n";
			} else {
				$content .= "						{ name: '{$string}', index: '{$string}', label: lng_text('{$controller_lower}:{$string}'), width: 200, formatter: render_link },\n";
			}
		}

		foreach($selected as $col) {
			if ($col != $object->get_to_string()) {
				if (strpos($field_types[$col], 'datetime') !== false) {
					// datetime
					$content .= "						{ name: '{$col}', index: '{$col}', label: lng_text('{$controller_lower}:{$col}'), width: 120, fixed: true,
							align: 'center', sorttype: 'date', formatter : 'date', formatoptions : { srcformat: 'Y-m-d', newformat : 'm/d/Y H:i' } },\n";
				} else if (strpos($field_types[$col], 'date') !== false) {
					// date
					$content .= "						{ name: '{$col}', index: '{$col}', label: lng_text('{$controller_lower}:{$col}'), width: 120, fixed: true,
							align: 'center', sorttype: 'date', formatter : 'date', formatoptions : { srcformat: 'Y-m-d', newformat : 'm/d/Y' } },\n";
				} else if ((strpos($field_types[$col], 'int') !== false && substr($col, -3, 3) != '_id')) {
					// int
					$content .= "						{ name: '{$col}', index: '{$col}', label: lng_text('{$controller_lower}:{$col}'), width: 90, align: 'right', sorttype: 'int' },\n";
				} else if (strpos($field_types[$col], 'decimal') !== false) {
					// decimal
					$content .= "						{ name: '{$col}', index: '{$col}', label: lng_text('{$controller_lower}:{$col}'), width: 90, align: 'right', sorttype: 'float' },\n";
				} else {
					// text
					$colx = $col;
					if (substr($col, -3, 3) == '_id') {
						// remove _id
						$colx = substr($col, 0, -3);
					}
					$content .= "						{ name: '{$colx}', index: '{$colx}', label: lng_text('{$controller_lower}:{$col}'), width: 160 },\n";
				}

			}
		}

		$content .= "		   		],
				sortname: '{$string}',
			   	sortorder: 'ASC'\n";


		$content .= '
			};

		_grid = init_grid(options);
		init_grid_search(_grid);
	});
}

function init_single() {
	$(function() {
		$(\'.select2\').select2({
			placeholder: lng_text(\'form:select\') + \'...\',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
	});
}
';
		fwrite($file, $content);


	}

}
?>
