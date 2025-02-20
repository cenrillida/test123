<?


class Helpers
{
	var $childNodesName;

	function __construct($childNodesName = "childNodes")
	{
		$this->childNodesName = $childNodesName;
	}

	function Helpers($childNodesName = "childNodes")
	{
		$this->__construct($childNodesName);
	}

	// вытащить поле корневой страницы (по умолчанию - page_id)
	function getRootPageId($field = "page_id")
	{
		global $DB;
		return $DB->selectCell("SELECT ?# FROM ?_helpers WHERE page_parent = 0", $field);
	}

	// Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPages($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

          $rows =  $DB->select(
			"SELECT ".
				"?_helpers.page_id AS ARRAY_KEY, ".
				"?_helpers.* ".
			"FROM ?_helpers ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
 // Выбрать все страницы, к которым есть комментарии (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPagesComment($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_helpers.page_id AS ARRAY_KEY, ".
				"?_helpers.* ".
			"FROM ?_helpers ".
			" INNER JOIN comment_txt AS t ON t.page_id=?_helpers.page_id ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}

   // Выбрать ID всех дочерних эл-тов страниц журнала по родительскому ID (с доп условиями)
	function getChildsJ($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
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
	 // Присоединить к массиву страниц журнала контент
	function appendContentJ($helpers)
	{
		global $DB;
		$rows = $DB->select("SELECT * FROM ?_magazine_content WHERE page_id IN (?a)", array_keys($helpers));

		foreach($helpers as $v)
			$helpers[$v["page_id"]]["content"] = array();

		foreach($rows as $v)
			$helpers[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

		return $helpers;

	}

	// Получить контент страницы по её ID
	function getContentByPagesIdJ($pageId)
	{
		$rows = $this->appendContentJ(array($pageId => array()));
		return $rows[$pageId]["content"];
	}

	// Выбрать страницу по ID
	function getPageById($id, $page_status = null, $page_type = null)
	{
		global $DB;
		return $DB->selectRow(
			"SELECT * ".
			"FROM ?_helpers ".
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
				"?_helpers.page_id AS ARRAY_KEY, ".
				"?_helpers.* ".
			"FROM ?_helpers ".
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
    // Выбрать ID всех дочерних эл-тов страниц по родительскому ID (с доп условиями)
	function getChildsMenu($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_helpers.page_id AS ARRAY_KEY, ".
				"?_helpers.* ".
			"FROM ?_helpers ".
			"WHERE ".
				"page_parent = ?d ".
				" AND page_template <> 'podr' ".
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
	function appendContent($helpers)
	{


		global $DB;
		$rows = $DB->select("SELECT * FROM ?_helpers_content WHERE page_id IN (?a)", array_keys($helpers));

		foreach($helpers as $v)
			$helpers[$v["page_id"]]["content"] = array();

		foreach($rows as $v)
			$helpers[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

		return $helpers;

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
	function getPageUrl($id, $vars = array(), $helpers = array())
	{
		global $DB;

		if(empty($helpers) || !isset($helpers[$id]))
			$helpers = $this->getPages();

		if(!isset($helpers[$id]) || empty($helpers[$id]["page_status"]))
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


		if(!empty($helpers[$id]["page_urlname"]))
		{
			if(!empty($helpers[$id]["page_urlname_regexp"]))
			{
				$urlVars = Templater::getVarsFromStr($helpers[$id]["page_urlname"]);
				foreach($urlVars as $vName)
				{
					$vValue = "";
					if(isset($vars[strtolower($vName)]))
					{
						$vValue = $vars[strtolower($vName)];
						unset($qStr[strtolower($vName)]);
					}
					$helpers[$id]["page_urlname"] = str_replace('{'.$vName.'}', $vValue, $helpers[$id]["page_urlname"]);
				}
			}
			return "/".$helpers[$id]["page_urlname"].(!empty($qStr)? "?".implode("&", $qStr): "");
		}

		if(!empty($helpers[$id]["page_link"]))
		{
			if(intval($helpers[$id]["page_link"]) > 0)
			{
				$retVal = "/index.php?page_id=".$helpers[$id]["page_link"].(!empty($qStr)? "&".implode("&", $qStr): "");
				$link_urlname = isset($helpers[$helpers[$id]["page_link"]])? $helpers[$helpers[$id]["page_link"]]["page_urlname"]: "";

				if(!empty($link_urlname))
					$retVal = "/".$link_urlname.(!empty($qStr)? "?".implode("&", $qStr): "");
			}
			else
				$retVal = $helpers[$id]["page_link"];

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

		$helpers = $this->getPages();
		// пробегаем по всем страницам
		foreach($helpers as $k => $v)
		{
			// если ID страницы или ее ссылка нужны то вытаскиваем всех родителей
			if(($k == $masterID || @$v["page_link"] == $masterID))
			{
				// пока не достигнем корня дерева - добавляем родительские ветки в новый массив
				$parent = $k;
				while($parent != 0)
				{
					$retVal[$parent] = $helpers[$parent];
					$parent = $helpers[$parent]["page_parent"];
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
			"FROM ?_helpers ".
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
				"FROM ?_helpers ".
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
   // Получить список всех публикаций в базе
	function getBases($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows=$DB->select("SELECT subrubric AS page_parent, p.page_id AS id,p.name,s.name AS subrubricname,r.name AS rubricname,r.id AS rubric,s.id AS subrubric FROM base_publ AS p
		      INNER JOIN base_subrubric AS s ON s.id=p.subrubric
		            INNER JOIN base_rubric AS r ON r.id = s.rubric
		      ORDER BY r.sort,s.sort,p.name");

       return $rows;
	}
	 // Получить публикацию по id
	function getBasesById($id,$page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows=$DB->select("SELECT * FROM base_publ
	      WHERE page_id=".$id);

       return $rows;
	}
}


?>
<?/////________________________________________________//////////?>
<?

/*
class Persons
{

    var $childNodesName;

	function __construct($childNodesName = "childNodes")
        {
	    $this->childNodesName = $childNodesName;
	}

        function Persons($childNodesName = "childNodes")
	{
            $this->__construct($childNodesName);
	}

	// Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPersonsByPodrId($podr_id)
	{
	    global $DB, $_CONFIG;
	    include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";
	    $rows =  $DB->select(
	    "SELECT persona.id, CONCAT(surname, ' ',  name,  ' ', fname) AS fullname, otdel, CONCAT(tel1,' ', mail1) AS contact,
	    d.text AS dolj, chlen, s.short AS us, z.short AS uz  FROM persona
            LEFT OUTER JOIN doljn AS d ON d.id=persona.dolj
	    LEFT OUTER JOIN stepen AS s ON s.id=persona.us
	    LEFT OUTER JOIN zvanie AS z ON z.id=persona.uz
	     WHERE otdel IN
	    (SELECT page_name FROM
	    (SELECT page_id,page_name FROM `adm_helpers` WHERE page_id = ".$podr_id."
	    UNION
	    SELECT page_id,page_name FROM `adm_helpers` WHERE page_parent = ".$podr_id."
	    UNION
	    SELECT page_id,page_name FROM adm_helpers WHERE page_parent
	    IN (SELECT page_id FROM `adm_helpers` WHERE page_parent = ".$podr_id.")
	    UNION
	    SELECT page_id,page_name FROM adm_helpers WHERE page_parent
	    IN (SELECT page_id FROM adm_helpers WHERE page_parent
	    IN (SELECT page_id FROM `adm_helpers` WHERE page_parent = ".$podr_id."))
            UNION
            SELECT page_id,page_name FROM adm_helpers WHERE page_parent
            IN (SELECT page_id FROM adm_helpers WHERE page_parent
	    IN (SELECT page_id FROM adm_helpers WHERE page_parent
	    IN (SELECT page_id FROM `adm_helpers` WHERE page_parent = ".$podr_id.")))) AS allpodr) ORDER BY persona.surname, persona.name");

//            for($i=0; $i< count($rows);$i++)
// 	    {
//	        $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//		$rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	        $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	    }

            return $rows;
     }

////////////
     function getPersonsByFio($surname,$name,$fname)
     {
        global $DB, $_CONFIG;
	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname, CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',' | ', tel1) AS contact,
	    d.text AS dolj, chlen, s.short AS us, z.short AS uz  FROM persona AS p
            LEFT OUTER JOIN doljn AS d ON d.id=p.dolj
	    LEFT OUTER JOIN stepen AS s ON s.id=p.us
	    LEFT OUTER JOIN zvanie AS z ON z.id=p.uz

             WHERE
	     surname = '".$surname."' and name = '".$name."' and fname = '".$fname."'"
	 );
//	for($i=0; $i< count($rows);$i++)
//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}

       return $rows;


    }
     function getPersonsById($id)
     {
        global $DB, $_CONFIG;
	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT p.id,
	    CONCAT(p.surname,' ',p.name,' ',p.fname) AS fullname,
	    CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fioshort,
	    p.rewards,p.about,p.ruk,p.usp,podr.invis, CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',' | ', tel1) AS contact,
	    d.text AS dolj, chlen, s.full AS us, z.full AS uz, p.otdel,
	    o.page_id AS otdelid,p.picsmall,p.picbig
	    FROM persona AS p
            LEFT OUTER JOIN doljn AS d ON d.id=p.dolj
	    LEFT OUTER JOIN stepen AS s ON s.id=p.us
	    LEFT OUTER JOIN zvanie AS z ON z.id=p.uz
	    LEFT OUTER JOIN podr ON podr.name=p.otdel
	    INNER JOIN adm_helpers AS o ON o.page_name=p.otdel
             WHERE p.id=".$id

	 );
//	for($i=0; $i< count($rows);$i++)
//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}

       return $rows;


    }


     function getAvtorById($id)
     {
        global $DB, $_CONFIG;
//	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT persona.id,CONCAT(surname,' ',SUBSTRING(name,1,1),'.',SUBSTRING(fname,1,1),'.') AS fullname
             FROM persona

             WHERE
	     id = '".$id."'"
	 );
//	for($i=0; $i< count($rows);$i++)

//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}



       return $rows;


    }

}               */
?>
