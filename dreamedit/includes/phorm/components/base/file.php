<?php

require_once dirname(__FILE__)."/../component.php";

class base_file extends component {

	var $value_is_array = TRUE;


	function to_string () {
		$names = array();
		$value = $this->comp['value'];
		foreach ($value as $file) {
			array_push($names, $file['name']);
		}
		return implode(', ', $names);
	}


	function _init () {
		$this->phorm['enctype'] = 'multipart/form-data';
	}


	function _init_value () {
		$value = array();
		$name = $this->comp['name'];
		$data = isset($_FILES[$name]) ? $_FILES[$name] : array();
		$number_of_files = isset($data['name']) ? count($data['name']) : 0;
		for ($i = 0; $i < $number_of_files; $i++) {
			$value[$i]['tmp_name']	= $data['tmp_name'][$i];
			$value[$i]['name']		= $data['name'][$i];
			$value[$i]['size']		= $data['size'][$i];
			$value[$i]['type']		= $data['type'][$i];
			$value[$i]['errors']	= array();
		}
		$this->comp['value'] = $value;
	}


	function _validate () {
		$component	= $this->comp;

		$errors			= array();
		$good_files		= 0;
		$value			= isset($component['value'])		 ? $component['value'] : array();
		$prompt			= isset($component['prompt'])		 ? $component['prompt'] : '';
		$required		= isset($component['required'])		 ? $component['required'] : FALSE;
		$destination	= isset($component['destination'])   ? $component['destination'] : '';

		$max_file_size	= isset($component['max_file_size']) ? $component['max_file_size'] : 0;
		$allowed_ext	= isset($component['allowed_ext'])	 ? $component['allowed_ext'] : '';
		$denied_ext		= isset($component['denied_ext'])	 ? $component['denied_ext'] : '';
		$allowed_types	= isset($component['allowed_types']) ? $component['allowed_types'] : '';
		$denied_types	= isset($component['denied_types'])  ? $component['denied_types'] : '';


		for ($i = 0; $i < count($value); $i++) {

			$file = $value[$i];

			// проверяем имя на пустоту
			if (empty($file['name'])) {
				unset($this->comp['value'][$i]);
				continue;
			}


			// проверяем минимальный размер файла
			if ($file["size"] < 0) {
				$error = $this->_error('file_too_small', $file, $prompt);
				array_push($file['errors'], $error);
			}


			// проверяем максимальный размер, если установлен
			if (!empty($max_file_size) && $file["size"] > $max_file_size) {
				$error = $this->_error('file_too_big', $file, $prompt);
				array_push($file['errors'], $error);
			}


			// проверяем допустимость расширения загруженного файла
			$path_parts = pathinfo($file['name']);
			$extension = $path_parts['extension'];
			$file['extension'] = isset($extension) ? $extension : '';
			// среди разрешенных
			if (!empty($allowed_ext) && !in_array($file['extension'], $allowed_ext)) {
				$error = $this->_error('file_invalid_extension', $file, $prompt);
				array_push($file['errors'], $error);
			}

			// среди запрещенных
			if (!empty($denied_ext) && in_array($file['extension'], $denied_ext)) {
				$error = $this->_error('file_denied_extension', $file, $prompt);
				array_push($file['errors'], $error);
			}


			// проверка mime-типа файла
			$type = $file['type'];

			// среди разрешенных
			if (!empty($allowed_types) && !in_array($type, $allowed_types)) {
				$error = $this->_error('file_invalid_type', $file, $prompt);
				array_push($file['errors'], $error);
			}

			// среди запрещенных
			if (!empty($denied_types) && in_array($type, $denied_types)) {
				$error = $this->_error('file_denied_type', $file, $prompt);
				array_push($file['errors'], $error);
			}


			if(!empty($destination) && empty($file['errors']))
			{
				$destination = $_SERVER["DOCUMENT_ROOT"]."/".(substr($destination, strlen($destination) - 1, 1) == "/"? $destination: $destination."/");
				if(is_dir($destination))
				{
					if(file_exists($destination.$file['name']))
					{
						$error = $this->_error('file_exists', $file, $prompt);
						array_push($file['errors'], $error);
					}
					else
					{
						if(!move_uploaded_file($file['tmp_name'], $destination.$file['name']))
						{
							$error = $this->_error('file_attack', $file, $prompt);
							array_push($file['errors'], $error);
						}
					}
				}
				else
				{
					$error = $this->_error('file_wrong_destination', $file, $prompt);
					array_push($file['errors'], $error);
				}
			}

			if (count($file['errors']) == 0)
				$good_files++;
			else
				$errors = array_merge($errors, $file['errors']);
		}

		if ($required && $good_files == 0) {
			$error = $this->_error('file_must_upload', $file, $prompt);
			array_push($errors, $error);
		}

		return $errors;
	}
}



?>
