<?

	//+++++++++++++++++++++++++++
	// Возвращает массив из xml-файла с кешированием
	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_file($filename, $cache = true) {
		static $cached = array();
		
		$filename = realpath($filename);

		if ($cache && isset($cached[$filename])) return $cached[$filename];

		$result = xml_get_array_from_xml_obj(DOMDocument::load($filename));
		// Кешируем
		$cached[$filename] = $result;
		
		return $result;
	}
	
	//+++++++++++++++++++++++++++
	// Возвращает массив из xml-строки
	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_string($string) {
		$obj = @DOMDocument::loadXML($string);
		if (!$obj) return false;
		return xml_get_array_from_xml_obj($obj);
	}
	
	//+++++++++++++++++++++++++++
	// Возвращает массив из xml-объекта
	//+++++++++++++++++++++++++++
	function xml_get_array_from_xml_obj($xml_object)
	{
		$object = array();
		$objptr = &$object;

		$items = $xml_object->getElementsByTagName("*");

		$first_child = $xml_object = $xml_object->firstChild;
		while($xml_object)
		{
				switch ($xml_object->nodeType) {
					case 3:
					{
						$objptr["cdata"] = iconv("UTF-8", "cp1251", $xml_object->nodeValue); 
//						$objptr["cdata"] = $xml_object->nodeValue; 
						break;
					}
					case 1:
					{
						$count = count($object[$xml_object->nodeName]);
//						$objptr = &$object[$xml_object->nodeName][];
						if ($xml_object->hasAttributes())
						{
							$attributes = $xml_object->attributes;
							foreach ($attributes as $index => $domobj)
							{
								$object[$xml_object->nodeName][$count][$index] = iconv("UTF-8", "cp1251", $domobj->nodeValue); 
//								$objptr[$index] = $domobj->nodeValue;
							}
						}
						break;
					}
				}

				if ($xml_object->hasChildNodes())
				{ 
					$object[$xml_object->nodeName][$count] = array_merge_replace($object[$xml_object->nodeName][$count], xml_get_array_from_xml_obj($xml_object)); 
					if (count($object[$xml_object->nodeName][$count]) == 1 && isset($object[$xml_object->nodeName][$count]["cdata"]))
					{
						$object[$xml_object->nodeName][$count] = xml_get_cdata_value($object[$xml_object->nodeName][$count]["cdata"]);
					} 
			}
			$xml_object = $xml_object->nextSibling;
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
			$object["array"] = array_merge_replace($object["array"], $new_array); 
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
	
	//+++++++++++++++++++++++++++
	function array_merge_replace($array, $values) {
		foreach ($values as $key => $value) {
			if (is_array($value)) {
				$array[$key] = (isset($array[$key])) ? array_merge_replace($array[$key], $value) : $value;
			} else {
				$array[$key] = $value;
			}
		}
		return $array;
	}

?>