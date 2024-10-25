<?php
class ImageUpload {
	protected $filename = '';
	protected $field = '';
	protected $folder = '';
	protected $error = '';
	protected $extensions = '';
	protected $extension = '';
	protected $size = '';
	protected $md5 = '';
	protected $original_name = '';
	
	
	public function __construct() {
	}


	// Getters

	public function get_filename() { return $this->filename; }
	public function get_field() { return $this->field; }
	public function get_folder() { return $this->folder; }
	public function get_extensions() { return $this->extensions; }
	public function get_extension() { return $this->extension; }
	public function get_error() { return $this->error; }

	public function get_md5() { return $this->md5; }
	public function get_size() { return $this->size; }
	public function get_original_name() { return $this->original_name; }


	// Setters

	public function set_filename($value) { $this->filename = $value; }
	public function set_field($value) { $this->field = $value; }
	public function set_folder($value) { $this->folder = $value; }
	public function set_extensions($value) { $this->extensions = $value; }


	// Methods
	public function is_uploaded() {
		if (is_uploaded_file($_FILES[$this->field]['tmp_name'])) {
			$this->original_name = $_FILES[$this->field]['name'];
			$this->size = $_FILES[$this->field]['size'];
			return true;
		} else {
			return false;
		}
	}

	public function save($overwrite = false, $max_size = false) {
		if ($this->is_uploaded()) {
			$name = $_FILES[$this->field]['name'];

			$file_parts  = pathinfo($name);
			$this->extension = strtolower($file_parts['extension']);
			$extensions = explode('|', $this->extensions);

			if (in_array($this->extension, $extensions)) {
				if ($this->filename) {
					$filename = $this->filename;
				} else {
					$filename = $file_parts['filename'];
				}
				$filename = str_replace(" ", "-", $filename);
				$filename = str_replace("'", "", $filename);

				if ($overwrite) {
					if (is_file($dummy = $this->folder . '/' . $filename)) {
						@unlink($dummy);
					}
				} else {
					$filename = get_available_name($filename);
				}

				if (!is_dir($this->folder)) {
					mkdir($this->folder);
				}

				move_uploaded_file($_FILES[$this->field]['tmp_name'], $this->folder . '/' . $filename . '.' . $this->extension);

				$this->md5 = md5_file($this->folder . '/' . $filename . '.' . $this->extension);

				$this->remove_thumbnails($filename);

				return $this->filename = $filename;

			} else {
				$this->error = 'not_allowed_extension';
				return false;
			}

		} else {
			$this->error = 'no_uploaded_file';
			return false;
		}
	}

	public function get_available_name($filename) {
		$i = 0;
		$file_parts = pathinfo($filename);
		$file_test = $file_parts['filename'];
		$extension = $file_parts['extension'];

		while (file_exists($this->folder . '/' . $file_test . '.' . $extension)) {
			$i++;
			$file_test = $filename . '[' . $i . ']';
		}
		return $file_test . '.' . $extension;
	}

	public function delete($file) {
		if ($file) {
			@unlink($this->folder . '/' . $file);
			$this->remove_thumbnails($file);
		}
	}

	public function remove_thumbnails($file) {
		if ($file) {
			list($filename) = explode('.', $file);

			$thumb_folder = $this->folder . '/thumbs/';

			if (is_dir($thumb_folder)) {
				$thumbnails = scandir($thumb_folder);

				foreach ($thumbnails as $thumbnail) {
					list($thumbnailname) = explode('.', $thumbnail);

					if ($thumbnailname == $filename) {
						@unlink($thumb_folder . $thumbnail);
					}
				}
			}
		}
	}

	public function remove_folder($folder) {
		if ($folder) {
			if (is_dir($folder)) {
				$images = scandir($folder);

				foreach ($images as $image) {
					if ($image != '.' && $image != '..' ) {
						if (is_dir($folder . '/' . $image)) {
							$this->remove_folder($folder . '/' . $image);
						} else if (is_file($folder . '/' . $image)) {
							@unlink($folder . '/' . $image);
						}
					}
				}
				rmdir($folder);
			}
		}
	}

}

?>
