<?php
class CssCtrl extends SystemCtrl {

	public function run($args) {
		$root_path = $this->cfg->path->views . '/' . $this->cfg->setting->viewtype . '/';

		$mod = '';
		$arg = array_shift($args);
		$arg = explode('.', $arg);
		$arg = $arg[0];

		$group = [];
		$missing = [];

		if (is_numeric($arg)) {
			$version = $arg;
		} else {
			$mod = $arg;
			$version = array_shift($args);
		}

		if ($mod) {
			$path = $root_path . strtolower($mod) . '/';
		} else {
			$path = $root_path . '_style/';
		}

		$file = $path . '_css.view.php';
		if (file_exists($file)) {
			include_once($file);

			$group = array();
			$missing = array();
			clearstatcache();

			foreach($css as $file) {
				$path_file = $path . $file;
				if (file_exists($path_file)) {
					if (filesize($path_file)) {
					$group[] = $path_file;
					}

				} else {
					// missing file
					$missing[] = RelativePath::getRelativePath($path_file);
				}
			}
		} else {
			// dummy empty file
			$css = array(
				$this->cfg->path->supplemvc . '/libraries/Minify/empty.css'
			);
		}

		if (sizeof($missing)) {
			// there are missing js files
			echo "Missing files\n- " . implode("\n- ", $missing);

		} else if (sizeof($group)) {
			$options = array('type' => 'css', 'groups' => array('css' => $group));

			// combine but not minify
			//$options['minifiers'][Minify::TYPE_CSS] = '';

			$options['debug'] = true;

			if ($version) {
				$options['maxAge'] = 31536000;
			}
			Minify::serve('SuppleFW', $options);
		} else {
			header("Content-type: text/css", true);
			echo '';
		}
	}

}
?>
