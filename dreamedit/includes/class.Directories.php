<?

class Directories
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Directories()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_directories_type.itype_id AS ARRAY_KEY, ?_directories_type.* FROM ?_directories_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_directories_type WHERE itype_id = ?d", $id);
	}

	// получить cписок по type name
	function getTextsByTypeName($type_name)
	{
		global $DB;
		return $DB->select(" SELECT '' AS ARRAY_KEY, '' AS text_ru,'' AS text_en UNION SELECT dck.icont_text AS ARRAY_KEY, dcr.icont_text AS text_ru, dce.icont_text AS text_en FROM ?_directories_content dcr INNER JOIN ?_directories_element de ON de.el_id = dcr.el_id AND dcr.icont_var = 'text_ru' INNER JOIN ?_directories_content dck ON de.el_id = dck.el_id AND dck.icont_var = 'value' INNER JOIN ?_directories_content dce ON dck.el_id = dce.el_id AND dce.icont_var = 'text_en' INNER JOIN ?_directories_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY text_ru", $type_name);
	}


	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов
		$retVal = $DB->select(
			"SELECT ".
				"?_directories_element.el_id AS ARRAY_KEY, ".
				"?_directories_element.* ".
			"FROM ?_directories_element ".
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
		return $DB->selectRow("SELECT * FROM ?_directories_element WHERE el_id = ?d", $id);
	}


	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;


		$rows = $DB->select("SELECT * FROM ?_directories_content  WHERE  el_id IN (?a)", array_keys($elements));

		
		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];
		}
		
		return $elements;
	}
// Получить информациюо семинаре
// получить контент нужных элементов по ID-элемента
	function getSemById($element)
	{
		global $DB;

		if(empty($element))
			return $element;


		$rows = $DB->select("SELECT c.*,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio
							FROM ?_directories_content  AS c 
							LEFT OUTER JOIN ?_directories_content AS pp ON pp.el_id=c.el_id AND pp.icont_var='chif'
		                    LEFT OUTER JOIN persons AS p ON p.id=pp.icont_text
							WHERE  c.el_id =".(int)$element);

		
		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[strtoupper($v["icont_var"])] = $v["icont_text"];
			$elements[FIO]=$v[fio];
		}
		
		return $elements;
	}
	// получить контент нужных элементов по ID-элемента (EN)
	function getSemByIdEn($element)
	{
		global $DB;

		if(empty($element))
			return $element;


		$rows = $DB->select("SELECT c.*,p.Autor_en AS fio
							FROM ?_directories_content  AS c 
							LEFT OUTER JOIN ?_directories_content AS pp ON pp.el_id=c.el_id AND pp.icont_var='chif'
		                    LEFT OUTER JOIN persons AS p ON p.id=pp.icont_text
							WHERE  c.el_id =".(int)$element);

		
		foreach($rows as $v)
		{
			//echo $v["icont_text"];

			$elements[strtoupper($v["icont_var"])] = $v["icont_text"];
			$elements[FIO]=$v[fio];
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
				"?_directories_element AS ie, ".
				"?_directories_content AS ic ".
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
				$innerJoinStr = $innerJoinStr." INNER JOIN ?_directories_content AS innerTable".$i." ON ie.el_id = innerTable".$i.".el_id AND innerTable".$i.".icont_var= '".$sColArray[$i]."' ";
			}
			//print_r($innerJoinStr."<br />");
		}
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_directories_content AS ic, ".
				"?_directories_element AS ie ".

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
				"?_directories_element AS ie, ".
				"?_directories_content AS ic ".
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
			"FROM ?_directories_content ".
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
			"FROM ?_directories_content ".
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
	function getDirectoryElements($directoryname)
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT cv.icont_text AS ARRAY_KEY,ct.icont_text ".
				"FROM ?_directories_type t ".
			 " INNER JOIN ?_directories_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_directories_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
			 " INNER JOIN ?_directories_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text'",
			$directoryname
		);


		return $retVal;
	}
	function getDirectoryRubrics($directoryname)
	{
		global $DB;

		$retVal = $DB->select(
			"SELECT cv.el_id AS id,cv.icont_text AS ARRAY_KEY,ct.icont_text AS text,cc.icont_text AS text_en ".
				"FROM ?_directories_type t ".
			 " INNER JOIN ?_directories_element e ON t.itype_id = e.itype_id AND t.itype_name = ? ".
			 " INNER JOIN ?_directories_content cv ON e.el_id = cv.el_id AND cv.icont_var = 'value' ".
			 " INNER JOIN ?_directories_content ct ON e.el_id = ct.el_id AND ct.icont_var = 'text'".
			 " LEFT JOIN ?_directories_content cc ON e.el_id = cc.el_id AND cc.icont_var = 'text_en'".
			 " LEFT JOIN ?_directories_content o ON e.el_id = o.el_id AND o.icont_var = 'order'
			 ORDER BY o.icont_text
			 ",
			$directoryname
		);


		return $retVal;
	}

// Список всех усдлуг
    function getServiceAll($podr=null)
    {

   	global $DB;
        $where='';
        $where2='';
    	if (!empty($podr) )
    	{
    		if ($podr!='bibl')
    		{
    		$pg=new Pages();
    		$plist0=$pg->getChilds($podr,1);
    		$where_podr='';
    		foreach($plist0 as $plist)
    		{
    			$where_podr.=" p.page_id =".$plist[page_id]. " OR ";
    		}
    		$where_podr.=" p.page_id= ".(int)$podr;
//    		echo "<br />where_podr=".$where_podr;
    		if (!empty($where_podr)) $where_podr="(".$where_podr.")";
    		else $where_podr=1;
    		$list_id0=$DB->select("SELECT DISTINCT IF(substring(p.cv_text,1,1)<>'g',cv_text,'0') AS id,
    		         IF(substring(p.cv_text,1,1)='g',substring(p.cv_text,2),0) AS gid
    		         FROM adm_pages_content AS p
    		         LEFT OUTER JOIN adm_directories_content AS h1 ON h1.el_id=p.cv_text
    		         LEFT OUTER JOIN adm_directories_content AS h2 ON h2.el_id=h1.el_id AND h2.icont_var='value'
    		         WHERE ".$where_podr." AND substring(cv_name,1,6)='uslugi' AND cv_text<>''
    		         ORDER BY h2.icont_text
    		         ");

            }
            else //Услуги библиотеки
            {
             $list_id0[0] = array("id" => 0,"gid" => 33);
             $list_id0[1] = array("id" => 0,"gid" => 32);
             $list_id0[2] = array("id" => 0, "gid" => 31);

            }

 //       echo "<br />";print_r($list_id0);

        foreach($list_id0 as $lid)
        {

             if ($lid[id]<>0)
	        	$where.="c.el_id =".$lid[id]." OR ";
	         if ($lid[gid]<>'')
	         {
	        	$where2.="c.el_id=".$lid[gid]." OR ";
	        	$whereg.="d.el_id=".$lid[gid]." OR ";
	         }
        }
	        if (!empty($where)) $where="(".substr($where,0,-4).") ";
		        else $where="c.el_id=0";
		    if (!empty($whereg)) $whereg=" OR (".substr($whereg,0,-4).")";
	        if (!empty($where2)) $where2="(".substr($where2,0,-4).")";
	        else $where2="c.el_id=0";
        }
//        echo "<br />_podr_".$podr." where=".$where." where2=".$where2;
        if (!empty($_REQUEST[gid]))
        	{
        		$where2="c.el_id=".(int)$_REQUEST[gid];
        		$where="d.icont_text=".(int)$_REQUEST[gid];
        	}
    	if (empty($where)) $where="1";
    	if (empty($where2)) $where2="1";
 // echo $where."<br />".$where2;
    	$rows=$DB->select(
						  "SELECT DISTINCT * FROM (
							  (SELECT DISTINCT 'g' AS type,c.el_id,c.el_id AS gid,'0' AS sid,c.icont_text AS usluga,
                              s.icont_text AS gsort
							  FROM adm_directories_content AS c
							  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=5
							  INNER JOIN adm_directories_content AS s ON s.el_id=c.el_id AND s.icont_var='value'
							  INNER JOIN adm_directories_content AS sort ON sort.el_id=c.el_id AND sort.icont_var='status' AND sort.icont_text='1'
					          WHERE ".$where2." AND c.icont_var='text'
   					          ORDER BY s.icont_text)
					          UNION
							  (SELECT DISTINCT 'u' AS type,c.el_id,d.el_id AS gid,c.el_id AS sid,
							  CONCAT(d.icont_text,'. ',c.icont_text) AS usluga,
							  dd.icont_text AS gsort
					          FROM adm_ilines_content AS c
					          INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND itype_id=4
					          INNER JOIN adm_ilines_content AS s ON e.el_id=s.el_id AND s.icont_var='sort'
					          INNER JOIN adm_ilines_content AS g ON g.el_id=e.el_id AND g.icont_var='gruppa'
							  INNER JOIN adm_ilines_content AS sort ON sort.el_id=c.el_id AND sort.icont_var='status' AND sort.icont_text='1'
					          INNER JOIN adm_directories_content AS d ON d.el_id=g.icont_text AND d.icont_var='text'
					          INNER JOIN adm_directories_content AS dd ON dd.el_id=d.el_id AND dd.icont_var='value'
					         WHERE (". $where.$whereg.")".
					         " AND c.icont_var='title'
					         ORDER BY dd.icont_text,s.icont_text) ) AS z
					         ORDER BY z.gsort,z.gid,sid"
							);


		return $rows;
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
	 function getSemName($id = null)
    {
      global $DB;
      if (!empty($id))
      {
      $rows=$DB->select("SELECT c.icont_text AS name,d.page_id AS sem_id,d2.icont_text AS name_en 
                         FROM adm_directories_content AS c
                         LEFT OUTER JOIN adm_pages_content AS d ON d.cv_text=c.el_id AND d.cv_name='sem'
						 LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=c.el_id AND d2.icont_var='text_en'
                         WHERE c.el_id=".(int)$id." AND c.icont_var='text'");
       return $rows;
      }
      }
	   // Название семинара на англйиском
	   function getSemNameEn($id = null)
    {
      global $DB;
      if (!empty($id))
      {
      $rows=$DB->select("SELECT c.icont_text AS name,d.page_id AS sem_id
                         FROM adm_directories_content AS c
                         LEFT OUTER JOIN adm_pages_content AS d ON d.cv_text=c.el_id AND cv_name='sem'
                         WHERE el_id=".(int)$id." AND icont_var='text_en'");
       return $rows;
      }
      }
	//Все рубрики ГРНТИ (два уровня)
    function getRubricsAll($rub = null,$en=null)
    {
      global $DB;
      if (empty($rub)) $where =1;
      else
         $where="gg.el_id=".(int)$rub;

      if (empty($en))
            $rows=$DB->select("SELECT gg.el_id AS gid,a.el_id AS id,a.icont_text AS rubrica,gg.icont_text AS gruppa,l.icont_text AS level
                  FROM `adm_directories_content` AS a
						INNER JOIN `adm_directories_element` AS e ON e.el_id=a.el_id AND e.itype_id=11
						INNER JOIN `adm_directories_content` AS s ON s.el_id=a.el_id AND s.icont_var='order'
						INNER JOIN `adm_directories_content` AS l ON l.el_id=a.el_id AND l.icont_var='level'
						INNER JOIN `adm_directories_content` AS g ON g.el_id=a.el_id AND g.icont_var='gruppa'
						INNER JOIN `adm_directories_content` AS gg ON gg.el_id=g.icont_text AND gg.icont_var='text'
						INNER JOIN `adm_directories_content` AS ggs ON ggs.el_id=gg.el_id AND ggs.icont_var='order'
						WHERE ".$where." AND a.icont_var='text'
						ORDER BY  ggs.icont_text,s.icont_text,l.icont_text");

       else
            $rows=$DB->select("SELECT gg.el_id AS gid,a.el_id AS id,a.icont_text AS rubrica,gg.icont_text AS gruppa,l.icont_text AS level
                  FROM `adm_directories_content` AS a
						INNER JOIN `adm_directories_element` AS e ON e.el_id=a.el_id AND e.itype_id=11
						INNER JOIN `adm_directories_content` AS s ON s.el_id=a.el_id AND s.icont_var='order'
						INNER JOIN `adm_directories_content` AS l ON l.el_id=a.el_id AND l.icont_var='level'
						INNER JOIN `adm_directories_content` AS g ON g.el_id=a.el_id AND g.icont_var='gruppa'
						INNER JOIN `adm_directories_content` AS gg ON gg.el_id=g.icont_text AND gg.icont_var='text_en'
						INNER JOIN `adm_directories_content` AS ggs ON ggs.el_id=gg.el_id AND ggs.icont_var='order'
						WHERE ".$where." AND a.icont_var='text_en'
						ORDER BY  ggs.icont_text,s.icont_text,l.icont_text");


       return $rows;
     }
}

?>