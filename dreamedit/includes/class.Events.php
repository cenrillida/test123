<?
// Считать события для кадендаря
class Events
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Events()
	{
		$this->__construct();
	}

	// получить cписок по type name
	function getDatesByMonthYearAllLines($ilines_spisok,$month,$year)
	{

		global $DB;
        $il0=explode(",",trim($ilines_spisok));
        $str="(";
        foreach($il0 as $il)
        {
           $str.=" e.itype_id=".$il." OR ";
        }
        $str=substr($str,0,-4).")";



		$retVal = $DB->select(
			"SELECT DISTINCT day(c.icont_text) AS date_event
			FROM adm_ilines_content AS c
			INNER JOIN adm_ilines_element AS e
			      ON e.el_id=c.el_id AND ".$str.
			" INNER JOIN adm_ilines_content AS c2 ON c2.el_id=c.el_id AND c2.icont_var='status' AND c2.icont_text=1
			WHERE c.icont_var='date' ORDER BY day(c.icont_text) "

   	   );
   	   return $retVal;
    }
	function getLimitedElementsDate($str, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$dateBeg,$dateEnd)
	{
		global $DB;
		$start = "";
        if (empty($start)) $start=1;
        if ($count==0) $count=10;
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }

		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

			$retVal = $DB->select(
			"SELECT * FROM
			(SELECT  ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.*,IF(ie.itype_id=1 AND id2.icont_text>id.icont_text,id2.icont_text,id.icont_text) AS date,
				IFNULL(id2.icont_text,0) AS date2, '999999999999999' AS time ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' )
			AND date(id.icont_text) >= date('".$dateBeg."') AND date(id.icont_text) <= date('".$dateEnd."') ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')
			AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1 ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .

			"WHERE  ".$str.

				" AND ie.el_id = ic.el_id ".
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				" AND (e.itype_id<> 15 OR s2.icont_text=1)  ".

			"GROUP BY ie.el_id  ".
			" UNION ".
			" SELECT ie.el_id, ie.*,id2.icont_text AS date,IFNULL(id2.icont_text,0) AS date2,tm.icont_text AS time
				FROM adm_ilines_element AS ie
				INNER JOIN adm_ilines_content AS id ON id.el_id=ie.el_id AND id.icont_var='date'
				INNER JOIN adm_ilines_content AS id2 ON id2.el_id=ie.el_id AND id2.icont_var='date2'
				INNER JOIN adm_ilines_content AS ss ON ss.el_id=ie.el_id AND ss.icont_var='status' AND ss.icont_text=1
				LEFT OUTER JOIN adm_ilines_content AS tm ON tm.el_id=ie.el_id AND tm.icont_var='time'
				WHERE (ie.itype_id=1 )
				AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
				" GROUP BY ie.el_id

			) AS t ".

			" ORDER BY substring(date,1,10)  DESC,time   ".
			"{LIMIT ".$start.", ".(int)$count."}  ");
//			print_r($retVal);

//			$tid,
//			empty($statusField)? DBSIMPLE_SKIP: $statusField,
//			/*empty($start)? DBSIMPLE_SKIP:*/ $start
//		);

		// применение сортировки к выбранных эл-там
		
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
function getLimitedElementsDateCln($str, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$dateBeg,$dateEnd)
	{
		global $DB;
		$start = "";
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }


		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

            
			$retVal = $DB->select(
			"SELECT * FROM
			(SELECT  DISTINCT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.*,IF(ie.itype_id=2 AND id2.icont_text>id.icont_text,id2.icont_text,id.icont_text) AS date,
				IFNULL(id2.icont_text,0) AS date2 ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' OR id.icont_var='date2')
			AND date(id.icont_text) >= date('".str_replace('.','',$dateBeg)."') AND date(id.icont_text) <= date('".str_replace('.','',$dateEnd)."') ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')".

			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1 ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .

			"WHERE ".$str.

				" AND ie.el_id = ic.el_id ".
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				" AND (e.itype_id<> 15 OR s2.icont_text=1)  ".

			"GROUP BY ie.el_id  ".
			" UNION ". //Защиты
			" SELECT ie.el_id, ie.*,id2.icont_text AS date,IFNULL(id2.icont_text,0) AS date2
				FROM adm_ilines_element AS ie
				INNER JOIN adm_ilines_content AS id ON id.el_id=ie.el_id AND id.icont_var='date'
				INNER JOIN adm_ilines_content AS id2 ON id2.el_id=ie.el_id AND id2.icont_var='date2'
				INNER JOIN adm_ilines_content AS ss ON ss.el_id=ie.el_id AND ss.icont_var='status' AND ss.icont_text=1
				WHERE ie.itype_id=6
				AND date(id2.icont_text) >= date('".str_replace('.','',$dateBeg)."') AND date(id2.icont_text) <= date('".str_replace('.','',$dateEnd)."') ".
				" GROUP BY ie.el_id

			) AS t ".

			" ORDER BY date  DESC   ".
			"{LIMIT ".$start.", ".(int)$count."}  ");

//			$tid,
//			empty($statusField)? DBSIMPLE_SKIP: $statusField,
//			/*empty($start)? DBSIMPLE_SKIP:*/ $start
//		);

		// применение сортировки к выбранных эл-там
		if(!empty($sortField) && !empty($retVal) && !empty($retVal))
			$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
	
// С учетом рубрики
function getLimitedElementsDateClnRub($str, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$dateBeg,$dateEnd,$rubric="",$otdel="",$onlyDay=false,$year="",$alfa="",$author="")
	{
		global $DB;
		$start = "";
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }

        if (empty($count)) $count=20;
		if(!empty($count))
		   	if (empty($rubric)) $where_rub= "1";
			else $where_rub=" r.icont_text='".$rubric."' ";  
	    if($rubric==21) $where_rub="(r.icont_text='21' OR IFNULL(r.icont_text,'')='')";

	    if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".$otdel."' ";

	$start = (int)$page < 1? 0: ((int)$page - 1) * $count;
        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ic.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";

        if($onlyDay) {
            $selectionDay = "DISTINCT DAY( date ) AS date_event";
        } else {
            $selectionDay = "*";
        }

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date2' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ic.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
        }
            
			$retVal = $DB->select(
			"SELECT ".$selectionDay." FROM
			(SELECT  DISTINCT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.*,IF(ie.itype_id=2 AND id2.icont_text>id.icont_text,id2.icont_text,id.icont_text) AS date,
				IFNULL(id2.icont_text,0) AS date2 ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' OR id.icont_var='date2') ".
		//	" AND date(id.icont_text) >= date('".str_replace('.','',$dateBeg)."') AND date(id.icont_text) <= date('".str_replace('.','',$dateEnd)."') ".
			" AND id.icont_text >= '".$dateBeg."' AND id.icont_text <= '".$dateEnd." 23:59'".
		
			" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ic.el_id AND r.icont_var='rubric' ".
			"LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')".

			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1 ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .
            $nonewsall_sql.
            $year_sql.
            $author_sql.

			"WHERE ".$str.
                " AND ".$where_rub.
                " AND ".$where_otdel.
				" AND ie.el_id = ic.el_id ".$nonewsall_where.$year_where.$author_where.
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
	

			"GROUP BY ie.el_id  ".
		"	) AS t ".

			" ORDER BY IF(IFNULL(date2,'')<>'',date2,date)   DESC   ".
			"{LIMIT ".$start.", ".(int)$count."}  ");

		return $retVal;
	}
// С учетом рубрики English
function getLimitedElementsDateClnRubEn($str, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$dateBeg,$dateEnd,$rubric="",$otdel="",$onlyDay=false,$year="",$alfa="", $author="")
	{
		global $DB;
		$start = "";
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }
        if (empty($count)) $count=20;
		if(!empty($count))
		   	if (empty($rubric)) $where_rub= "1";
			else $where_rub=" r.icont_text='".$rubric."' ";  
	    if($rubric==21) $where_rub="(r.icont_text='21' OR IFNULL(r.icont_text,'')='')";

	   	if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".$otdel."' ";

	$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ic.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";

        if($onlyDay) {
            $selectionDay = "DISTINCT DAY( date ) AS date_event";
        } else {
            $selectionDay = "*";
        }

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date2' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ic.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
        }

            
			$retVal = $DB->select(
			"SELECT ".$selectionDay." FROM
			(SELECT  DISTINCT ".
				"ie.el_id AS ARRAY_KEY, ".
				"ie.*,IF(ie.itype_id=2 AND id2.icont_text>id.icont_text,id2.icont_text,id.icont_text) AS date,
				IFNULL(id2.icont_text,0) AS date2 ".

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' OR id.icont_var='date2') ".
		//	" AND date(id.icont_text) >= date('".str_replace('.','',$dateBeg)."') AND date(id.icont_text) <= date('".str_replace('.','',$dateEnd)."') ".
			" AND id.icont_text >= '".$dateBeg."' AND id.icont_text <= '".$dateEnd." 23:59'".
		
			" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ic.el_id AND r.icont_var='rubric' ".
			"LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')".

			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
            " LEFT OUTER JOIN ?_ilines_content AS sse ON sse.el_id=ic.el_id AND sse.icont_var='status_en'  ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .
            " INNER JOIN ?_ilines_content AS een ON een.el_id=ic.el_id AND een.icont_var='title_en' AND een.icont_text<>''".
            $nonewsall_sql.
            $year_sql.
            $author_sql.
			" WHERE (ss.icont_text=1 OR sse.icont_text=1) AND ".$str.
                " AND ".$where_rub.
                " AND ".$where_otdel.
				" AND ie.el_id = ic.el_id ".$nonewsall_where.$year_where.$author_where.
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
	

			"GROUP BY ie.el_id  ".
			"
			) AS t ".

			" ORDER BY IF(IFNULL(date2,'')<>'',date2,date)   DESC   ".
			"{LIMIT ".$start.", ".(int)$count."}  ");

//			$tid,
//			empty($statusField)? DBSIMPLE_SKIP: $statusField,
//			/*empty($start)? DBSIMPLE_SKIP:*/ $start
//		);

		// применение сортировки к выбранных эл-там
	//	if(!empty($sortField) && !empty($retVal) && !empty($retVal))
	//		$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}
        function countElementsDate($str, $statusField,$dateBeg,$dateEnd)
	{
		global $DB;
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }

		return (int)$DB->selectCell(
			"SELECT DISTINCT COUNT(el_id) AS count FROM
			(SELECT  DISTINCT ".
				"ie.el_id ".
				

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			"INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' )
			AND date(id.icont_text) >= date('".$dateBeg."') AND date(id.icont_text) <= date('".$dateEnd."') ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')
			AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1 ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .

			"WHERE ".$str.

				" AND ie.el_id = ic.el_id ".
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				

			"GROUP BY ie.el_id  ".
			" UNION ".
			"  SELECT DISTINCT ie.el_id
				FROM adm_ilines_element AS ie
				INNER JOIN adm_ilines_content AS id ON id.el_id=ie.el_id AND id.icont_var='date'
				INNER JOIN adm_ilines_content AS id2 ON id2.el_id=ie.el_id AND id2.icont_var='date2'
				INNER JOIN adm_ilines_content AS ss ON ss.el_id=ie.el_id AND ss.icont_var='status' AND IFNULL(ss.icont_text,'')=1
				WHERE ie.itype_id=6
				AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
				" GROUP BY ie.el_id 

			) AS t ");

	}
	 
// С учетом рубрики
	 function countElementsDateRub($str, $statusField,$dateBeg,$dateEnd,$rubric="",$otdel="",$year="",$alfa="",$author="")
	{
		global $DB;
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }
        
		if (isset($_REQUEST[en])) $whereen="INNER JOIN ?_ilines_content AS ten ON ten.el_id=ic.el_id AND ten.icont_var='title_en' ";
		else $whereen="";
		if (!empty($rubric)) $where="rub.icont_text=".$rubric; else $where=1;

		if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".$otdel."' ";

        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ic.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date2' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ic.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
        }
		
		return (int)$DB->selectCell(
			"SELECT DISTINCT COUNT(el_id) AS count FROM
			(SELECT  DISTINCT ".
				"ie.el_id ".
				

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			$whereen.	
			" INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' )
			AND date(id.icont_text) >= date('".$dateBeg."') AND date(id.icont_text) <= date('".$dateEnd."') ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')
			AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1 ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
			" LEFT OUTER JOIN ?_ilines_content AS rub ON rub.el_id=ic.el_id AND rub.icont_var='rubric'  ".
			" LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .
            $nonewsall_sql.
            $year_sql.
            $author_sql.
			"WHERE ".$str." AND ".$where." AND ".$where_otdel.

				" AND ie.el_id = ic.el_id ".$nonewsall_where.$year_where.$author_where.
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				
/*
			"GROUP BY ie.el_id  ".
			" UNION ".
			"  SELECT DISTINCT ie.el_id
				FROM adm_ilines_element AS ie
				INNER JOIN adm_ilines_content AS id ON id.el_id=ie.el_id AND id.icont_var='date'
				INNER JOIN adm_ilines_content AS id2 ON id2.el_id=ie.el_id AND id2.icont_var='date2'
				INNER JOIN adm_ilines_content AS ss ON ss.el_id=ie.el_id AND ss.icont_var='status' AND IFNULL(ss.icont_text,'')=1
				WHERE ie.itype_id=6
				AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
				" GROUP BY ie.el_id 
*/
		"	) AS t ");

	}
// С учетом рубрики (English)
	 function countElementsDateRubEn($str, $statusField,$dateBeg,$dateEnd,$rubric="",$otdel="",$year="",$alfa="",$author="")
	{
		global $DB;
        if(!empty($dateBeg) && !Dreamedit::validateDate($dateBeg)) {
            $dateBeg = "";
        }
        if(!empty($dateEnd) && !Dreamedit::validateDate($dateEnd)) {
            $dateEnd = "";
        }
        
		if (isset($_REQUEST[en])) $whereen="INNER JOIN ?_ilines_content AS ten ON ten.el_id=ic.el_id AND ten.icont_var='title_en' ";
		else $whereen="";
		if (!empty($rubric)) $where="rub.icont_text=".$rubric; else $where=1;

		if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".$otdel."' ";

        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ic.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date2' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ic.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
        }
		
		return (int)$DB->selectCell(
			"SELECT DISTINCT COUNT(el_id) AS count FROM
			(SELECT  DISTINCT ".
				"ie.el_id ".
				

			"FROM ".
				"?_ilines_element AS ie, ".
				"?_ilines_content AS ic ".
			$whereen.	
			" INNER JOIN ?_ilines_content AS id ".
			"ON id.el_id=ic.el_id AND (id.icont_var='date' )
			AND date(id.icont_text) >= date('".$dateBeg."') AND date(id.icont_text) <= date('".$dateEnd."') ".
			"LEFT OUTER JOIN ?_ilines_content AS id2 ".
			"ON id2.el_id=ic.el_id AND (id2.icont_var='date2')
			AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
			"INNER JOIN ?_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' ".
			" LEFT OUTER JOIN ?_ilines_content AS s2 ON s2.el_id=ic.el_id AND s2.icont_var='status2'  ".
            " LEFT OUTER JOIN ?_ilines_content AS sse ON sse.el_id=ic.el_id AND sse.icont_var='status_en'  ".
			" LEFT OUTER JOIN ?_ilines_content AS rub ON rub.el_id=ic.el_id AND rub.icont_var='rubric'  ".
			" LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
			" INNER JOIN ?_ilines_element AS e ON e.el_id=ic.el_id " .
            " INNER JOIN ?_ilines_content AS een ON een.el_id=ic.el_id AND een.icont_var='title_en' ".
            $nonewsall_sql.
            $year_sql.
            $author_sql.
			" WHERE (ss.icont_text=1 OR sse.icont_text=1) AND ".$str." AND ".$where." AND ".$where_otdel.

				" AND ie.el_id = ic.el_id ".$nonewsall_where.$year_where.$author_where.
				"{AND (ic.icont_var  = 'date' OR ic.icont_var='date2') ".

				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
				

			"GROUP BY ie.el_id  ".
			" UNION ".
			"  SELECT DISTINCT ie.el_id
				FROM adm_ilines_element AS ie
				INNER JOIN adm_ilines_content AS id ON id.el_id=ie.el_id AND id.icont_var='date'
				INNER JOIN adm_ilines_content AS id2 ON id2.el_id=ie.el_id AND id2.icont_var='date2'
				INNER JOIN adm_ilines_content AS ss ON ss.el_id=ie.el_id AND ss.icont_var='status' AND IFNULL(ss.icont_text,'')=1
				WHERE ie.itype_id=6
				AND date(id2.icont_text) >= date('".$dateBeg."') AND date(id2.icont_text) <= date('".$dateEnd."') ".
				" GROUP BY ie.el_id 

			) AS t ");

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
}

?>