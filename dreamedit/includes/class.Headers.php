<?

class Headers
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Headers()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_headers_type.itype_id AS ARRAY_KEY, ?_headers_type.* FROM ?_headers_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_headers_type WHERE itype_id = ?d", $id);
	}

	// получить cписок по type name
	function getTextsByTypeName($type_name)
	{
		global $DB;
		return $DB->select(" SELECT '' AS ARRAY_KEY, '' AS text_ru,'' AS text_en UNION SELECT dck.icont_text AS ARRAY_KEY, dcr.icont_text AS text_ru, dce.icont_text AS text_en FROM ?_headers_content dcr INNER JOIN ?_headers_element de ON de.el_id = dcr.el_id AND dcr.icont_var = 'text_ru' INNER JOIN ?_headers_content dck ON de.el_id = dck.el_id AND dck.icont_var = 'value' INNER JOIN ?_headers_content dce ON dck.el_id = dce.el_id AND dce.icont_var = 'text_en' INNER JOIN ?_headers_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY text_ru", $type_name);
	}


	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов
		$retVal = $DB->select(
			"SELECT ".
				"?_headers_element.el_id AS ARRAY_KEY, ".
				"?_headers_element.* ".
			"FROM ?_headers_element ".
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
		return $DB->selectRow("SELECT * FROM ?_headers_element WHERE el_id = ?d", $id);
	}


	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;


		$rows = $DB->select("SELECT * FROM ?_headers_content WHERE el_id IN (?a)", array_keys($elements));

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
				"?_headers_element AS ie, ".
				"?_headers_content AS ic ".
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
	function getLimitedElementsMultiSort($tid, $count = 100, $page = 1, $sortFields, $sortTypes, $statusField = "")
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
				$innerJoinStr = $innerJoinStr." INNER JOIN ?_headers_content AS innerTable".$i." ON ie.el_id = innerTable".$i.".el_id AND innerTable".$i.".icont_var= '".$sColArray[$i]."' ";
			}
			//print_r($innerJoinStr."<br />");
		}
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_headers_content AS ic, ".
				"?_headers_element AS ie ".

			$innerJoinStr.
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",
            $statusField,
			$tid,

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
				"?_headers_element AS ie, ".
				"?_headers_content AS ic ".
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
			"FROM ?_headers_content ".
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
			"FROM ?_headers_content ".
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
	// Главная картинка в журналах
	function getJourBanner()
	{
		global $DB;
		
		if (!empty($_SESSION[jour]) && !empty($_SESSION[jour_id]))
		$rows= $DB->select("SELECT '0' AS ARRAY_KEY,m.page_id el_id,
		 'Jour' AS ctype, 'Пустой' AS cclass, 'Журнал' AS title,'001' AS sort,'1' AS  showtitle,
		m.cv_text AS text,m.cv_text AS text_en,i.cv_text AS impact,t2.cv_text AS text2,t3.cv_text AS text3,
		issn.issn AS issn,issn.series,issn.series_en,p2.page_name_en,issn.logo_main,issn.logo_main_info,issn.logo_main_info_en,p2.page_name
							FROM adm_magazine_content AS m
		                    INNER JOIN adm_magazine AS p ON p.page_id=m.page_id AND p.page_parent=".$_SESSION[jour_id].
						   " INNER JOIN adm_magazine AS p2 ON p.page_parent=p2.page_id ".
						   " INNER JOIN adm_magazine_content AS i ON i.page_id=m.page_id AND i.cv_name='impact' ".
						   " INNER JOIN adm_magazine_content AS t2 ON t2.page_id=m.page_id AND t2.cv_name='text2' ".
						   " INNER JOIN adm_magazine_content AS t3 ON t3.page_id=m.page_id AND t3.cv_name='text3' ".
						   " INNER JOIN adm_magazine AS issn ON issn.page_id=".$_SESSION[jour_id].
		                   " WHERE   m.cv_name='picture' ");

	//	print_r($rows);
		return $rows;
	}

	function appendFilterContent($elements) {

        global $DB;

        if (!empty($elements))
            $rows = $DB->select("SELECT * FROM ?_headers_content WHERE el_id IN (?a)", array_keys($elements));

        foreach($elements as $v)
            $elements[$v["page_id"]]["content"] = array();

        foreach($rows as $v)
            $elements[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

        return $elements;

    }

	function getHeaderElements($headername)
	{
		global $DB,$page_content;
       if ($_SESSION[lang]=='/en') $where="  cstatuse.icont_text=1"; else $where=" cstatus.icont_text=1";
		$retVal = $DB->select(
			"SELECT e.el_id AS ARRAY_KEY,e.el_id,ctl.icont_text AS title ,
			IF(cct.icont_text='Общая лента',hh2.icont_text,ct.icont_text)  AS text, cs.icont_text AS sort,
			cf.icont_text AS fname,  IF (cct.icont_text='Общая лента','Текст',cct.icont_text) AS ctype, ccc.icont_text AS cclass, bgc.icont_text AS background_color,
			clp.icont_text AS link_id,
			 mgt.icont_text AS margin_top,
			  mgb.icont_text AS margin_bottom,
			   pbt.icont_text AS padding_top,
			    pbb.icont_text AS padding_bottom,
			    inc.icont_text AS in_container,
			    tl.icont_text AS title_link,
			    tle.icont_text AS title_link_en,
			 cs.icont_text AS sort,
			 st.icont_text AS showtitle,
			 fff.icont_text AS full_text,
			 cf.icont_text AS fname, ccc.icont_text AS cclass,cr.icont_text AS razdel_title,
			clp.icont_text AS link_id,ctle.icont_text AS title_en,
            IF(cct.icont_text='Общая лента',hhe.icont_text,cte.icont_text)  AS text_en,
            rc.icont_text AS rem_card, 
			cstatuse.icont_text AS status_en			".
				" FROM ?_headers_type t ".
			 " INNER JOIN ?_headers_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_headers_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
 			 " INNER JOIN ?_headers_content ctl ON e.el_id = ctl.el_id AND ctl.icont_var = 'title' ".
 			 " LEFT OUTER JOIN ?_headers_content ctle ON e.el_id = ctle.el_id AND ctle.icont_var = 'title_en' ".
			 " INNER JOIN ?_headers_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text' ".
			 " LEFT OUTER JOIN ?_headers_content cte ON e.el_id = cte.el_id AND cte.icont_var = 'text_en' ".
 			 " INNER JOIN ?_headers_content cs ON e.el_id = cs.el_id AND cs.icont_var = 'sort' ".
  			 " INNER JOIN ?_headers_content cct ON e.el_id = cct.el_id AND cct.icont_var = 'ctype' ".
   			 " INNER JOIN ?_headers_content cf ON e.el_id = cf.el_id AND cf.icont_var = 'fname' ".
   			 " LEFT OUTER JOIN ?_headers_content ccc ON e.el_id = ccc.el_id AND ccc.icont_var = 'cclass' ".
            " LEFT OUTER JOIN ?_headers_content bgc ON e.el_id = bgc.el_id AND bgc.icont_var = 'background_color' ".
   			 " LEFT OUTER JOIN ?_headers_content cr ON e.el_id = cr.el_id AND cr.icont_var = 'razdel_title' ".
   			 " LEFT OUTER JOIN ?_headers_content clp ON e.el_id = clp.el_id AND clp.icont_var = 'link_id' ".
   			 " INNER JOIN ?_headers_content cstatus ON e.el_id = cstatus.el_id AND cstatus.icont_var = 'status' ".
   			 " LEFT OUTER JOIN ?_headers_content cstatuse ON e.el_id = cstatuse.el_id AND cstatuse.icont_var = 'status_en' ".
   			 " LEFT OUTER JOIN ?_headers_content AS hh ON hh.el_id=e.el_id AND hh.icont_var='cname'".
			 " LEFT OUTER JOIN ?_headers_content AS st ON st.el_id=e.el_id AND st.icont_var='showtitle'".
   			  " LEFT OUTER JOIN ?_headers_content AS hh2 ON hh2.el_id=hh.icont_text AND hh2.icont_var='text'".
   			  " LEFT OUTER JOIN ?_headers_content AS hhe ON hhe.el_id=hh.icont_text AND hhe.icont_var='text_en'".
   			  " LEFT OUTER JOIN ?_headers_content AS fff ON fff.el_id=e.el_id AND fff.icont_var='full_text'".
            " LEFT OUTER JOIN ?_headers_content AS mgt ON mgt.el_id=e.el_id AND mgt.icont_var='margin_top'".
            " LEFT OUTER JOIN ?_headers_content AS mgb ON mgb.el_id=e.el_id AND mgb.icont_var='margin_bottom'".
            " LEFT OUTER JOIN ?_headers_content AS pbt ON pbt.el_id=e.el_id AND pbt.icont_var='padding_top'".
            " LEFT OUTER JOIN ?_headers_content AS pbb ON pbb.el_id=e.el_id AND pbb.icont_var='padding_bottom'".
            " LEFT OUTER JOIN ?_headers_content AS inc ON inc.el_id=e.el_id AND inc.icont_var='in_container'".
            " LEFT OUTER JOIN ?_headers_content AS tl ON tl.el_id=e.el_id AND tl.icont_var='title_link'".
            " LEFT OUTER JOIN ?_headers_content AS tle ON tle.el_id=e.el_id AND tle.icont_var='title_link_en'".
            " LEFT OUTER JOIN ?_headers_content AS rc ON rc.el_id=e.el_id AND rc.icont_var='rem_card'".
   			 " WHERE ".$where.
 			 " ORDER BY cs.icont_text ",

			$headername
		);
////
/*
  $retVal = $DB->select(
			"SELECT cv.icont_text AS ARRAY_KEY,ctl.icont_text AS title ,
			IF(cct.icont_text='Общая лента',hh2.icont_text,ct.icont_text)  AS text, cs.icont_text AS sort,
			cf.icont_text AS fname,  IF (cct.icont_text='Общая лента','Текст',cct.icont_text) AS ctype, ccc.icont_text AS cclass,
			clp.icont_text AS link_id	".

				" FROM ?_headers_type t ".
			 " INNER JOIN ?_headers_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_headers_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
 			 " INNER JOIN ?_headers_content ctl ON e.el_id = ctl.el_id AND ctl.icont_var = 'title' ".
			 " INNER JOIN ?_headers_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text' ".
 			 " INNER JOIN ?_headers_content cs ON e.el_id = cs.el_id AND cs.icont_var = 'sort' ".
   			 " INNER JOIN ?_headers_content cct ON e.el_id = cct.el_id AND cct.icont_var = 'ctype' ".
   			 " INNER JOIN ?_headers_content ccc ON e.el_id = ccc.el_id AND ccc.icont_var = 'cclass' ".
   			 " INNER JOIN ?_headers_content cf ON e.el_id = cf.el_id AND cf.icont_var = 'fname' ".
   			 " LEFT OUTER JOIN ?_headers_content clp ON e.el_id = clp.el_id AND clp.icont_var = 'link_id' ".
   			 " INNER JOIN ?_headers_content cstatus ON e.el_id = cstatus.el_id AND cstatus.icont_var = 'status' ".
   			 " LEFT OUTER JOIN ?_headers_content AS hh ON hh.el_id=e.el_id AND hh.icont_var='cname'".
   			 " LEFT OUTER JOIN ?_headers_content AS hh2 ON hh2.el_id=hh.icont_text AND hh2.icont_var='text'".
   			 " WHERE cstatus.icont_text = '1' ".
 			 " ORDER BY cs.icont_text ",

			$headername
		);
*/
///

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

     function getINION()
   {
   	  global $DB;
   	  $rows=$DB->select("SELECT a.el_id AS id,a.icont_text AS text
   	                     FROM adm_directories_content AS a
   	                     INNER JOIN adm_directories_content AS s ON s.el_id=a.el_id AND s.icont_var='value'
   	                     INNER JOIN adm_directories_element AS e ON e.el_id=a.el_id AND e.itype_id=4
   	                     WHERE a.icont_var='text'
   	                     ORDER BY s.icont_text");
      return $rows;
	}

    function displayWithTemplate($tpl, $withBack, $withCache, $filterId) {
        global $_CONFIG;
        $file = $withBack ? 'headers_right_jour' : 'headers_right';
        if($withCache == 1 && CacheEngine::getInstance()->checkExclude()) {
            if(CacheEngine::getInstance()->tryLoadFilter($filterId, 0,$_SESSION['lang']=='/en')) {
                CacheEngine::getInstance()->startRegister();
                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.$file.html");
                CacheEngine::getInstance()->finishRegisterFilter($filterId, 0,$_SESSION['lang']=='/en');
            }
        } else {
            $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.$file.html");
        }
    }


}

?>