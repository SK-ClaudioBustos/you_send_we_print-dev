<?php
class ImageCtrl extends SystemCtrl {

	// 'test' folder is any folder inside 'root/data' folder
	// http://www.example.com/image/test/0/image.jpg		- Actual size
	// http://www.example.com/image/test/640/image.jpg		- Fixed width and proportional heigh
	// http://www.example.com/image/test/640x200/image.jpg	- Max width and height
	// http://www.example.com/image/test/640s/image.jpg		- Square thumbnail


	public function run($args) {
		$accepted_extensions = array('.jpg', '.jpeg', '.png', '.gif', '.tif', '.psd', '.pdf');
		$max_size = ($this->cfg->setting->thumb_max_size) ? $this->cfg->setting->thumb_max_size : 1200;
		$default_img = 'default.jpg';

		// last arg is filename
		$image = array_pop($args);
		$filename = pathinfo($image, PATHINFO_FILENAME);
		$extension = pathinfo($image, PATHINFO_EXTENSION);

		// previous is size
		$size = array_pop($args);

		// remaining are path from /data (could be empty but it shouldn't)
		$path = implode('/', $args);

		//list($area, $image, $thumb_width, $thumb_height, $square, $x1, $y1, $x2, $y2) = array_pad($args, 9, false);

		if ($filename && in_array('.' . $extension, $accepted_extensions)) {
			$width = $height = $square = 0;

			// process size
			if ($size == 0) {
				// real size

			} else {
				$sizes = explode('x', $size);
				if ((sizeof($sizes) == 2) && (int)$sizes[0] && (int)$sizes[1]) {
					// width * height
					list($width, $height) = $sizes;

				} else if ((int)$size) {
					// width
					$width = (int)$size;

					if (substr($size, -1) == 's') {
						// square
						$height = $width;
						$square = 1;

					} else {
						// proportional
					}
				}
			}

			// Set defaults
			if ($width > $max_size) {
				$width = $max_size;
			}

			if (!$height) {
				$height = $width;
			} else if ($height > $max_size) {
				$height = $max_size;
			}

			$image_folder = $this->cfg->path->data . '/' . (($path) ? $path . '/' : '');
			$image_path = $image_folder . $image;

			if (!file_exists($image_path)) {
				// try with a default image in that folder
				$image_path = $image_folder . '/' . $default_img;
			}

		} else {
			$image = $default_img;
			$image_folder = $this->cfg->path->data . '/' . (($path) ? $path . '/' : '');
			$image_path = $image_folder . $image;

		}

		if (!file_exists($image_path)) {
			$image_path = $this->cfg->path->data . '/' . $default_img;
		}

		if (!$filename) {
			$filename = 'default';
		}

		// pass args to phpthumb
		$_GET['src'] = $image_path;
		$_GET['w'] = $width;
		$_GET['h'] = $height;
		$_GET['zc'] = $square;
		$_GET['sia'] = $filename;

		include($this->cfg->path->supplemvc . '/libraries/phpThumb/phpThumb.php');
	    exit;
	}

	private function remove_thumbs() {
		if ($dh = opendir($sourcedir)) {
			while ($file = readddir($dh)) {
				if ($file == $WhatIwantToDelete) {
					$md5 = md5_file($sourcedir . '/' . $file);
					unlink($phpthumb_cache_dir . '/phpThumb_cache_yousendweprint.com_src' . $md5 . '*.*');
				}
			}
			closedir($dh);
		}
	}
}
?>