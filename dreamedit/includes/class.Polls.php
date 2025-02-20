<?

class Polls
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Polls()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_polls_type.itype_id AS ARRAY_KEY, ?_polls_type.* FROM ?_polls_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_polls_type WHERE itype_id = ?d", $id);
	}

	// получить cписок по type name
	function getTextsByTypeName($type_name)
	{
		global $DB;
		return $DB->select(" SELECT '' AS ARRAY_KEY, '' AS text_ru,'' AS text_en UNION SELECT dck.icont_text AS ARRAY_KEY, dcr.icont_text AS text_ru, dce.icont_text AS text_en FROM ?_polls_content dcr INNER JOIN ?_polls_element de ON de.el_id = dcr.el_id AND dcr.icont_var = 'text_ru' INNER JOIN ?_polls_content dck ON de.el_id = dck.el_id AND dck.icont_var = 'value' INNER JOIN ?_polls_content dce ON dck.el_id = dce.el_id AND dce.icont_var = 'text_en' INNER JOIN ?_polls_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY text_ru", $type_name);
	}


	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов
		$retVal = $DB->select(
			"SELECT ".
				"?_polls_element.el_id AS ARRAY_KEY, ".
				"?_polls_element.* ".
			"FROM ?_polls_element ".
			"WHERE ".
				"itype_id IN (?a) ".
			"ORDER BY el_date DESC",

			$tIds
		);

		// применение фильтра к выбранным эл-там
		if(!empty($statusField) && !empty($retVal))
			$retVal = $this->statusFilter($retVal, $statusField);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}

	// получить конкретный элемент по ID и если надо, добавить к ним контент
	function getElementById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_polls_element WHERE el_id = ?d", $id);
	}


	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;


		$rows = $DB->select("SELECT * FROM ?_polls_content WHERE el_id IN (?a)", array_keys($elements));

		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];
		}
		return $elements;
	}

	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getLimitedElements($tid, $count = 3, $page = 1, $sortField = "", $sortType = "", $statusField = "")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_polls_element AS ie, ".
				"?_polls_content AS ic ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY ie.el_date DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			/*empty($statusField)? DBSIMPLE_SKIP:*/ $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}

	// получить все элементы из указанных типов и если надо, и отсортировать их по нескольким полям
	function getLimitedElementsMultiSort($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);

		if(!((count($sColArray)==1)&&($sColArray[0]=="")))
		{
			//print_r($sColArray);
			$sortStr = "";
			for($i = 0; $i < count($sColArray); $i++)
			{
				$sortStr = $sortStr.", innerTable".$i.".icont_text ".$sTypArray[$i]." ";
			}
			$sortStr = ltrim($sortStr,",");
			$sortStr = "ORDER BY ".$sortStr;
			//print_r($sortStr."<br />");

			$innerJoinStr = "";
			for($i = 0; $i < count($sColArray); $i++)
			{
				$sColArray[$i]=ltrim(rtrim($sColArray[$i]));
				$innerJoinStr = $innerJoinStr." INNER JOIN ?_polls_content AS innerTable".$i." ON ie.el_id = innerTable".$i.".el_id AND innerTable".$i.".icont_var= '".$sColArray[$i]."' ";
			}
			//print_r($innerJoinStr."<br />");
		}
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_polls_content AS ic, ".
				"?_polls_element AS ie ".

			$innerJoinStr.
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}



	// посчитать кол-во эл-тов в типе
	function countElements($tid, $statusField)
	{
		global $DB;

		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
			"FROM ".
				"?_polls_element AS ie, ".
				"?_polls_content AS ic ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
			$tid,
			/*empty($statusField)? DBSIMPLE_SKIP:*/ $statusField
		);
	}

	function statusFilter($rows, $statusField = "")
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT el_id AS ARRAY_KEY ".
			"FROM ?_polls_content ".
			"WHERE ".
				"el_id IN (?a) ".
				"{AND icont_var  = ?}".
				"AND icont_text <> '' AND icont_text IS NOT NULL",

			array_keys($rows),
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);

		return Dreamedit::arrayIntersectKey($rows, $retVal);
	}

	function sorting($rows, $sortField = "", $sortType = "")
	{
		global $DB;

		$sortedIds = $DB->select(
			"SELECT el_id AS ARRAY_KEY ".
			"FROM ?_polls_content ".
			"WHERE ".
				"el_id IN (?a) ".
				"{AND icont_var = ?} ".
			"ORDER BY icont_text ".$sortType,

			array_keys($rows),
			empty($sortField)? DBSIMPLE_SKIP: $sortField
		);

		$retVal = array();
		foreach($sortedIds as $k => $v)
			$retVal[$k] = $rows[$k];

		return $retVal;
	}
	function getPollElements($pollname)
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT cv.icont_text AS ARRAY_KEY,ct.icont_text ".
				"FROM ?_polls_type t ".
			 " INNER JOIN ?_polls_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_polls_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
			 " INNER JOIN ?_polls_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text_ru'",
			$pollname
		);


		return $retVal;
	}
	function getTextByValue($value,$texts)
	{
		$text = "";
		foreach($texts as $va => $v)
		{

			if($va == $value)
			{
				$text =  $v["icont_text"];
			}
		}
		return $text;
	}


}

?>