<?

	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_file($filename) {
		return xml_get_array_from_xml_obj(domxml_open_file(realpath($filename)));
	}

	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_string($string) {
		return xml_get_array_from_xml_obj(domxml_open_mem($string));
	}

	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_obj($xml_object) {
		$object = array();
		$objptr = &$object;

		$first_child = $xml_object = $xml_object->first_child();
		while ($xml_object) {
			if (!($xml_object->is_blank_node())) {
				switch ($xml_object->node_type()) {
					case XML_TEXT_NODE: {
						$objptr["cdata"] = iconv("UTF-8", "cp1251", $xml_object->node_value());
						break;
					}
					case XML_ELEMENT_NODE: {
						$objptr = &$object[$xml_object->node_name()][];
						if ($xml_object->has_attributes()) {
							$attributes = $xml_object->attributes();
							if (!is_array($attributes)) break;
							foreach ($attributes as $index => $domobj) {
								$objptr[$domobj->name] = iconv("UTF-8", "cp1251", $domobj->value);
							}
						}
						break;
					}
				}
				if ($xml_object->has_child_nodes()) {
					$objptr = array_merge_preserve_keys($objptr, xml_get_array_from_xml_obj($xml_object));
					if (count($objptr) == 1 && isset($objptr["cdata"])) {
						$objptr = xml_get_cdata_value($objptr["cdata"]);
					}
				}
			}
			$xml_object = $xml_object->next_sibling();
		}

		if (isset($object["array"])) {
			// Массивы
			$new_array = array();
			foreach (array_keys($object["array"]) as $key) {
				$value = $object["array"][$key];
				if (is_array($value) && isset($value["name"])) {
					$new_array[$value["name"]] = $value;
					unset($new_array[$value["name"]]["name"]);
					// Поднятие секции CDATA
					if (count($new_array[$value["name"]]) == 1 && isset($new_array[$value["name"]]["cdata"])) {
						$new_array[$value["name"]] = xml_get_cdata_value($new_array[$value["name"]]["cdata"]);
					}
					unset($object["array"][$key]);
				}
			}
			$object["array"] = array_merge_preserve_keys($object["array"], $new_array);
			$object = $object["array"];
		} else {
			// Поднятие элементов массива если кол-во подэлементов равно 0 и индекс равен 0
			foreach ($object as $key => $value) {
				if (is_array($value) && count($value) == 1 && isset($value[0])) {
					$object[$key] = $value[0];
				}
			}
		}
		return $object;
	}

	//++++++++++++++++++++++++++++++++++++++
	function xml_get_cdata_value($value) {
		if ($value == "true")  return true;
		if ($value == "false") return false;
		return $value;
	}

	function array_merge_preserve_keys($array1, $array2) {
		foreach ($array2 as $key => $value) {
			$array1[$key] = $value;
		}
		return $array1;
	}
?>