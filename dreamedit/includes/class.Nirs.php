<?

class Nirs
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Nirs()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_nirs_type.itype_id AS ARRAY_KEY, ?_nirs_type.* FROM ?_nirs_type ORDER BY itype_sort,itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_nirs_type WHERE itype_id = ?d", $id);
	}

	// получить cписок по type name
	function getTextsByTypeName($type_name)
	{
		global $DB;
		return $DB->select(" SELECT '' AS ARRAY_KEY, '' AS text_ru,'' AS text_en UNION SELECT dck.icont_text AS ARRAY_KEY, dcr.icont_text AS text_ru, dce.icont_text AS text_en FROM ?_nits_content dcr INNER JOIN ?_nirs_element de ON de.el_id = dcr.el_id AND dcr.icont_var = 'text_ru' INNER JOIN ?_nirs_content dck ON de.el_id = dck.el_id AND dck.icont_var = 'value' INNER JOIN ?_nirs_content dce ON dck.el_id = dce.el_id AND dce.icont_var = 'text_en' INNER JOIN ?_nirs_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY text_ru", $type_name);
	}


	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов
		$retVal = $DB->select(
			"SELECT ".
				"?_nirs_element.el_id AS ARRAY_KEY, ".
				"?_nirs_element.* ".
			"FROM ?_nirs_element ".
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
		return $DB->selectRow("SELECT * FROM ?_nirs_element WHERE el_id = ?d", $id);
	}


	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;


		$rows = $DB->select("SELECT * FROM ?_nirs_content WHERE el_id IN (?a)", array_keys($elements));

		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];
		}
		return $elements;
	}
    // Получить содержимое инфоблока по el_id
    function appendContentId($element)
	{
		global $DB;

		if(empty($element))
			return $element;


		$rows = $DB->select("SELECT c.*,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,
		                     t.itype_name,p.otdel,podr.id_txt AS idpodr
		                     FROM ?_nirs_content AS c ".
		                    " INNER JOIN  ?_nirs_content AS cf ON cf.el_id=c.el_id AND cf.icont_var='chif' ".
							" INNER JOIN persons AS p ON p.id=cf.icont_text".
							" LEFT OUTER JOIN podr ON podr.name=p.otdel ".
							" INNER JOIN ?_nirs_element AS e ON e.el_id=c.el_id".
                            " INNER JOIN ?_nirs_type AS t ON t.itype_id=e.itype_id".
							" WHERE c.el_id =".(int)$element
		                    );

		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];
		}
		$elements[$v["el_id"]]["content"][chif_name]=$v["fio"];
		$elements[$v["el_id"]]["content"][grant_type]=$v["itype_name"];
		$elements[$v["el_id"]]["content"][otdel]=$v["otdel"];
		$elements[$v["el_id"]]["content"][idpodr]=$v["idpodr"];
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
				"?_nirs_element AS ie, ".
				"?_nirs_content AS ic ".
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
				$innerJoinStr = $innerJoinStr." INNER JOIN ?_nirs_content AS innerTable".$i." ON ie.el_id = innerTable".$i.".el_id AND innerTable".$i.".icont_var= '".$sColArray[$i]."' ";
			}
			//print_r($innerJoinStr."<br />");
		}
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_nirs_content AS ic, ".
				"?_nirs_element AS ie ".

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
				"?_nirs_element AS ie, ".
				"?_nirs_content AS ic ".
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
			"FROM ?_nirs_content ".
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
			"FROM ?_nirs_content ".
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
	function getNirElements($nirname)
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT cv.icont_text AS ARRAY_KEY,ct.icont_text ".
				"FROM ?_nirs_type t ".
			 " INNER JOIN ?_nirs_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_nirs_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
			 " INNER JOIN ?_nirs_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text_ru'",
			$nirname
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


    // Получить список грантов за один год группировка по направлениям НИР
	function appendContentGrantTema($elements,$year,$lines)
	{
		global $DB;



        $rows = $DB->select("
        SELECT z.tema,z.title,z.year_end,count(z.el_id) AS count,zn.icont_text AS tema_name,z.text FROM
        (SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,tx.icont_text AS text,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'. ',substring(p.fname,1,1),'.') AS fio,
                             IF(podr.page_status=1,IFNULL(podr.name,p.otdel),'') AS otdel, IFNULL(podr.id_txt,pd.id_txt) AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii,
		                     tm.icont_text AS tema

		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             LEFT OUTER JOIN ?_nirs_content AS tm ON tm.el_id=e.el_id AND tm.icont_var='tema'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             LEFT OUTER JOIN ?_nirs_content AS tx ON tx.el_id=e.el_id AND tx.icont_var='text'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".(int)$lines.
     		                       " INNER JOIN persons AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel
		                              LEFT JOIN stepen AS st ON st.id=p.us
                                      LEFT JOIN zvanie AS zv ON zv.id=p.uz
                              LEFT OUTER JOIN podr ON podr.dol1= CONCAT(p.surname,' ',p.name,' ',p.fname) AND
                              (substring(podr.name,1,5)='Отдел' OR substring(podr.name,1,6)='Сектор')

		WHERE  e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.") AS z ".
		" LEFT OUTER JOIN adm_directories_content AS zv ON zv.icont_var='value' AND zv.icont_text = z.tema
		  LEFT OUTER JOIN adm_directories_content AS zn ON zn.icont_var='text' AND zn.el_id=zv.el_id ".
		" GROUP BY tema,year_end "

		);


         return $rows;
	}
	   // Получить список грантов за один год группировка по направлениям НИР, детальный список
	function appendContentGrantTemaSpisok($elements,$year,$lines)
	{
		global $DB;



        $rows = $DB->select("
        SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),' ',substring(p.fname,1,1)) AS fio,
                             IFNULL(podr.name,p.otdel) AS otdel, IFNULL(podr.id_txt,pd.id_txt) AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii,
		                     tm.icont_text AS tema,zn.icont_text AS tema_name

		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             LEFT OUTER JOIN ?_nirs_content AS tm ON tm.el_id=e.el_id AND tm.icont_var='tema'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".(int)$lines.
     		                       " INNER JOIN persons AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel
		                              LEFT JOIN stepen AS st ON st.id=p.us
                                      LEFT JOIN zvanie AS zv ON zv.id=p.uz
                              LEFT OUTER JOIN podr ON podr.dol1= CONCAT(p.surname,' ',p.name,' ',p.fname) AND
                              (substring(podr.name,1,5)='Отдел' OR substring(podr.name,1,6)='Сектор')".
                              " LEFT OUTER JOIN adm_directories_content AS dv ON dv.icont_var='value' AND dv.icont_text = tm.icont_text
		  LEFT OUTER JOIN adm_directories_content AS zn ON zn.icont_var='text' AND zn.el_id=dv.el_id ".
		 "WHERE  e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.

		" ORDER BY tema,year "

		);


         return $rows;
	}
	// Получить Наименование темы по VALUE
	function getTemaName($value)
	{
	    $rows=$DB->select("SELECT n.icont_text AS tema_name
	                       FROM adm_dictionary_content AS v
	                       INNER JOIN adm_dictionary_content AS n ON n.el_id=v.el_id AND n.icont_var='text'
	                       WHERE v.icont_var='value' AND v.icont_text='".$value."'");

	}
	  // Получить список грантов за один год
	function appendContentGrant($elements,$year,$lines)
	{
		global $DB;



        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,tx.icont_text AS text,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'. ',substring(p.fname,1,1),'.') AS fio,
                             IF(podr.page_status=1,IFNULL(podr.page_name,p.otdel),otd.page_name) AS otdel, p.otdel AS idpodr,
                             nu.icont_text AS number,
		                     CONCAT(IFNULL(ran.icont_text,''),',',IFNULL(st.icont_text,''),',',IFNULL(zv.icont_text,'')) AS regalii,
		                     CONCAT(IFNULL(ranexe.icont_text,''),',',IFNULL(stexe.icont_text,''),',',IFNULL(zvexe.icont_text,'')) AS regaliiexe,
		                     CONCAT(pexe.surname,' ',substring(pexe.name,1,1),'. ',substring(pexe.fname,1,1),'.') AS fioexe,
		                     pexe.otdel AS idpodrexe, IF(podrexe.page_status=1,IFNULL(podrexe.page_name,pexe.otdel),otd.page_name) AS otdelexe,
		                     pexe.id AS idpersonsexe,CONCAT(pexe.surname,' ',pexe.name,' ',pexe.fname) AS fiofullexe

		                     FROM ?_nirs_content AS e 
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             LEFT JOIN ?_nirs_content AS exe ON exe.el_id=e.el_id AND exe.icont_var='executor'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_nirs_content AS nu ON nu.el_id=e.el_id AND nu.icont_var='number'
                             LEFT OUTER JOIN ?_nirs_content AS tx ON tx.el_id=e.el_id AND tx.icont_var='text'
                             LEFT OUTER JOIN ?_nirs_content AS otd0 ON otd0.el_id=e.el_id AND otd0.icont_var='otdel'
                             LEFT OUTER JOIN adm_pages AS otd ON otd.page_id=otd0.icont_text
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".(int)$lines.
     		                       " INNER JOIN persons AS p ON p.id=c.icont_text
		                              LEFT JOIN adm_directories_content AS st ON st.el_id=p.us AND st.icont_var='text'
                                      LEFT JOIN adm_directories_content AS zv ON zv.el_id=p.uz AND zv.icont_var='text'
       	                              LEFT JOIN adm_directories_content AS ran ON ran.el_id=p.ran AND ran.icont_var='text'
       	                              LEFT JOIN persons AS pexe ON pexe.id=exe.icont_text
		                              LEFT JOIN adm_directories_content AS stexe ON stexe.el_id=pexe.us AND stexe.icont_var='text'
                                      LEFT JOIN adm_directories_content AS zvexe ON zvexe.el_id=pexe.uz AND zvexe.icont_var='text'
       	                              LEFT JOIN adm_directories_content AS ranexe ON ranexe.el_id=pexe.ran AND ranexe.icont_var='text'

                              LEFT JOIN adm_pages AS podr ON podr.page_id= p.otdel
                              LEFT JOIN adm_pages AS podrexe ON podrexe.page_id= pexe.otdel


		WHERE  e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.
		" ORDER BY n.icont_text "

		);

        return $rows;
	}
	  // Получить о одному гранту
	function appendContentGrantById($el_id)
	{
		global $DB;
 //      echo "###";
       if (!empty($el_id))
       {

        $rows = $DB->select("SELECT DISTINCT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,tx.icont_text AS text,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'. ',substring(p.fname,1,1),'.') AS fio,
                             IF(podr.page_status=1,IFNULL(podr.page_name,p.otdel),otd.page_name) AS otdel, p.otdel AS idpodr,so.icont_text AS source,
                             nu.icont_text AS number,
		                     CONCAT(IFNULL(ran.icont_text,''),',',IFNULL(st.icont_text,''),',',IFNULL(zv.icont_text,'')) AS regalii

		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_nirs_content AS so1 ON so1.el_id=e.el_id AND so1.icont_var='source'
                             INNER JOIN ?_nirs_content AS nu ON nu.el_id=e.el_id AND nu.icont_var='number'
                             INNER JOIN ?_directories_content AS so ON so.el_id=so1.icont_text AND so.icont_var='text'
                             LEFT OUTER JOIN ?_nirs_content AS tx ON tx.el_id=e.el_id AND tx.icont_var='text'
                             LEFT OUTER JOIN ?_nirs_content AS otd0 ON otd0.el_id=e.el_id AND otd0.icont_var='otdel'
                             LEFT OUTER JOIN adm_pages AS otd ON otd.page_id=otd0.icont_text
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'".
                                     " INNER JOIN persons AS p ON p.id=c.icont_text
		                              LEFT JOIN adm_directories_content AS st ON st.el_id=p.us AND st.icont_var='text'
                                      LEFT JOIN adm_directories_content AS zv ON zv.el_id=p.uz AND zv.icont_var='text'
       	                              LEFT JOIN adm_directories_content AS ran ON ran.el_id=p.ran AND ran.icont_var='text'

                              INNER JOIN adm_pages AS podr ON podr.page_id= p.otdel


		WHERE  e.el_id=".(int)$el_id." AND e.icont_var='title' ".
		" ORDER BY n.icont_text "

		);

        return $rows;
       }
	}
// Получить список грантов по подразделению за один год
	function getGrantByPodrName($elements,$year,$lines,$podr,$type="all")
	{
		global $DB;
		$pg = new Pages();
        $str="";$str2='';
        if (!empty($podr))
        {
        $pp0= $pg->getChilds($podr);    //отдел

           $str="otdel=".(int)$podr. " OR ";
           $str.=" otdel2=".(int)$podr. " OR ";
           $str.=" otdel3=".(int)$podr. " OR ";
		   $str2="otd.icont_text=".(int)$podr. " OR ";
           foreach($pp0 as $pp)
            {
               	$str.=" otdel = ".$pp[page_id]." OR ";
               	$str.=" otdel2 = ".$pp[page_id]." OR ";
               	$str.=" otdel3 = ".$pp[page_id]." OR ";
        	    $pp20=$pg->getChilds($pp[page_id]);  //сектор
        	    foreach($pp20 as $pp2)
        	    {
                    $str.=" otdel = ".$pp2[page_id]." OR ";
                    $str.=" otdel2 = ".$pp2[page_id]." OR ";
                    $str.=" otdel3 = ".$pp2[page_id]." OR ";
					$str2="otd.icont_text=".(int)$podr. " OR ";
                 }
            }
            if (!empty($str))
	            $str="(".substr($str,0,-4).")";
	        else $str=1;
			 if (!empty($str2))
	            $str2="(".substr($str2,0,-4).")";
	        else $str2=1;

	        if($year!=-1)
	        	$date_s=" AND (e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.")";
	        else
	        	$date_s="";

	        if($type=="all")
	        	$type_s="(ee.itype_id=2 OR ee.itype_id=3 OR ee.itype_id=6)";
	        else
	        	$type_s="ee.itype_id=".(int)$type;
        $rows = $DB->select("SELECT DISTINCT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number, ee.itype_id AS type,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
                             us.icont_text AS us,uz.icont_text AS uz,
                             CONCAT(IF(ran.icont_text<>'',CONCAT(ran.icont_text,', '),''),
                                    IFNULL(us.icont_text,''),IF(us.icont_text<>'' AND uz.icont_text<>'',', ',''),IFNULL(uz.icont_text,'')) AS regalii
                             FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             
							 LEFT OUTER JOIN ?_nirs_content AS otd ON otd.el_id=e.el_id AND otd.icont_var='otdel'                            
							INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ".$type_s." ".
                            
							
                             " INNER JOIN persons AS p ON p.id=c.icont_text ".
                             " LEFT OUTER JOIN adm_directories_content AS us ON us.el_id=p.us AND us.icont_var='text'".
                             " LEFT OUTER JOIN adm_directories_content AS uz ON uz.el_id=p.uz  AND uz.icont_var='text'".
                             " LEFT OUTER JOIN adm_directories_content AS ran ON ran.el_id=p.ran  AND ran.icont_var='text'".
                         	" WHERE (".$str." OR ".$str2.")".$date_s.
                         	" GROUP BY e.el_id ".
							" ORDER BY y1.icont_text DESC  "

		);
       }

         return $rows;
	}
// Получить список грантов по ID персоны за один год
	function getGrantByPersId($year,$lines,$pers_id)
	{
		global $DB;
		$pg = new Pages();
       



        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             een.itype_name AS grant_type,tm.icont_text AS tema
		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             LEFT OUTER JOIN ?_nirs_content AS tm ON tm.el_id=e.el_id AND tm.icont_var='tema'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND (ee.itype_id=2 OR ee.itype_id=3 OR ee.itype_id=6 OR ee.itype_id=7)".
                             " INNER JOIN ?_nirs_type AS een ON een.itype_id=ee.itype_id ".
                            
		                     
		" WHERE  e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.
		" AND c.icont_text=".(int)$pers_id.
		" ORDER BY n.icont_text  "

		);


         return $rows;
	}
// Получить список грантов по ID подразделению за один год
	function getGrantByPodrId($elements,$year,$lines,$podr_id)
	{
		global $DB;
		$pg = new Pages();
        $str="";




$str="pd.id_txt=".(int)$podr_id;



        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersons,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
                             IFNULL(pd.name,p.otdel) AS otdel, pd.id_txt AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii,
		                     een.itype_name AS grant_type,tm.icont_text AS tema
		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             LEFT OUTER JOIN ?_nirs_content AS tm ON tm.el_id=e.el_id AND tm.icont_var='tema'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".(int)$lines.
                             " INNER JOIN ?_nirs_type AS een ON een.itype_id=ee.itype_id ".
                             " INNER JOIN persons AS p ON p.id=c.icont_text ".

                             " INNER JOIN podr AS pd ON pd.name=p.otdel AND (".$str.
		                              ") OR (pd.dol1=CONCAT(p.surname,' ',p.name,' ',p.fname)
		                              AND (SUBSTRING(pd.name,1,5)='Отдел' OR SUBSTRING(pd.name,1,6) = 'Сектор')
		                              AND ".$str.
		                              ")".
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND y1.icont_text>=".(int)$year." AND y2.icont_text<=".(int)$year.
		" ORDER BY n.icont_text  "

		);


         return $rows;
	}	
// Список гранта по ID
function getGrantById($elements,$year,$lines,$id)
	{
		global $DB;
		$pg = new Pages();




        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersonw,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
                             IFNULL(podr.name,p.otdel) AS otdel, IFNULL(podr.id_txt,pd.id_txt) AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii,
		                     d2.icont_text AS tema
		                     FROM ?_nirs_content AS e
		                     INNER JOIN ?_nirs_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_nirs_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_nirs_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_nirs_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_nirs_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             LEFT OUTER JOIN ?_nirs_content AS tm ON tm.el_id=e.el_id AND tm.icont_var='tema'
                             LEFT OUTER JOIN ?_directories_content AS d ON d.icont_var='value' AND d.icont_text=tm.icont_text
                             LEFT OUTER JOIN ?_directories_content AS d2 ON d2.el_id=d.el_id AND d2.icont_var='text'
                             INNER JOIN ?_nirs_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_nirs_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".(int)$lines.
     		                       " INNER JOIN persons AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel ".
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz
                              LEFT OUTER JOIN podr ON podr.dol1= CONCAT(p.surname,' ',p.name,' ',p.fname) AND
                              (substring(podr.name,1,5)='Отдел' OR substring(podr.name,1,6)='Сектор')
		WHERE  e.icont_var='date' AND e.el_id=".(int)$id.
		" ORDER BY n.icont_text  "

		);

         return $rows;
	}

// Получить года, за которые есть гранты
	function GrantYears($elements,$year,$lines)
	{
	global $DB;
	$years0=$DB->select(
						"  SELECT DISTINCT c1.icont_text AS year_beg,c2.icont_text AS year_end FROM `adm_nirs_content` AS c1
							INNER JOIN `adm_nirs_content` AS c2 ON c1.el_id=c2.el_id AND c2.icont_var='year_end'
							INNER JOIN adm_nirs_element AS e ON e.el_id=c1.el_id AND e.itype_id=".(int)$lines.
						   " WHERE c1.icont_var='year_beg' ORDER BY c2.icont_text DESC
						");


	$ymin=$years0[0][year_end];
	foreach($years0 as $y)
	{
	   if ($y[year_beg] <$ymin)
	       $ymin=$y[year_beg];
	}
	$year=array("beg"=>$ymin,"end"=>$years0[0][year_end]);

	return $year;
    }

//______________________________________________________________________________
//              ПРНД
//______________________________________________________________________________
//Вссего публикаций на сайте
  function getSiteSpisokByFio($fio,$year)
  {
       global $DB;
       $spisok_site0=$DB->select("(SELECT 'Книга' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=38
                WHERE p.id=".$fio.
                     " AND prnd=1 ".
                     " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip=1 AND (l.vid=1 OR l.vid=6) AND ".
                     " ( substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                      "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") ".

               "  UNION ".

                "(SELECT 'Статья' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear
                FROM publ AS l
                INNER JOIN persona AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=37
                WHERE p.id=".$fio.
                      " AND prnd=1 ".
                      " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip<>3 AND NOT (l.vid=1 OR l.vid=6 OR l.vid=8) AND
                      (substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                       "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") ".
                  "  UNION ".

                "(SELECT 'Аннотация' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=39
                WHERE p.id=".$fio.
                      " AND prnd=1 ".
                      " AND NOT `link` LIKE '%.pdf%' ".
                      " AND l.tip<>3 AND l.vid<>8 AND
                      (substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                       "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") "

                      );


        return $spisok_site0;
    }

// Посчитать баллы за публикацию на сайте по годам
    function getSiteBallByFio($fio,$year)
  {
       global $DB;
       $spisok_site0=$DB->select("
             SELECT fio,sum(ball) AS ball,pyear,surname FROM

             ((
             SELECT 'Книга' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear,p.id AS fio,p.surname
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=38
                WHERE p.id=".$fio.
                     " AND prnd=1 ".
                     " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip=1 AND (l.vid=1 OR l.vid=6) AND ".
                     " ( substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                      "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") ".

               "  UNION ".

                "(SELECT 'Статья' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear,p.id AS fio,p.surname
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=37
                WHERE p.id=".$fio.
                      " AND prnd=1 ".
                      " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip<>3 AND NOT (l.vid=1 OR l.vid=6 OR l.vid=8) AND
                      (substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                       "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).")".

                "  UNION ".

                "(SELECT 'Аннотация' AS gtype,l.name,l.name2,l.year,d1.text AS vid,d2.text AS type,
                  d01.ball AS ball,d01.name AS publ_type1,d1.text AS vid_type,l.`link`,
                  CONCAT('20',substring(l.date,7,2)) AS pyear,p.id AS fio,p.surname
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=39
                WHERE p.id=".$fio.
                      " AND prnd=1 ".
                      " AND NOT `link` LIKE '%.pdf%' ".
                      " AND l.tip<>3 AND l.vid<>8 AND
                      (substring(l.date,7.2)=".(substr($year,2,2)-2)." OR ".
                       "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).")) AS sp GROUP BY fio,pyear"

                      );


        return $spisok_site0;
    }



//Список публикаций на сайте
    function getListSitePublByFioId($fio,$year)
  {
       global $DB;


    $spisok_site0=$DB->select("(SELECT 'Книга' AS gtype,count(l.id)*d01.ball AS count
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=38
                WHERE p.id=".$fio.
                        " AND prnd=1 ".
                     " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip=1 AND (l.vid=1 OR l.vid=6) AND ".
                     " ( substring(l.date,7.2)=".substr($year,2,2)." OR ".
                      "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") ".

               "  UNION ".

                "(SELECT 'Статья' AS gtype,count(l.id)*d01.ball AS count
                FROM publ AS l
                INNER JOIN persons AS p ON
                      l.AVTOR LIKE CONCAT(p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id,'<br>%') OR
                      l.AVTOR LIKE CONCAT('%<br>',p.id)
                INNER JOIN vid AS d1 ON d1.id=(l.vid-1)
                INNER JOIN type AS d2 ON d2.id=(l.tip-1)
                INNER JOIN prnd_dict_public_10 AS d01 ON d01.prnd_type='site' AND d01.id=37
                WHERE p.id=".$fio.
                 " AND prnd=1 ".
                     " AND `link` LIKE '%.pdf%' ".
                      " AND l.tip<>3 AND NOT (l.vid=1 OR l.vid=6 OR l.vid=8) AND
                      (substring(l.date,7.2)=".substr($year,2,2)." OR ".
                       "substring(l.date,7.2)=".(substr($year,2,2)-1).")".
                      " AND year > ".($year-6).") "

                      );
                 return $spisok_site0;

    }

    function echoGrantList($header, $rowsn) {
        echo "<h4>$header:</h4>";
        echo "<ul class='speclist'>";
        foreach($rowsn as $row)
        {
            if ($row["year_beg"]!=$row["year_end"]) $years=$row["year_beg"]."-".$row["year_end"]." гг."; else $years=$row["year_end"]." г.";
            echo "<li style='list-style-type: square'>".$row["title"]."<br />".
                "Сроки выполнения: ".$years."<br />".
                "Руководитель: ".$row["regalii"]." ".$row["fio"]."</li>";
        }
        echo "</ul>";
    }

    function echoGrantListByType($header, $type) {
        $rowsn=$this->getGrantByPodrName(0,-1,16,$_REQUEST["page_id"],$type);

        if (count($rowsn)>0 && $_SESSION["lang"]!="/en")
        {
            $this->echoGrantList($header,$rowsn);
        }
    }


}

?>