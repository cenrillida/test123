<?

class Ilines
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Ilines()
	{
		$this->__construct();
	}


	// получить все имеющиеся типы
	function getTypes()
	{
		global $DB;
		return $DB->select("SELECT ?_ilines_type.itype_id AS ARRAY_KEY, ?_ilines_type.* FROM ?_ilines_type ORDER BY itype_name ASC, itype_id ASC");
	}

	// получить тип по ID
	function getTypeById($id)
	{
		global $DB;
		return $DB->selectRow("SELECT * FROM ?_ilines_type WHERE itype_id = ?d", $id);
	}

	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;

		// Запрос на выборку всех эл-тов
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
		return $DB->selectRow("SELECT * FROM ?_ilines_element WHERE el_id = ?d", $id);
	}
  	// Список услуг
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
    		$where_podr.=" p.page_id= ".$podr;
//    		echo "<br />where_podr=".$where_podr;
    		if (!empty($where_podr)) $where_podr="(".$where_podr.")";
    		else $where_podr=1;
    		$list_id0=$DB->select("SELECT c.el_id,c.icont_text AS title,pt.icont_text AS prev_text, ft.icont_text AS full_text
    		         FROM adm_ilines_content AS c
    		         INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND itype_id=4
    		         INNER JOIN adm_ilines_content AS sort ON sort.el_id=c.el_id AND icont_var='sort'
    		         INNER JOIN adm_ilines_content AS s ON s.el_id=c.el_id AND icont_var='status' AND s.icont_text='1'
    		         INNER JOIN adm_ilines_content AS pt ON pt.el_id=c.el_id AND icont_var='prev_text'
    		         INNER JOIN adm_ilines_content AS ft ON ft.el_id=c.el_id AND icont_var='full_text'
    		         WHERE c.icont_var='title'
    		         ORDER BY sort.icont_text
    		         ");

            }
            else //Услуги библиотеки
            {
             $list_id0[0] = array("id" => 0,"id" => 181);
             $list_id0[1] = array("id" => 0,"id" => 188);
             $list_id0[2] = array("id" => 0, "id" => 12);

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
        		$where2="c.el_id=".$_REQUEST[gid];
        		$where="d.icont_text=".$_REQUEST[gid];
        	}
    	if (empty($where)) $where="1";
    	if (empty($where2)) $where2="1";
	}

	// получить контент нужных элементов по ID-элемента
	function appendContent($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;

		$rows = $DB->select("SELECT * FROM ?_ilines_content WHERE  el_id IN (?a)", array_keys($elements));

		foreach($rows as $v)
			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];

		return $elements;
	}
	// получить контент нужных элементов по ID-элемента
	function appendContentDisser($elements)
	{
		global $DB;



		$rows = $DB->select("SELECT c1.el_id,c1.icont_text AS date,c2.icont_text AS date2,
                            f.icont_text AS fio,n.icont_text AS prev_text,t.icont_text AS time,
                            d1.icont_text AS rang,						
							d2.icont_text AS sovet,
							d3.icont_text AS spec,
							ff.icont_text AS full_text,
                            ref.icont_text AS refer,
							v.icont_text='verdict' ,d2.el_id AS sid,ssp.page_id AS spage							
							FROM adm_ilines_content AS c1
							INNER JOIN adm_ilines_content AS c2 ON c2.el_id=c1.el_id AND c2.icont_var='date2'
							INNER JOIN adm_ilines_content AS f ON f.el_id=c1.el_id AND f.icont_var='title'
							INNER JOIN adm_ilines_content AS n ON n.el_id=c1.el_id AND n.icont_var='prev_text'
                            INNER JOIN adm_ilines_content AS t ON t.el_id=c1.el_id AND t.icont_var='time'
							LEFT OUTER JOIN adm_ilines_content AS ff ON ff.el_id=c1.el_id AND ff.icont_var='full_text'	
							LEFT OUTER JOIN adm_ilines_content AS ref ON ref.el_id=c1.el_id AND ref.icont_var='refer'
							LEFT OUTER JOIN adm_ilines_content AS v ON v.el_id=c1.el_id AND v.icont_var='verdict'
							INNER JOIN adm_ilines_content AS dd1 ON dd1.el_id=c1.el_id AND dd1.icont_var='rang'	
                                  INNER JOIN adm_directories_content AS d1 ON d1.el_id=dd1.icont_text AND d1.icont_var='text'
							INNER JOIN adm_ilines_content AS dd2 ON dd2.el_id=c1.el_id AND dd2.icont_var='sovet'	
                                  INNER JOIN adm_directories_content AS d2 ON d2.el_id=dd2.icont_text AND d2.icont_var='text'								  
							INNER JOIN adm_ilines_content AS dd3 ON dd3.el_id=c1.el_id AND dd3.icont_var='spec'	
                                  INNER JOIN adm_directories_content AS d3 ON d3.el_id=dd3.icont_text AND d3.icont_var='text'								  
							INNER JOIN adm_ilines_content AS s ON s.el_id=c1.el_id AND s.icont_var='status' AND s.icont_text=1
							INNER JOIN adm_pages_content AS ssp ON ssp.cv_name='sovet' AND ssp.cv_text=d2.el_id  
		WHERE  c1.icont_var='date' AND c1.el_id IN (?a) ORDER BY c1.icont_text DESC", array_keys($elements));

		

		return $rows;
	}
// Получить полный текест новости
function getFullNewsById($id)
{
   global $DB;
   if(!empty($id))
   {
      $rows=$DB->select
	         ("SELECT a.icont_text AS title,IF(d2.icont_text<'".date("Y.m.d")."',
					  IF(IFNULL(c.icont_text,'')<>'',c.icont_text,b.icont_text),b.icont_text) AS full_text,
					  IF(d2.icont_text<'".date("Y.m.d")."',
					  IF(IFNULL(cen.icont_text,'')<>'' AND cen.icont_text<>'<p>&nbsp;</p>',cen.icont_text,ben.icont_text),ben.icont_text) AS full_text_en,
					  d.icont_text AS date
			          FROM adm_ilines_content AS a
					  INNER JOIN adm_ilines_content AS b ON b.el_id=a.el_id AND b.icont_var='full_text'
					  LEFT OUTER JOIN adm_ilines_content AS ben ON ben.el_id=a.el_id AND ben.icont_var='full_text_en'
					  LEFT OUTER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='report_text'
					  LEFT OUTER JOIN adm_ilines_content AS cen ON cen.el_id=a.el_id AND cen.icont_var='report_text_en'
					  INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date'
					  INNER JOIN adm_ilines_content AS d2 ON d2.el_id=a.el_id AND d2.icont_var='date2'".
//					  INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=1
					 " WHERE a.icont_var='title' AND a.el_id=".$id);
					  
   return ($rows);
   
   
   }
 }  
 // Получить полный текест Публикации в СМИ
function getFullSMIById($id)
{
   global $DB;
   if(!empty($id))
   {
      $rows=$DB->select
	         ("SELECT a.icont_text AS title,b.icont_text AS full_text,t.icont_text AS prev_text,d.icont_text AS date,p.icont_text AS picture
			          FROM adm_ilines_content AS a
					  INNER JOIN adm_ilines_content AS b ON b.el_id=a.el_id AND b.icont_var='full_text'
					  INNER JOIN adm_ilines_content AS t ON t.el_id=a.el_id AND t.icont_var='prev_text'
					  INNER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='small_picture'
					  INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date'
					  INNER JOIN adm_ilines_content AS d2 ON d2.el_id=a.el_id AND d2.icont_var='date2'
					  
					  WHERE a.icont_var='title' AND a.el_id=".$id);
					  
   return ($rows);
   
   
   }
}
	// получить описание услуги по ID-элемента
	function appendContentUsluga($elements)
	{
		global $DB;

		if(empty($elements))
			return $elements;

		$rows = $DB->select("SELECT * FROM ?_ilines_content WHERE  el_id = ".$elements);
        foreach($rows as $v)
			$el[strtoupper($v["icont_var"])] = $v["icont_text"];


		return $el;
	}
// Получить список грантов за один год
	function appendContentGrant($elements,$year,$lines)
	{
		global $DB;



        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersona,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),' ',substring(p.fname,1,1)) AS fio,
                             p.otdel, pd.id_txt AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii
		                     FROM ?_ilines_content AS e
		                     INNER JOIN ?_ilines_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_ilines_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_ilines_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_ilines_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_ilines_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$lines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel
		                              LEFT JOIN stepen AS st ON st.id=p.us
                                      LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND y1.icont_text>=".$year." AND y2.icont_text<=".$year.
		" ORDER BY n.icont_text "

		);


         return $rows;
	}
// Получить список грантов по подразделению за один год
	function getGrantByPodrName($elements,$year,$lines,$podr)
	{
		global $DB;
		$pg = new Pages();
        $id_podr0=$DB->select("SELECT id_txt FROM podr WHERE name='".$podr."'");
        $str="( pd.id_txt=".$id_podr0[0][id_txt]." OR ";
        $pp0= $pg->getChilds($id_podr0[0][id_txt]);    //отдел сектор
        foreach($pp0 as $pp)
        {
        	$str.=" pd.id_txt = ".$pp[page_id]." OR ";
        	$pp20=$pg->getChilds($pp[page_id]);  //группа
        	foreach($pp20 as $pp2)
        	{
                $str.=" pd.id_txt = ".$pp2[page_id]." OR ";
            }
        }
        $str=substr($str,0,-4).")";



        $rows = $DB->select("SELECT e.el_id,e.icont_text AS date,n.icont_text AS title,c3.icont_text AS number,
                             y2.icont_text AS year_beg, y1.icont_text AS year_end,
                             p.id AS idpersona,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
                             p.otdel, pd.id_txt AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii
		                     FROM ?_ilines_content AS e
		                     INNER JOIN ?_ilines_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_ilines_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_ilines_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_ilines_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_ilines_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$lines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel AND ".$str.
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND y1.icont_text>=".$year." AND y2.icont_text<=".$year.
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
                             p.id AS idpersona,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fiofull,
                             CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
                             p.otdel, pd.id_txt AS idpodr,
		                     CONCAT(p.chlen,',',IFNULL(st.short,''),',',IFNULL(zv.short,'')) AS regalii
		                     FROM ?_ilines_content AS e
		                     INNER JOIN ?_ilines_content AS c3 ON c3.el_id=e.el_id AND c3.icont_var='number'
                             INNER JOIN ?_ilines_content AS n ON n.el_id=e.el_id AND n.icont_var='title'
                             INNER JOIN ?_ilines_content AS c ON c.el_id=e.el_id AND c.icont_var='chif'
                             INNER JOIN ?_ilines_content AS y1 ON y1.el_id=e.el_id AND y1.icont_var='year_end'
                             INNER JOIN ?_ilines_content AS y2 ON y2.el_id=e.el_id AND y2.icont_var='year_beg'
                             INNER JOIN ?_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status' AND s.icont_text='1'
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$lines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel ".
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND e.el_id=".$id.
		" ORDER BY n.icont_text  "

		);

         return $rows;
	}

// Получить года, за которые есть гранты
	function GrantYears($elements,$year,$lines)
	{
	global $DB;
	$years0=$DB->select(
						"  SELECT DISTINCT c1.icont_text AS year_beg,c2.icont_text AS year_end FROM `adm_ilines_content` AS c1
							INNER JOIN `adm_ilines_content` AS c2 ON c1.el_id=c2.el_id AND c2.icont_var='year_end'
							INNER JOIN adm_ilines_element AS e ON e.el_id=c1.el_id AND e.itype_id=".$lines.
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

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// получить все элементы из указанных типов с учетом рубрики и если надо, добавить к ним контент
	function getLimitedElementsRub($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$rubric="")
	{
		global $DB;
		$start = "";
		if ($_SESSION[lang]=="/en") $whereen=" ten.icont_text<>'' AND ";
		else $whereen="";
		if (!empty($rubric))
		   $whererub=" IFNULL(r.icont_text,'')=".$rubric;
		else
           $whererub=1; 		
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, IFNULL(d2.icont_text,d.icont_text), ".
				"ie.* ".
			
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ic.el_id AND r.icont_var='rubric' ".
				" LEFT OUTER JOIN ?_ilines_content AS ten ON ten.el_id=ic.el_id AND ten.icont_var='title_en' ".
				" INNER JOIN ?_ilines_content AS d ON d.el_id=ic.el_id AND d.icont_var='date' ".	
				" LEFT OUTER JOIN ?_ilines_content AS d2 ON d2.el_id=ic.el_id AND d2.icont_var='date2' ".				
			"WHERE ".
			     $whereen.$whererub." AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			" ORDER BY IFNULL(d2.icont_text,d2.icont_text) DESC ".
//			"ORDER BY ie.el_date DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);
//print_r($retVal);
		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// получить все элементы из указанных типов и если надо, добавить к ним контент (для семинаров)
	function getLimitedElementsSem($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$semid = "",$year="")
	{
		global $DB;
		$start = "";
		if (!empty($year))
		{
		   $ystr="y.icont_text LIKE '".$year."%'";
   
		}
        else
		{
           $ystr="y.icont_text<>''";		
		}
		if(!empty($count) && !empty($semid))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" INNER JOIN ?_ilines_content AS isem ON isem.el_id=ic.el_id AND isem.icont_var='sem' AND isem.icont_text='".$semid."' ".
				" INNER JOIN ?_ilines_content AS y ON y.el_id=ic.el_id AND y.icont_var='date2' AND ".$ystr." ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY y.icont_text DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// получить все элементы из указанных типов и если надо, добавить к ним контент (для семинаров) count
	function getLimitedElementsSemCount($tid, $count = 10000, $page = 1, $sortField = "", $sortType = "", $statusField = "",$semid = "",$year="")
	{
		global $DB;
		$start = "";
		if (!empty($year))
		{
		   $ystr="y.icont_text LIKE '".$year."%'";
   
		}
        else
		{
           $ystr="y.icont_text<>''";		
		}
		if(!empty($count) && !empty($semid))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY ".
				
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
				" INNER JOIN ?_ilines_content AS isem ON isem.el_id=ic.el_id AND isem.icont_var='sem' AND isem.icont_text='".$semid."' ".
				" INNER JOIN ?_ilines_content AS y ON y.el_id=ic.el_id AND y.icont_var='date2' AND ".$ystr." ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			
			"{LIMIT 0, ".(int)$count."}",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// получить все элементы из указанных типов для плейлиста, добавить к ним контент
	function getLimitedElementsVideo($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$playlist="")
	{
		global $DB;
		$start = "";
		$playlistNumber="";
		if (!empty($playlist)) $playlistNumber=" AND il.icont_text='".$playlist."'";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;




			$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".

			" INNER JOIN ?_ilines_content AS il ON il.el_id=ic.el_id AND il.icont_var='list'".
			" INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status'".
			" INNER JOIN ?_ilines_content AS ir ON ir.el_id=ic.el_id AND ir.icont_var='sort'".
			" WHERE ".
				"ie.itype_id =  ".$tid.
				" AND ie.el_id = ic.el_id ".

				" AND ss.icont_text=1" .
				$playlistNumber.
		    " ORDER BY ir.icont_text"

		);

		// применение сортировки к выбранных эл-там
	//	if(!empty($sortField) && !empty($retVal) && !empty($retVal))
	//		$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// получить все элементы из указанных типов для плейлиста, добавить к ним контент
	function getCountVideo($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$playlist="")
	{
		global $DB;
		$start = "";
		$playlistNumber="";
		if (!empty($playlist)) $playlistNumber=" AND il.icont_text='".$playlist."'";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

       		$retVal = $DB->select(
			"SELECT ".
				"count(distinct ie.el_id) AS count ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".

			" INNER JOIN ?_ilines_content AS il ON il.el_id=ic.el_id AND il.icont_var='list'".
			" INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status'".
			" INNER JOIN ?_ilines_content AS ir ON ir.el_id=ic.el_id AND ir.icont_var='sort'".
			" WHERE ".
				"ie.itype_id =  ".$tid.
				" AND ie.el_id = ic.el_id ".

				" AND ss.icont_text=1" .
				$playlistNumber
		);

		// применение сортировки к выбранных эл-там
	//	if(!empty($sortField) && !empty($retVal) && !empty($retVal))
	//		$retVal = $this->sorting($retVal, $sortField, $sortType);

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

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// посчитать кол-во эл-тов в типе
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
	// посчитать кол-во эл-тов в типе для защит
	function countElementsDiss($tid, $statusField,$diss="")
	{
		global $DB;
        $wherediss=" 1 ";
		if (!empty($diss)) $wherediss=" ddiss.icont_text=".$diss;
		
		return (int)$DB->selectCell(
			"SELECT COUNT(ie.el_id) ".
			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			" LEFT OUTER JOIN ?_ilines_content AS ddiss ON ddiss.el_id=ic.el_id AND ddiss.icont_var='sovet' ".	
			"WHERE ".
			    $wherediss. " AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL",
			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField
		);
	}
	// посчитать кол-во эл-тов в типе с учетом даты
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
	
    function countElementsBank($tid, $statusField)
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

		// применение сортировки к выбранных эл-там
//		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
//			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
		function getAllElements($tid,  $statusField = "")
	{
		global $DB;
		$start = "";
//		if(!empty($count))
//			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

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
			"ORDER BY RAND() "
			,

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
/// получить все элементы из указанных типов и если надо, добавить к ним контент, Дата больше или равна текущей
    function getLimitedElementsDate($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "")
	{
		global $DB;
		$start = "";
		echo "@@@";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT ".
				"id.icont_text as date,".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.* ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' OR id.icont_var='date2') AND id.icont_text>='".(date('Y').".".date('m').".".date('d'))."' ".
			"WHERE t".
				" ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY id.icont_text  ".
			"{LIMIT ?d, ".(int)$count." }",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start

		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	// посчитать кол-во эл-тов в типе
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
function getLimitedElementsMultiSort($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$diss="")
	{

		global $DB;
		$start = "";
		$wherediss=" 1 ";
		
		if (!empty($diss))
		    $wherediss= " IFNULL(ddiss.icont_text,'')=".$diss;
	//	echo "!!!!!!!!!!".$wherediss." @" .$diss;
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
        if ($tid=="*") $where="(ie.itype_id = ?d OR ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id=6 )";
		else $where="ie.itype_id = ?d ";
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
				" innerTable0.icont_text , ".
				"ie.*,it.itype_name,it.itype_name_en ".
			"FROM ".
				"?_ilines_content AS ic, ".
				"?_ilines_element AS ie ".
			"INNER JOIN ?_ilines_type AS it ON it.itype_id=ie.itype_id ".
            "LEFT OUTER JOIN ?_ilines_content AS ddiss ON ddiss.el_id=ie.el_id AND ddiss.icont_var='sovet' ". 
			$innerJoinStr.
			"WHERE ".
				$wherediss." AND ".$where.
				" AND ie.el_id = ic.el_id  ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",

			$tid,
			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
//Новости для главной (новости института и СМИ)	
function getLimitedElementsMultiSortMain($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "")
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

			
			if (isset($_REQUEST[en])) $whereen="INNER JOIN ?_ilines_content AS cen ON cen.el_id=ie.el_id AND cen.icont_var='title_en'".
			                                    " INNER JOIN ?_ilines_content AS ten ON ten.el_id=ie.el_id AND ten.icont_var='prev_text_en'
												 AND ten.icont_text <> '<p>&nbsp;</p>' AND ten.icont_text <> '' 
												";
			else $whereen='';
			
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
				" innerTable0.icont_text , ".
				"ie.* ".
			"FROM ".
				"?_ilines_content AS ic, ".
				"?_ilines_element AS ie ".
            " LEFT OUTER JOIN ?_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date2' ".
			$innerJoinStr.
			$whereen.
			" WHERE ".
			    " IFNULL(dd.icont_text,'') <= '". date("Y.m.d")."' AND ".
				"(ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id = ?d ) ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",

			$tid,
			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}	
	
// С учетом рубрики
function getLimitedElementsDateRub($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".$rubric;
        else $whererubric="1";		 
		  
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
				" innerTable0.icont_text , ".
				"ie.* ".
			"FROM ".
				"?_ilines_content AS ic, ".
				"?_ilines_element AS ie ".

			$innerJoinStr.
			" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='rubric' ".
			" WHERE ".
			    $whererubric. " AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",

			$tid,
			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}	
// Список защит диссертаций
function getDisser($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "")
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
				"adm_ilines_content AS ic, ".
				"adm_ilines_element AS ie ".

		    " INNER JOIN adm_ilines_content AS s ON s.el_id=ic.el_id AND s.icont_text=1 ".	
			"WHERE ".
				"ie.itype_id = ".$tid.
				" AND ie.el_id = ic.el_id ".
				" AND  ic.icont_var  = 'date' AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL ".
			"GROUP BY ie.el_id ".

			"{LIMIT ?d, ".(int)$count."} ",
			
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
    function getLimitedElementsMultiSortDate($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "")
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
			" INNER JOIN ?_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date2' ".
			"WHERE ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				" AND dd.icont_text >= '".date('Y.m.d ')."' ".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",

			$tid,
			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
// Список подразделений для услуги
    function getPodrByUsluga($id)
    {
    	global $DB;

    	$rows=$DB->select("SELECT CONCAT('<a href=/index.php?page_id=',podr.page_id,'>',podr.page_name,'</a>') AS podr ".
    	          " FROM adm_pages AS podr ".
    	          " INNER JOIN adm_pages_content AS podrc ON podrc.page_id=podr.page_id AND substring(podrc.cv_name,1,6)='uslugi'".
    	          " WHERE podrc.cv_text=".$id);

    	return $rows;
    }
// Список услуг для подразделения
    function getUslugaByPodr($id)
    {
    	global $DB;

    	$rows=$DB->select("SELECT CONCAT('<a href=/index.php?page_id=178&id=',c.el_id,'>',c.icont_text,'</a>') AS usl ".
    	          " FROM adm_pages_content AS p ".
    	          " INNER JOIN adm_ilines_content AS c ON c.el_id=p.cv_text AND c.icont_var='title'".
    	          " WHERE p.page_id=".$id." AND substring(p.cv_name,1,6)='uslugi' ");

    	return $rows;
    }
    // Список лет для новостной ленты семинара
    function getSemYears($id)
    {
    	global $DB;

    	$rows=$DB->select("SELECT DISTINCT substring(c.icont_text,1,4) AS year FROM adm_ilines_content AS c
    	                   INNER JOIN adm_ilines_content AS dd ON dd.el_id=c.el_id AND dd.icont_var='sem'
    	                   INNER JOIN adm_directories_content AS d ON d.el_id=dd.icont_text
    	                   WHERE  c.icont_var='date2' AND d.el_id=".$id." AND substring(c.icont_text,1,4)<=". date('Y').
    	                  " ORDER BY substring(c.icont_text,1,4) DESC
    							 ");

    	return $rows;
    }
   // Объявление о семинаре
    function getNewSem($id)
    {
    	global $DB;

    	$rows=$DB->select("SELECT ic.* FROM adm_ilines_content AS ic
    	                   INNER JOIN adm_ilines_content AS dd ON dd.el_id=ic.el_id AND dd.icont_var='sem'
    	                   INNER JOIN adm_ilines_content AS d ON d.el_id=ic.el_id AND d.icont_var='date2'
    	                   WHERE dd.icont_text='".$id."' AND d.icont_text>='". date('Y.m.d')."'".
    	                  " ORDER BY d.icont_text ");
        $elements[0][el_id]=$v[el_id];
		foreach($rows as $v)
			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];

		return $elements;
    	
    }
}

?>