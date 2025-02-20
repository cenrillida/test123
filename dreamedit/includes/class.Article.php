<?


class Article
{
	var $childNodesName;

	private $pages;

	function __construct($childNodesName = "childNodes")
	{
		$this->childNodesName = $childNodesName;
	}

	function Pages($childNodesName = "childNodes")
	{
		$this->__construct($childNodesName);
	}

	// вытащить поле корневой страницы (по умолчанию - page_id)
	function getRootPageId($field = "page_id")
	{
		global $DB;
		return $DB->selectCell("SELECT ?# FROM ?_article WHERE page_parent = 0", $field);
	}

	// Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPages($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
				"page_parent ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);




		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["journal"]][$this->childNodesName][] = $k;


		return $rows;
	}
	
        // Выбрать все статьи журнала (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPagesRootJ($page_status = null, $page_link = null, $page_type = null, $page_parent = null)
	{
		global $DB;

        if (empty($page_parent)) $page_parent=1;

        $cleanId = (int)$page_parent;

		$rows =  $DB->select(
		  "	SELECT  /* Первый и второй уровни */
                adm_article.page_id AS ARRAY_KEY,
                adm_article.*
            FROM adm_article
            WHERE
                1 = 1
                AND (page_id = ".$cleanId." OR page_parent = ".$cleanId.")
	UNION  /*Третий уровень*/
            SELECT
                L3.page_id AS ARRAY_KEY,
                L3.*
            FROM adm_article AS L2 INNER JOIN adm_article AS L3 ON L2.page_id = L3.page_parent
            WHERE
                1 = 1
                                AND L2.page_parent = ".$cleanId."
	UNION /*Четвертый уровень*/
            SELECT
                L4.page_id AS ARRAY_KEY,
                L4.*
            FROM adm_article AS L2
				INNER JOIN adm_article AS L3 ON L2.page_id = L3.page_parent
				INNER JOIN adm_article AS L4 ON L3.page_id = L4.page_parent
            WHERE
                1 = 1
                 AND L2.page_parent = ".$cleanId."
	UNION /*Пятый уровень*/
            SELECT
                L5.page_id AS ARRAY_KEY,
                L5.*
            FROM adm_article AS L2
				INNER JOIN adm_article AS L3 ON L2.page_id = L3.page_parent
				INNER JOIN adm_article AS L4 ON L3.page_id = L4.page_parent
				INNER JOIN adm_article AS L5 ON L4.page_id = L5.page_parent
            WHERE
                1 = 1
                 AND L2.page_parent = ".$cleanId." ",


			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);


		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();

		foreach($rows as $k => $v)
		{
    			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
        }
		return $rows;
	}
	
      // Выбрать все страницы Начиная с заданной (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPagesRoot($page_status = null, $page_link = null, $page_type = null, $page_parent = null)
	{
		global $DB;

        if (empty($page_parent)) $page_parent=1;

        $cleanId = (int)$page_parent;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
				" AND page_parent =".$cleanId." OR page_id= ".$cleanId.
			" ORDER BY  ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);


		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();

		foreach($rows as $k => $v)
		{
    			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
        }
		return $rows;
	}
  // Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes" для Dreamedit
	function getPagesAll($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
                "page_position ASC,
				page_name ASC ",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
        $rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["journal"]][$this->childNodesName][] = $k;


		return $rows;
	}
	function getPagesAllByArticle($article_name, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
                "page_position ASC,
				page_name ASC ",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
		$current_jour = (int)$article_name;
		while(true)
		{
			if($current_jour==0)
				break;
			$temp_jour = $DB->select("SELECT page_parent FROM adm_article WHERE page_id=".$current_jour);
			if($temp_jour[0][page_parent]==0)
				break;
			else
				$current_jour=$temp_jour[0][page_parent];
		}
		
		$temp_rows = array();
		$temp_rows[$current_jour] = $rows[$current_jour];
		
		foreach($rows as $row)
		{
			if($row[page_parent]==0)
			{
				$temp_rows[$row[page_id]] = $row;
				continue;
			}
			if($row[page_parent]==$current_jour)
			{
				$temp_rows[$row[page_id]] = $row;
				$temp_page=$row[page_id];
				$const_page=$row[page_id];
				while(true)
				{
					$count=0;
					foreach($rows as $row2)
					{
						if($row2[page_parent]==$temp_page && empty($temp_rows[$row2[page_id]]))
						{
							$temp_rows[$row2[page_id]] = $row2;
							$temp_page=$row2[page_id];
							$count++;
						}
					}	
					if($count==0)
					{
						if($temp_page!=$const_page)
							$temp_page=$const_page;
						else
							break;
					}
				}
			}
		}
		
		$rows = $temp_rows;
		
		
        $rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["journal"]][$this->childNodesName][] = $k;
			
		
		return $rows;
	}
	// Выбрать страницу по ID
	function getPageById($id, $page_status = null, $page_type = null)
	{
		global $DB;
		return $DB->selectRow(
			"SELECT * ".
			"FROM ?_article ".
			"WHERE ".
				"page_id = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			$id,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
    // Выбрать страницу по ID
	function getPageByIdOfficial($id, $page_status = null, $page_type = null)
	{
		global $DB;
		return $DB->selectRow(
			"SELECT * ".
			"FROM isras2008.?_article ".
			"WHERE ".
				"page_id = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			$id,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// Выбрать ID всех дочерних эл-тов страниц по родительскому ID (с доп условиями)
	function getChilds($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
		// Выбрать ID всех дочерних эл-тов страниц по родительскому ID (с доп условиями) c официального сайта
	function getChildsOfficial($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"isras2008.?_article.page_id AS ARRAY_KEY, ".
				"isras2008.?_article.* ".
			"FROM isras2008.?_article ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
    // Выбрать ID всех дочерних эл-тов страниц по родительскому ID (с доп условиями) Не читать невидимые
	function getChildsCMS($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
				" AND page_old=1 ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// Выбрать ветвь эл-тов
	function getBranch($id, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
		$rows = $this->getPages($page_status, $page_link, $page_type);

		$retVal = array();
		$this->unpackChildsRecursive($rows, $retVal, $id);

		return $retVal;
	}

	// Рекурсивная ф-ция. Формирует массив выбранной ветви
	function unpackChildsRecursive(&$data, &$retVal, $start = 0)
	{
		if(!empty($start))
			$retVal[$start] = $data[$start];

		if(!isset($data[$start][$this->childNodesName]))
			return;

		foreach($data[$start][$this->childNodesName] as $v)
			$this->unpackChildsRecursive($data, $retVal, $v);
	}


	// Присоединить к массиву страниц контент
	function appendContent($pages)
	{
		global $DB;
		$rows = $DB->select("SELECT * FROM ?_article_content WHERE page_id IN (?a)", array_keys($pages));

		foreach($pages as $v)
			$pages[$v["page_id"]]["content"] = array();

		foreach($rows as $v)
			$pages[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

		return $pages;

	}

	// Получить контент страницы по её ID
	function getContentByPageId($pageId)
	{
		$rows = $this->appendContent(array($pageId => array()));
		return $rows[$pageId]["content"];
	}

	// Получить ID родительского эл-та
	function getParentId($id)
	{
		$pid = $this->getPageById($id);
		return $pid["page_parent"];
	}

	// Получить URL к выбранной странице
	// пересмотреть этот метод еще раз!
	function getPageUrl($id, $vars = array(), $pages = array())
	{
		global $DB;

		if(empty($pages) || !isset($pages[$id]))
			$pages = $this->getPages();

		if(!isset($pages[$id]) || empty($pages[$id]["page_status"]))
			return;

		$qStr = array();
		if(!empty($vars))
		{
			foreach($vars as $vName => $vValue)
			{

				if(!empty($vValue))
					$qStr[$vName] = $vName."=".$vValue;
			}
		}


		if(!empty($pages[$id]["page_urlname"]))
		{
			if(!empty($pages[$id]["page_urlname_regexp"]))
			{

				$urlVars = Templater::getVarsFromStr($pages[$id]["page_urlname"]);
				foreach($urlVars as $vName)
				{
					$vValue = "";
					if(isset($vars[strtolower($vName)]))
					{
						$vValue = $vars[strtolower($vName)];
						unset($qStr[strtolower($vName)]);
					}
					$pages[$id]["page_urlname"] = str_replace('{'.$vName.'}', $vValue, $pages[$id]["page_urlname"]);
				}
			}
			return "/".$pages[$id]["page_urlname"].(!empty($qStr)? "?".implode("&", $qStr): "");
		}

		if(!empty($pages[$id]["page_link"]))
		{
			if(intval($pages[$id]["page_link"]) > 0)
			{

				$retVal = "/index.php?page_id=".$pages[$id]["page_link"].(!empty($qStr)? "&".implode("&", $qStr): "");
				$link_urlname = isset($pages[$pages[$id]["page_link"]])? $pages[$pages[$id]["page_link"]]["page_urlname"]: "";

				if(!empty($link_urlname))
					$retVal = "/".$link_urlname.(!empty($qStr)? "?".implode("&", $qStr): "");
			}
			else
				$retVal = $pages[$id]["page_link"];

			return $retVal;
		}

		return "/index.php?page_id=".$id.(!empty($qStr)? "&".implode("&", $qStr): "");
	}

	// Выбрать похожие эл-ты по ID страницы (если страница - ссылка, то берем ссылочные эл-ты)
	function getLinkedPages($id)
	{
		global $DB;

		$self = $this->getPageById($id);
		// выбираем ID мастер-страницы
		$masterID = ((int)$self["page_link"] > 0)? $self["page_link"]: $id;

		$retVal = array();

		$pages = $this->getPages();
		// пробегаем по всем страницам
		foreach($pages as $k => $v)
		{
			// если ID страницы или ее ссылка нужны то вытаскиваем всех родителей
			if(($k == $masterID || @$v["page_link"] == $masterID))
			{
				// пока не достигнем корня дерева - добавляем родительские ветки в новый массив
				$parent = $k;
				while($parent != 0)
				{
					$retVal[$parent] = $pages[$parent];
					$parent = $pages[$parent]["page_parent"];
				}
			}
		}

		return $retVal;

	}

	// Выбрать все родительские эл-ты (с доп условием)
	function getParents($id, $page_status = null, $page_link = null, $page_type = null)
	{
		$rows = $this->getPages($page_status, $page_link, $page_type);

		$retVal = array();

		// пока не достигнем корня дерева - добавляем родительские ветки в новый массив
		$parent = $id;
		while($parent != 0)
		{
			$retVal[$parent] = $rows[$parent];
			$parent = $rows[$parent]["page_parent"];
		}

		return array_reverse($retVal, true);
	}

	function getPageByUrl($url, $page_status = null, $page_type = null)
	{
		global $DB;

		// проверяем точное совпедение с урлом
		$row = $DB->selectRow(
			"SELECT * ".
			"FROM ?_article ".
			"WHERE ".
				"page_urlname = ? ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			rawurldecode($url),
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		// проверяем совпадение по регулярке
		if(empty($row))
			$row = $DB->selectRow(
				"SELECT * ".
				"FROM ?_article ".
				"WHERE ".
					"page_urlname_regexp != '' ".
					"AND ? REGEXP BINARY page_urlname_regexp ".
					"{AND page_status  = ?d} ".
					"{AND page_type    = ?d} ",

				rawurldecode($url),
				(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
				(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
			);

		// возможно стоит добавить чужую идею с поиском страниц с прибавлением "index.html" (полная имитация файловой системы)
		return $row;
	}


	function registHiddenVariables($pageID, $url)
	{
		$row = $this->getPageById($pageID);
		if(!empty($row["page_urlname_regexp"]))
		{
			$vars = Templater::getVarsFromStr($row["page_urlname"]);
			preg_match("/".$row["page_urlname_regexp"]."/", $url, $matches);
			foreach($vars as $matchKey => $varName)
				$_REQUEST[strtolower($varName)] = $matches[$matchKey + 1];
		}
	}


//	function get

}




?>