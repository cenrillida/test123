<?

class Ilines
{
	// ����������� ��� PHP5+
	function __construct()
	{

	}

	// ����������� ��� PHP4 <
	function Ilines()
	{
		$this->__construct();
	}


	// �������� ��� ��������� ����
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_ilines_type.itype_id AS ARRAY_KEY, ?_ilines_type.* FROM ?_ilines_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// �������� ��� �� ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_ilines_type WHERE itype_id = ?d", $id);
	}

	// �������� ��� �������� �� ��������� ����� � ���� ����, �������� � ��� �������
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// ������ �� ������� ���� ��-���
		$retVal = $DB->select(
			"SELECT ".
				"?_ilines_element.el_id AS ARRAY_KEY, ".
				"?_ilines_element.* ".
			"FROM ?_ilines_element ".
			"WHERE ".
				"itype_id IN (?a) ".
			"ORDER BY el_date DESC",

			$tIds
		);

		// ���������� ������� � ��������� ��-���
		if(!empty($statusField) && !empty($retVal))
			$retVal = $this->statusFilter($retVal, $statusField);

		// ���������� ���������� � ��������� ��-���
		if(!empty($sortField) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}

	// �������� ���������� ������� �� ID � ���� ����, �������� � ��� �������
	function getElementById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_ilines_element WHERE el_id = ?d", $id);
	}


	// �������� ������� ������ ��������� �� ID-��������
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;

		$rows = $DB->select("SELECT * FROM ?_ilines_content WHERE el_id IN (?a)", array_keys($elements));

		foreach($rows as $v)
			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];

		return $elements;
	}

	// �������� ��� �������� �� ��������� ����� � ���� ����, �������� � ��� �������
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
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
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
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// ���������� ���������� � ��������� ��-���
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	function getLimitedElementsBank($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;
		$start = "";
		 if ($sortField=="") $ssort = "ie.el_date DESC ";
        else $ssort =  "ORDER BY ics.icont_text". " " .$sortType." ";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" INNER JOIN ?_ilines_content AS ics ON ics.el_id=ic.el_id AND ics.icont_var='".$sortField."'".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
            $ssort.
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// ���������� ���������� � ��������� ��-���
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// ��������� ���-�� ��-��� � ����
	function countElements($tid, $statusField)
	{
		global $DB;

		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);
	}
	// ��������� ���-�� ��-��� � ���� � ������ ����
	function countElementsDate($tid, $statusField)
	{
		global $DB;

		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
		     "FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND id.icont_var='date' AND id.icont_text>='".(date('Y').".".date('m').".".date('d'))."' ".

			"WHERE  ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);
	}

	function getLimitedFilteredElements($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$joinPart = "")
	{
		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

        if ($sortField=="") $ssort = "ie.el_date DESC ";
        else $ssort =  "ORDER BY ics.icont_text". " " .$sortType." ";

			$retVal = $DB->select(
			"SELECT ".
			   	"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" INNER JOIN ?_ilines_content AS ics ON ics.el_id=ic.el_id AND ics.icont_var='".$sortField."'".
				" ".$joinPart." ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
//"ORDER BY ics.icont_text". " " .$sortType." ".
            $ssort.
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// ���������� ���������� � ��������� ��-���
//		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
//			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
/// �������� ��� �������� �� ��������� ����� � ���� ����, �������� � ��� �������, ���� ������ ��� ����� �������
    function getLimitedElementsDate($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "")
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
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND id.icont_var='date' AND id.icont_text>='".(date('Y').".".date('m').".".date('d'))."' ".
			"WHERE ".
				" ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY ie.el_date DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// ���������� ���������� � ��������� ��-���
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// ��������� ���-�� ��-��� � ����
	function countFilteredElements($tid, $statusField,$joinPart = "")
	{
		global $DB;

		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" ".$joinPart." ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);
	}


	function statusFilter($rows, $statusField = "")
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT el_id AS ARRAY_KEY ".
			"FROM ?_ilines_content ".
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
			"FROM ?_ilines_content ".
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
				$innerJoinStr = $innerJoinStr." INNER JOIN ?_ilines_content AS innerTable".$i." ON ie.el_id = innerTable".$i.".el_id AND innerTable".$i.".icont_var= '".$sColArray[$i]."' ";
			}
			//print_r($innerJoinStr."<br />");
		}
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_ilines_content AS ic, ".
				"?_ilines_element AS ie ".

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

		// ���������� ���������� � ��������� ��-���
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}


}

?>