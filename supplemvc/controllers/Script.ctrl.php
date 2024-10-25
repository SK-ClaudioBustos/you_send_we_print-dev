<?php
class ScriptCtrl extends SystemCtrl {

	public function run($args) {
		$mod = '';
		$root_path = $this->cfg->path->views . '/' . $this->cfg->setting->viewtype . '/';

		$group = [];
		$missing = [];

		$arg = array_shift($args);
		$arg = explode('.', $arg);
		$arg = $arg[0];
		if (is_numeric($arg)) {
			$version = $arg;
		} else {
			$mod = $arg;
			$version = array_shift($args);
		}

		if (!$mod) {
			// main js file
			$path = $root_path . '_scripts/';
		} else {
			// controller js file
			$path = $root_path . strtolower($mod) . '/';
		}

		$file = $path . '_scripts.view.php';
		if (file_exists($file)) {
			// process _scripts.view.php
			include_once($file);

			foreach($js as $file) {
				if (is_array($file)) {
					$path_file = $path . $file[0];
					if (file_exists($path_file)) {
						// expect array(file, minify), no minify if false
						if ($file[1] === false) {
							$group[] = new Minify_Source(array(
									'filepath' => $path_file,
									'minifier' => '',
								));
						} else {
							// normal file
							$group[] = $path_file;
						}

					} else {
						// missing file
						$missing[] = RelativePath::getRelativePath($path_file);
					}

				} else {
					$path_file = $path . $file;
					if (file_exists($path_file)) {
						if (strpos($path_file, '.min.') !== false) {
							// already minified, don't touch it
							$group[] = new Minify_Source(array(
									'filepath' => $path_file,
									'minifier' => '',
								));

						} else {
							$group[] = $path_file;
						}

					} else {
						// missing file
						$missing[] = RelativePath::getRelativePath($path_file);
					}
				}
			}
		} else {
			// there is no _scripts.view.php, use a dummy empty file
			$group = array(
				$this->cfg->path->supplemvc . '/libraries/Minify/empty.js'
			);
		}

		if (sizeof($missing)) {
			// there are missing js files
			echo "Missing files\n- " . implode("\n- ", $missing);

		} else {
			$options = array('type' => 'js', 'groups' => array('js' => $group));

			// combine but not minify
			//$options['minifiers'][Minify::TYPE_JS] = '';

			$options['debug'] = false;
			if ($version) {
				$options['maxAge'] = 31536000;
			}
			Minify::serve('SuppleFW', $options);
		}
	}

}
