<?

class Blogs
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 < 
	function Blogs()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_blogs_type.itype_id AS ARRAY_KEY, ?_blogs_type.* FROM ?_blogs_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_blogs_type WHERE itype_id = ?d", $id);
	}

	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов 
		$retVal = $DB->select(
			"SELECT ".
				"?_blogs_element.el_id AS ARRAY_KEY, ".
				"?_blogs_element.* ".
			"FROM ?_blogs_element ".
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
		return $DB->selectRow("SELECT * FROM ?_blogs_element WHERE el_id = ?d", $id);
	}


	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;

		$rows = $DB->select("SELECT * FROM ?_blogs_content WHERE el_id IN (?a)", array_keys($elements));

		foreach($rows as $v)
			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];

		return $elements;
	}

	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getLimitedElements($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "")
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
				"?_blogs_element AS ie, ".
				"?_blogs_content AS ic ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY ie.el_date DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			empty($count)? DBSIMPLE_SKIP: $start
		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}

	// посчитать кол-во эл-тов в типе
	function countElements($tid, $statusField = "")
	{
		global $DB;

		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
			"FROM ".
				"?_blogs_element AS ie, ".
				"?_blogs_content AS ic ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ?} ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
/*
SELECT COUNT( ie.el_id ) 
FROM adm_blogs_element AS ie, adm_blogs_content AS ic
WHERE ie.itype_id = 16
AND ie.el_id = ic.el_id
AND ic.icont_var = 'status'
AND ic.icont_text <> ''
AND ic.icont_text IS NOT NULL 
		*/
			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);
	}

	function statusFilter($rows, $statusField = "")
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT el_id AS ARRAY_KEY ".
			"FROM ?_blogs_content ".
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
			"FROM ?_blogs_content ".
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

}

?>