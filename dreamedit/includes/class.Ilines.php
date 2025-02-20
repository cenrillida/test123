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

    // получить тип по ID
    function getTypeByIdArray($id)
    {
        global $DB;
        return $DB->select("SELECT ?_ilines_type.itype_id AS ARRAY_KEY, ?_ilines_type.* FROM ?_ilines_type WHERE itype_id = ?d", $id);
    }

    // получить тип по ID
    function getTypeByElementIdArray($id)
    {
        global $DB;
        return $DB->select("SELECT itype_id FROM ?_ilines_element WHERE el_id = ?d", $id);
    }

	// получить все элементы из указанных типов и если надо, добавить к ним контент
	function getElementsByType($tIds, $sortField = "", $sortType = "", $statusField = "", $limit="")
	{
		global $DB;

//		$limit_str = "";
//
//		if(!empty($limit)) {
//		    $limit_str = " LIMIT ".(int)$limit;
//        }

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


		if(!empty($limit)) {
		    return array_slice($retVal,0,$limit,true);
        }

		return $retVal;
	}

    function getElementsByTypeLastTwoYears($tIds, $sortField = "", $sortType = "", $statusField = "")
    {
        global $DB;

        // Запрос на выборку всех эл-тов
        $retVal = $DB->select(
            "SELECT ".
            "ae.el_id AS ARRAY_KEY, ".
            "ae.* ".
            "FROM ?_ilines_element AS ae ".
            "LEFT JOIN ?_ilines_content AS d ON ae.el_id=d.el_id AND d.icont_var='date' ".
            "LEFT JOIN ?_ilines_content AS ds ON ae.el_id=ds.el_id AND ds.icont_var='date_s' ".
            "WHERE ".
            "itype_id IN (?a) AND (YEAR(d.icont_text)=YEAR( CURDATE( ) ) OR YEAR(d.icont_text)=(YEAR( CURDATE( ) ) -1) OR d.icont_text IS NULL) AND (YEAR(ds.icont_text)=YEAR( CURDATE( ) ) OR YEAR(ds.icont_text)=(YEAR( CURDATE( ) ) -1) OR ds.icont_text IS NULL) ".
            "ORDER BY ae.el_date DESC",

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
    		$where_podr.=" p.page_id= ".(int)$podr;
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
        		$where2="c.el_id=".(int)$_REQUEST[gid];
        		$where="d.icont_text=".(int)$_REQUEST[gid];
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
							d4.icont_text AS spec2,
							ff.icont_text AS full_text,
							ct.icont_text AS common_text,
                            ref.icont_text AS refer,
							v.icont_text='verdict' ,d2.el_id AS sid,ssp.page_id AS spage, tof.icont_text AS title_off							
							FROM adm_ilines_content AS c1
							INNER JOIN adm_ilines_content AS c2 ON c2.el_id=c1.el_id AND c2.icont_var='date2'
							INNER JOIN adm_ilines_content AS f ON f.el_id=c1.el_id AND f.icont_var='title'
							INNER JOIN adm_ilines_content AS n ON n.el_id=c1.el_id AND n.icont_var='prev_text'
                            INNER JOIN adm_ilines_content AS t ON t.el_id=c1.el_id AND t.icont_var='time'
							LEFT OUTER JOIN adm_ilines_content AS ff ON ff.el_id=c1.el_id AND ff.icont_var='full_text'	
							LEFT OUTER JOIN adm_ilines_content AS ct ON ct.el_id=c1.el_id AND ct.icont_var='common_text'
							LEFT OUTER JOIN adm_ilines_content AS ref ON ref.el_id=c1.el_id AND ref.icont_var='refer'
							LEFT OUTER JOIN adm_ilines_content AS v ON v.el_id=c1.el_id AND v.icont_var='verdict'
							LEFT JOIN adm_ilines_content AS dd1 ON dd1.el_id=c1.el_id AND dd1.icont_var='rang'	
                                  LEFT JOIN adm_directories_content AS d1 ON d1.el_id=dd1.icont_text AND d1.icont_var='text'
							LEFT JOIN adm_ilines_content AS dd2 ON dd2.el_id=c1.el_id AND dd2.icont_var='sovet'	
                                  LEFT JOIN adm_directories_content AS d2 ON d2.el_id=dd2.icont_text AND d2.icont_var='text'								  
							LEFT JOIN adm_ilines_content AS dd3 ON dd3.el_id=c1.el_id AND dd3.icont_var='spec'	
                                  LEFT JOIN adm_directories_content AS d3 ON d3.el_id=dd3.icont_text AND d3.icont_var='text'	
							LEFT JOIN adm_ilines_content AS dd4 ON dd4.el_id=c1.el_id AND dd4.icont_var='spec2'	
                                  LEFT JOIN adm_directories_content AS d4 ON d4.el_id=dd4.icont_text AND d4.icont_var='text'
                                  LEFT JOIN adm_ilines_content AS tof ON tof.el_id=c1.el_id AND tof.icont_var='title_off'								  
							LEFT JOIN adm_ilines_content AS s ON s.el_id=c1.el_id AND s.icont_var='status' AND s.icont_text=1
							LEFT JOIN adm_pages_content AS ssp ON ssp.cv_name='sovet' AND ssp.cv_text=d2.el_id  
		WHERE  c1.icont_var='date' AND c1.el_id IN (?a) ORDER BY c1.icont_text DESC", array_keys($elements));

		

		return $rows;
	}
// Получить полный текест новости
function getFullNewsById($id)
{
   global $DB;
   $cleanId = (int)$id;
   if(!empty($cleanId))
   {
      $rows=$DB->select
	         ("SELECT a.icont_text AS title,IF(d2.icont_text<'".date("Y.m.d")."',
					  IF(IFNULL(c.icont_text,'')<>'',c.icont_text,b.icont_text),b.icont_text) AS full_text,
					  IF(d2.icont_text<'".date("Y.m.d")."',
					  IF(IFNULL(cen.icont_text,'')<>'' AND cen.icont_text<>'<p>&nbsp;</p>',cen.icont_text,ben.icont_text),ben.icont_text) AS full_text_en,
					  d.icont_text AS date, d2.icont_text AS date2, c.icont_text AS report_text, cen.icont_text AS report_text_en, tsi.icont_text AS title_seo_ilines, tsie.icont_text AS title_seo_ilines_en,
					  descr.icont_text AS descr_seo_ilines, descre.icont_text AS descr_seo_ilines_en, keyw.icont_text AS keywords_seo_ilines, keywe.icont_text AS keywords_seo_ilines_en,
					  ogi.icont_text AS og_image_ilines, ogie.icont_text AS og_image_ilines_en, ogv.icont_text AS og_video_ilines, ogve.icont_text AS og_video_ilines_en, oga.icont_text AS og_audio_ilines, ogae.icont_text AS og_audio_ilines_en, tie.icont_text AS title_en, st.icont_text AS status, ste.icont_text AS status_en, gc.icont_text AS get_code, nrc.icont_text AS no_right_column, nt.icont_text AS no_top, nc.icont_text AS no_counter, ss.icont_text AS swiper_slider, ssh.icont_text AS swiper_slider_height
			          FROM adm_ilines_content AS a
					  INNER JOIN adm_ilines_content AS b ON b.el_id=a.el_id AND b.icont_var='full_text'
					  LEFT OUTER JOIN adm_ilines_content AS ben ON ben.el_id=a.el_id AND ben.icont_var='full_text_en'
					  LEFT OUTER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='report_text'
					  LEFT OUTER JOIN adm_ilines_content AS cen ON cen.el_id=a.el_id AND cen.icont_var='report_text_en'
					  LEFT OUTER JOIN adm_ilines_content AS tsi ON tsi.el_id=a.el_id AND tsi.icont_var='title_seo_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS tsie ON tsie.el_id=a.el_id AND tsie.icont_var='title_seo_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS descr ON descr.el_id=a.el_id AND descr.icont_var='descr_seo_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS descre ON descre.el_id=a.el_id AND descre.icont_var='descr_seo_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS keyw ON keyw.el_id=a.el_id AND keyw.icont_var='keywords_seo_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS keywe ON keywe.el_id=a.el_id AND keywe.icont_var='kwords_seo_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS ogi ON ogi.el_id=a.el_id AND ogi.icont_var='og_image_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS ogie ON ogie.el_id=a.el_id AND ogie.icont_var='og_image_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS ogv ON ogv.el_id=a.el_id AND ogv.icont_var='og_video_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS ogve ON ogve.el_id=a.el_id AND ogve.icont_var='og_video_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS oga ON oga.el_id=a.el_id AND oga.icont_var='og_audio_ilines'
					  LEFT OUTER JOIN adm_ilines_content AS ogae ON ogae.el_id=a.el_id AND ogae.icont_var='og_audio_ilines_en'
					  LEFT OUTER JOIN adm_ilines_content AS tie ON tie.el_id=a.el_id AND tie.icont_var='title_en'
					  LEFT OUTER JOIN adm_ilines_content AS st ON st.el_id=a.el_id AND st.icont_var='status'
					  LEFT OUTER JOIN adm_ilines_content AS ste ON ste.el_id=a.el_id AND ste.icont_var='status_en'
					  LEFT OUTER JOIN adm_ilines_content AS gc ON gc.el_id=a.el_id AND gc.icont_var='get_code'
					  LEFT OUTER JOIN adm_ilines_content AS nrc ON nrc.el_id=a.el_id AND nrc.icont_var='no_right_column'
					  LEFT OUTER JOIN adm_ilines_content AS nt ON nt.el_id=a.el_id AND nt.icont_var='no_top'
					  LEFT OUTER JOIN adm_ilines_content AS nc ON nc.el_id=a.el_id AND nc.icont_var='no_counter'
					  LEFT OUTER JOIN adm_ilines_content AS ss ON ss.el_id=a.el_id AND ss.icont_var='swiper_slider'
                      LEFT OUTER JOIN adm_ilines_content AS ssh ON ssh.el_id=a.el_id AND ssh.icont_var='swiper_slider_height'
					  INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date'
					  INNER JOIN adm_ilines_content AS d2 ON d2.el_id=a.el_id AND d2.icont_var='date2'".
//					  INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=1
					 " WHERE a.icont_var='title' AND a.el_id=?", $cleanId);
					  
   return ($rows);
   
   
   }
 }  
 // Получить полный текест Публикации в СМИ
function getFullSMIById($id)
{
   global $DB;
    $cleanId = (int)$id;
   if(!empty($cleanId))
   {
   	if($_SESSION[lang]!="/en")
      $rows=$DB->select
	         ("SELECT a.icont_text AS title,b.icont_text AS full_text,t.icont_text AS prev_text,d.icont_text AS date,p.icont_text AS picture, st.icont_text AS status, gc.icont_text AS get_code, nrc.icont_text AS no_right_column
			          FROM adm_ilines_content AS a
					  INNER JOIN adm_ilines_content AS b ON b.el_id=a.el_id AND b.icont_var='full_text'
					  INNER JOIN adm_ilines_content AS t ON t.el_id=a.el_id AND t.icont_var='prev_text'
					  INNER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='small_picture'
					  INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date'
					  INNER JOIN adm_ilines_content AS d2 ON d2.el_id=a.el_id AND d2.icont_var='date2'
					  LEFT OUTER JOIN adm_ilines_content AS st ON st.el_id=a.el_id AND st.icont_var='status'
					  LEFT OUTER JOIN adm_ilines_content AS gc ON gc.el_id=a.el_id AND gc.icont_var='get_code'
					  LEFT OUTER JOIN adm_ilines_content AS nrc ON nrc.el_id=a.el_id AND nrc.icont_var='no_right_column'
					  
					  WHERE a.icont_var='title' AND a.el_id=".$cleanId);
	else
		$rows=$DB->select
	         ("SELECT a.icont_text AS title,b.icont_text AS full_text,t.icont_text AS prev_text,d.icont_text AS date,p.icont_text AS picture, st.icont_text AS status, gc.icont_text AS get_code, nrc.icont_text AS no_right_column
			          FROM adm_ilines_content AS a
					  INNER JOIN adm_ilines_content AS b ON b.el_id=a.el_id AND b.icont_var='full_text_en'
					  INNER JOIN adm_ilines_content AS t ON t.el_id=a.el_id AND t.icont_var='prev_text_en'
					  INNER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='small_picture'
					  INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date'
					  INNER JOIN adm_ilines_content AS d2 ON d2.el_id=a.el_id AND d2.icont_var='date2'
					  LEFT OUTER JOIN adm_ilines_content AS st ON st.el_id=a.el_id AND st.icont_var='status'
					  LEFT OUTER JOIN adm_ilines_content AS gc ON gc.el_id=a.el_id AND gc.icont_var='get_code'
					  LEFT OUTER JOIN adm_ilines_content AS nrc ON nrc.el_id=a.el_id AND nrc.icont_var='no_right_column'
					  
					  
					  WHERE a.icont_var='title_en' AND a.el_id=".$cleanId);
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

        $cleanYear = (int)$year;
        $cleanLines = (int)$lines;

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
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$cleanLines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel
		                              LEFT JOIN stepen AS st ON st.id=p.us
                                      LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND y1.icont_text>=".$cleanYear." AND y2.icont_text<=".$cleanYear.
		" ORDER BY n.icont_text "

		);


         return $rows;
	}
// Получить список грантов по подразделению за один год
	function getGrantByPodrName($elements,$year,$lines,$podr)
	{
		global $DB;

        $cleanYear = (int)$year;
        $cleanLines = (int)$lines;

		$pg = new Pages();
        $id_podr0=$DB->select("SELECT id_txt FROM podr WHERE name=?",$podr);
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
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$cleanLines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel AND ".$str.
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND y1.icont_text>=".$cleanYear." AND y2.icont_text<=".$cleanYear.
		" ORDER BY n.icont_text  "

		);


         return $rows;
	}
// Список гранта по ID
function getGrantById($elements,$year,$lines,$id)
	{
		global $DB;
		$pg = new Pages();

        $cleanLines = (int)$lines;
		$cleanId = (int)$id;



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
                             INNER JOIN ?_ilines_element AS ee ON ee.el_id=e.el_id AND ee.itype_id=".$cleanLines.
     		                       " INNER JOIN persona AS p ON p.id=c.icont_text
		                              INNER JOIN podr AS pd ON pd.name=p.otdel ".
		                              " LEFT JOIN stepen AS st ON st.id=p.us
                                        LEFT JOIN zvanie AS zv ON zv.id=p.uz

		WHERE  e.icont_var='date' AND e.el_id=".$cleanId.
		" ORDER BY n.icont_text  "

		);

         return $rows;
	}

// Получить года, за которые есть гранты
	function GrantYears($elements,$year,$lines)
	{
	global $DB;
        $cleanLines = (int)$lines;
	$years0=$DB->select(
						"  SELECT DISTINCT c1.icont_text AS year_beg,c2.icont_text AS year_end FROM `adm_ilines_content` AS c1
							INNER JOIN `adm_ilines_content` AS c2 ON c1.el_id=c2.el_id AND c2.icont_var='year_end'
							INNER JOIN adm_ilines_element AS e ON e.el_id=c1.el_id AND e.itype_id=".$cleanLines.
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
	function getLimitedElementsRub($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$rubric="",$otdel="", $year="",$alfa="",$author="")
	{
		global $DB;
		$start = "";
		if ($_SESSION[lang]=="/en") $whereen=" ten.icont_text<>'' AND ";
		else $whereen="";
		if (!empty($rubric))
		   $whererub=" IFNULL(r.icont_text,'')=".(int)$rubric;
		else
           $whererub=1; 	
        if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".(int)$otdel."' ";

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ic.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
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
				" LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
				" INNER JOIN ?_ilines_content AS d ON d.el_id=ic.el_id AND d.icont_var='date' ".	
				" LEFT OUTER JOIN ?_ilines_content AS d2 ON d2.el_id=ic.el_id AND d2.icont_var='date2' ".$alfa_sql.$year_sql.$author_sql.
			"WHERE ".
			     $whereen.$whererub." AND ".$where_otdel." AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$alfa_where.$year_where.$author_where.
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
	//количество для фукнции сверху
	function getLimitedElementsRubCount($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$rubric="",$otdel="", $year = "", $alfa="",$author="")
	{
		global $DB;
		$start = "";
		if ($_SESSION[lang]=="/en") $whereen=" ten.icont_text<>'' AND ";
		else $whereen="";
		if (!empty($rubric))
		   $whererub=" IFNULL(r.icont_text,'')=".(int)$rubric;
		else
           $whererub=1; 		
        if(empty($otdel)) $where_otdel = "1";
	    else $where_otdel = " otd.icont_text='".(int)$otdel."' ";

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ic.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ic.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
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
				" LEFT OUTER JOIN ?_ilines_content AS otd ON otd.el_id=ic.el_id AND otd.icont_var='otdel' ".
				" INNER JOIN ?_ilines_content AS d ON d.el_id=ic.el_id AND d.icont_var='date' ".	
				" LEFT OUTER JOIN ?_ilines_content AS d2 ON d2.el_id=ic.el_id AND d2.icont_var='date2' ".$alfa_sql.$year_sql.$author_sql.
			"WHERE ".
			     $whereen.$whererub." AND ".$where_otdel." AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$alfa_where.$year_where.$author_where.
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			" ORDER BY IFNULL(d2.icont_text,d2.icont_text) DESC ".
//			"ORDER BY ie.el_date DESC ".
			"",

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);
//print_r($retVal);
		// применение сортировки к выбранных эл-там
		

		return count($retVal);
	}
	// получить все элементы из указанных типов и если надо, добавить к ним контент (для семинаров)
	function getLimitedElementsSem($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "",$semid = "",$year="")
	{
		global $DB;
		$start = "";
		if (!empty($year))
		{
		   $ystr="y.icont_text LIKE '".(int)$year."%'";
   
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
				" INNER JOIN ?_ilines_content AS isem ON isem.el_id=ic.el_id AND isem.icont_var='sem' ".
                " LEFT JOIN ?_ilines_content AS isem2 ON isem2.el_id=ic.el_id AND isem2.icont_var='sem2' ".
				" INNER JOIN ?_ilines_content AS y ON y.el_id=ic.el_id AND y.icont_var='date2' AND ".$ystr." ".
			"WHERE ".
				"(isem.icont_text='".(int)$semid."' OR isem2.icont_text='".(int)$semid."')".
                "{AND ie.itype_id = ?d }".
				"AND ie.el_id = ic.el_id ".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			"ORDER BY y.icont_text DESC ".
			"{LIMIT ?d, ".(int)$count."}",

			$tid === '*' ? DBSIMPLE_SKIP: $tid,
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
		   $ystr="y.icont_text LIKE '".(int)$year."%'";
   
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
				" INNER JOIN ?_ilines_content AS isem ON isem.el_id=ic.el_id AND isem.icont_var='sem' ".
                " LEFT JOIN ?_ilines_content AS isem2 ON isem2.el_id=ic.el_id AND isem2.icont_var='sem2' ".
				" INNER JOIN ?_ilines_content AS y ON y.el_id=ic.el_id AND y.icont_var='date2' AND ".$ystr." ".
			"WHERE ".
                "(isem.icont_text='".(int)$semid."' OR isem2.icont_text='".(int)$semid."')".
				"AND ie.el_id = ic.el_id ".
				"{AND ie.itype_id = ?d }".
				"{AND ic.icont_var  = ? ".
				"AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
			
			"{LIMIT 0, ".(int)$count."}",

            $tid === '*' ? DBSIMPLE_SKIP: $tid,
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
	//Исправлено  на количество getLimitedElementsBank
	function getLimitedElementsBankCount($tid, $count = 10, $page = 1, $sortField = "", $sortType = "", $statusField = "")
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
            $ssort.""
			,

			$tid,
			empty($statusField)? DBSIMPLE_SKIP: $statusField,
			/*empty($start)? DBSIMPLE_SKIP:*/ $start
		);

		

		return count($retVal);
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
		if (!empty($diss)) $wherediss=" ddiss.icont_text=".(int)$diss;
		
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
		    $wherediss= " IFNULL(ddiss.icont_text,'')=".(int)$diss;
	//	echo "!!!!!!!!!!".$wherediss." @" .$diss;
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
        if ($tid=="*") $where="(ie.itype_id = ?d OR ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id=6 )";
		else $where="ie.itype_id = ?d ";
		if ($tid=="**") $where="(ie.itype_id = ?d OR ie.itype_id=1 OR ie.itype_id=4 )";
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

    function getLimitedElementsMultiSortByDate($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$diss="", $datetime, $datetime_operation="<")
    {

        global $DB;
        $start = "";
        $wherediss=" 1 ";

        if (!empty($diss))
            $wherediss= " IFNULL(ddiss.icont_text,'')=".(int)$diss;
        //	echo "!!!!!!!!!!".$wherediss." @" .$diss;
        if(!empty($count))
            $start = (int)$page < 1? 0: ((int)$page - 1) * $count;

        $sColArray = split(',',$sortFields);
        $sTypArray = split(',',$sortTypes);
        if ($tid=="*") $where="(ie.itype_id = ?d OR ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id=6 )";
        else $where="ie.itype_id = ?d ";
        if ($tid=="**") $where="(ie.itype_id = ?d OR ie.itype_id=1 OR ie.itype_id=4 )";
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

        if(empty($datetime))
            $datetime = new DateTime();

        $retVal = $DB->select(
            "SELECT ".
            "ie.el_id AS ARRAY_KEY, ".
            " innerTable0.icont_text , ".
            "ie.*,it.itype_name,it.itype_name_en ".
            "FROM ".
            "?_ilines_content AS ic, ".
            "?_ilines_element AS ie ".
            "INNER JOIN ?_ilines_type AS it ON it.itype_id=ie.itype_id ".
            "LEFT OUTER JOIN ?_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date2' ".
            "LEFT OUTER JOIN ?_ilines_content AS mbo ON mbo.el_id=ie.el_id AND mbo.icont_var='main_block_out' ".
            "LEFT OUTER JOIN ?_ilines_content AS ddiss ON ddiss.el_id=ie.el_id AND ddiss.icont_var='sovet' ".
            $innerJoinStr.
            "WHERE ".
            " (mbo.icont_text IS NULL OR mbo.icont_text = 0) AND ".
            " STR_TO_DATE(dd.icont_text, '%Y.%m.%d') ".$datetime_operation." '". $datetime->format('Y.m.d')."' AND ".
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
	
	function getNewsOutOfMain($n_id)
	{
		global $DB;

		$cleanId = (int)$n_id;

		$retVal = $DB->select(
			"SELECT icont_text FROM adm_ilines_content WHERE el_id=".$cleanId." AND icont_var='main_block_out'");
		
		return $retVal[0][icont_text];
		
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
		
		$date = new DateTime();
		$interval = new DateInterval('P1D');
		$date->add($interval);
		
		$retVal = $DB->select(
			"SELECT ".
				"ie.el_id AS ARRAY_KEY, ".
				" innerTable0.icont_text , ".
				"ie.* ".
			"FROM ".
				"?_ilines_content AS ic, ".
				"?_ilines_element AS ie ".
            " LEFT OUTER JOIN ?_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date' ".
            " LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ".
			$innerJoinStr.
			$whereen.
			" WHERE ".
			    " IFNULL(dd.icont_text,'') <= '". $date->format('Y.m.d')."' AND ".
				"(ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id = ?d ) ".
				"AND ie.el_id = ic.el_id AND (nh.icont_text IS NULL OR nh.icont_text=0) ".
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

    function getLimitedElementsMultiSortMainNewFunc($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "", $rubricExcl="", $semExcl="")
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

        if(!empty($semExcl)) {
            $semWhere = " (s.icont_text IS NULL OR s.icont_text<>".$semExcl.") AND ";
        } else {
            $semWhere = "";
        }

        if(!empty($rubricExcl)) {
            $rubricWhere = $rubricExcl;
        } else {
            $rubricWhere = 439;
        }

        $date = "NOW()";

//        if($_GET[debug]==20) {
//            $date = "'2019-12-27 16:00'";
//        }


        $retVal = $DB->select(
            "SELECT ".
            "ie.el_id AS ARRAY_KEY, ".
            " innerTable0.icont_text , ".
            " DATE_FORMAT(dd.icont_text, '%d.%m.%Y') AS date_formated , ".
            " DATE_FORMAT(dd.icont_text, '%d/%m/%Y') AS date_formated_en , ".
            " url.icont_text AS url , ".
            " IF(DATE_FORMAT(dd2.icont_text, \"%Y.%m.%d\") < DATE_FORMAT(".$date.",\"%Y.%m.%d\"),lt.icont_text,IF(DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") < DATE_FORMAT(".$date.",\"%Y.%m.%d 16:00\"),tt.icont_text,lt.icont_text)) AS final_text , ".
            " IF(DATE_FORMAT(dd2.icont_text, \"%Y.%m.%d\") < DATE_FORMAT(".$date.",\"%Y.%m.%d\"),lte.icont_text,IF(DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") < DATE_FORMAT(".$date.",\"%Y.%m.%d 16:00\"),tte.icont_text,lte.icont_text)) AS final_text_en , ".
            "ie.* ".
            "FROM ".
            "?_ilines_content AS ic, ".
            "?_ilines_element AS ie ".
            " LEFT OUTER JOIN ?_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date' ".
            " LEFT OUTER JOIN ?_ilines_content AS dd2 ON dd2.el_id=ie.el_id AND dd2.icont_var='date2' ".
            " LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ".
            " LEFT OUTER JOIN adm_ilines_content AS mbo ON mbo.el_id=ie.el_id AND mbo.icont_var='main_block_out' ".
            " LEFT OUTER JOIN adm_ilines_content AS ti ON ti.el_id=ie.el_id AND ti.icont_var='time_important' ".
            " LEFT OUTER JOIN adm_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='rubric' ".
            " LEFT OUTER JOIN adm_ilines_content AS s ON s.el_id=ie.el_id AND s.icont_var='sem' ".
            " LEFT OUTER JOIN adm_ilines_content AS pt ON pt.el_id=ie.el_id AND pt.icont_var='prev_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS pte ON pte.el_id=ie.el_id AND pte.icont_var='prev_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS tt ON tt.el_id=ie.el_id AND tt.icont_var='today_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS tte ON tte.el_id=ie.el_id AND tte.icont_var='today_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS lt ON lt.el_id=ie.el_id AND lt.icont_var='last_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS lte ON lte.el_id=ie.el_id AND lte.icont_var='last_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS url ON url.el_id=ie.el_id AND url.icont_var='iline_url' ".
            $innerJoinStr.
            $whereen.
            " WHERE ".
            " IF(ti.icont_text=1,dd2.icont_text,DATE_FORMAT(dd2.icont_text, \"%Y.%m.%d 07:00\")) <= DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") AND ".
            " IF(ti.icont_text=1,dd.icont_text,DATE_FORMAT(dd.icont_text, \"%Y.%m.%d 07:00\")) <= DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") AND ".
            " r.icont_text<>".$rubricWhere." AND ".$semWhere.
            " (ie.itype_id=1 OR ie.itype_id=4 OR ie.itype_id=5 OR ie.itype_id = ?d ) ".
            "AND ie.el_id = ic.el_id AND (nh.icont_text IS NULL OR nh.icont_text=0) ".
            "AND (mbo.icont_text IS NULL OR mbo.icont_text=0) ".
            "{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".

            "GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
            $sortStr.
            "{LIMIT ?d, ".(int)$count."} ",

            $tid,
            $statusField,
            $start
        );

        if(!empty($retVal)) {
            $retVal = $this->appendContent($retVal);
        }

        foreach ($retVal as $k=>$v) {
            if(empty($v['final_text'])) {
                $retVal[$k]['final_text'] = $v["content"]["PREV_TEXT"];
            }
            if(empty($v['final_text_en'])) {
                $retVal[$k]['final_text_en'] = $v["content"]["PREV_TEXT_EN"];
            }
        }



        // применение сортировки к выбранных эл-там
        //if(!empty($sortField) && !empty($retVal) && !empty($retVal))
        //	$retVal = $this->sorting($retVal, $sortField, $sortType);

        return $retVal;
    }

    function getLimitedElementById($id) {
	    global $DB;

        $date = "NOW()";

        $retVal = $DB->selectRow(
            "SELECT ".
            "ie.el_id AS ARRAY_KEY, ".
            " DATE_FORMAT(dd.icont_text, '%d.%m.%Y') AS date_formated , ".
            " DATE_FORMAT(dd.icont_text, '%d/%m/%Y') AS date_formated_en , ".
            " url.icont_text AS url , ".
            " IF(DATE_FORMAT(dd2.icont_text, \"%Y.%m.%d\") < DATE_FORMAT(".$date.",\"%Y.%m.%d\"),lt.icont_text,IF(DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") < DATE_FORMAT(".$date.",\"%Y.%m.%d 16:00\"),tt.icont_text,lt.icont_text)) AS final_text , ".
            " IF(DATE_FORMAT(dd2.icont_text, \"%Y.%m.%d\") < DATE_FORMAT(".$date.",\"%Y.%m.%d\"),lte.icont_text,IF(DATE_FORMAT(".$date.",\"%Y.%m.%d %H:%i\") < DATE_FORMAT(".$date.",\"%Y.%m.%d 16:00\"),tte.icont_text,lte.icont_text)) AS final_text_en , ".
            "ie.* ".
            "FROM ".
            "adm_ilines_element AS ie ".
            " LEFT OUTER JOIN adm_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date' ".
            " LEFT OUTER JOIN adm_ilines_content AS dd2 ON dd2.el_id=ie.el_id AND dd2.icont_var='date2' ".
            " LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ".
            " LEFT OUTER JOIN adm_ilines_content AS mbo ON mbo.el_id=ie.el_id AND mbo.icont_var='main_block_out' ".
            " LEFT OUTER JOIN adm_ilines_content AS ti ON ti.el_id=ie.el_id AND ti.icont_var='time_important' ".
            " LEFT OUTER JOIN adm_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='rubric' ".
            " LEFT OUTER JOIN adm_ilines_content AS s ON s.el_id=ie.el_id AND s.icont_var='sem' ".
            " LEFT OUTER JOIN adm_ilines_content AS pt ON pt.el_id=ie.el_id AND pt.icont_var='prev_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS pte ON pte.el_id=ie.el_id AND pte.icont_var='prev_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS tt ON tt.el_id=ie.el_id AND tt.icont_var='today_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS tte ON tte.el_id=ie.el_id AND tte.icont_var='today_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS lt ON lt.el_id=ie.el_id AND lt.icont_var='last_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS lte ON lte.el_id=ie.el_id AND lte.icont_var='last_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS url ON url.el_id=ie.el_id AND url.icont_var='iline_url' ".
            " WHERE ".
            " ie.el_id = ?d",
            $id
        );

        return $retVal;
    }

    function getPublSmiById($id) {
        global $DB;

        $retVal = $DB->selectRow(
            "SELECT ".
            "ie.el_id AS ARRAY_KEY, ".
            " DATE_FORMAT(dd.icont_text, '%d.%m.%Y') AS date_formated , ".
            " DATE_FORMAT(dd.icont_text, '%d/%m/%Y') AS date_formated_en , ".
            " url.icont_text AS url , ".
            " pt.icont_text AS final_text , ".
            " pte.icont_text AS final_text_en , ".
            "ie.* ".
            "FROM ".
            "adm_ilines_element AS ie ".
            " LEFT OUTER JOIN adm_ilines_content AS dd ON dd.el_id=ie.el_id AND dd.icont_var='date' ".
            " LEFT OUTER JOIN adm_ilines_content AS dd2 ON dd2.el_id=ie.el_id AND dd2.icont_var='date2' ".
            " LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ".
            " LEFT OUTER JOIN adm_ilines_content AS mbo ON mbo.el_id=ie.el_id AND mbo.icont_var='main_block_out' ".
            " LEFT OUTER JOIN adm_ilines_content AS ti ON ti.el_id=ie.el_id AND ti.icont_var='time_important' ".
            " LEFT OUTER JOIN adm_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='rubric' ".
            " LEFT OUTER JOIN adm_ilines_content AS s ON s.el_id=ie.el_id AND s.icont_var='sem' ".
            " LEFT OUTER JOIN adm_ilines_content AS pt ON pt.el_id=ie.el_id AND pt.icont_var='prev_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS pte ON pte.el_id=ie.el_id AND pte.icont_var='prev_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS tt ON tt.el_id=ie.el_id AND tt.icont_var='today_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS tte ON tte.el_id=ie.el_id AND tte.icont_var='today_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS lt ON lt.el_id=ie.el_id AND lt.icont_var='last_text' ".
            " LEFT OUTER JOIN adm_ilines_content AS lte ON lte.el_id=ie.el_id AND lte.icont_var='last_text_en' ".
            " LEFT OUTER JOIN adm_ilines_content AS url ON url.el_id=ie.el_id AND url.icont_var='iline_url' ".
            " WHERE ".
            " ie.el_id = ?d",
            $id
        );

        return $retVal;
    }

// С учетом рубрики
function getLimitedElementsDateRub($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrub="", $nohome=false,$year="",$alfa="",$author="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = explode(',',$sortFields);
		$sTypArray = explode(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
		$specrub_sql="";
		if($specrub!="")
		{
			if($specrub==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else
				$specrub_sql="AND r.icont_text <> '".(int)$specrub."' AND r.icont_text IS NOT NULL ";
		}
		$nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ie.el_id AND nna.icont_var='nonewslist' ";
		$nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";
		if($nohome) {
			$nohome_sql = " LEFT OUTER JOIN ?_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ";
			$nohome_where = "AND (nh.icont_text IS NULL OR nh.icont_text=0) ";
		}
		else {
			$nohome_sql = "";
			$nohome_where = "";
		}

        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ie.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ie.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ie.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
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
			$nohome_sql.
            $nonewsall_sql.
            $year_sql.
            $alfa_sql.
            $author_sql.
			" WHERE ".
			    $whererubric. " AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$nohome_where.$nonewsall_where.$specrub_sql.$year_where.$alfa_where.$author_where.
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
	
	// С учетом рубрики без лимита
function getLimitedElementsDateRubNoLimit($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrub="",$year="",$alfa="",$author="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ie.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";

		$specrub_sql="";
		if($specrub!="")
		{
			if($specrub==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else
				$specrub_sql="AND r.icont_text = '".(int)$specrub."' AND r.icont_text IS NOT NULL ";
		}
        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ie.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ie.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ie.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
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
            $nonewsall_sql.
            $year_sql.
            $alfa_sql.
            $author_sql.
			" WHERE ".
			    $whererubric. " AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$nonewsall_where.$specrub_sql.$year_where.$alfa_where.$author_where.
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"",

			$tid,
			$statusField
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}	
	function getLimitedElementsDateRubEn($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrub="", $nohome=false,$year="",$alfa="", $author="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ie.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";
		$specrub_sql="";
		if($specrub!="")
		{
			if($specrub==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else
				$specrub_sql="AND r.icont_text <> '".(int)$specrub."' AND r.icont_text IS NOT NULL ";
		}
		if($nohome) {
			$nohome_sql = " LEFT OUTER JOIN ?_ilines_content AS nh ON nh.el_id=ie.el_id AND nh.icont_var='nohome' ";
			$nohome_where = "AND (nh.icont_text IS NULL OR nh.icont_text=0) ";
		}
		else {
			$nohome_sql = "";
			$nohome_where = "";
		}
        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ie.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ie.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ie.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
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
			" LEFT OUTER JOIN ?_ilines_content AS en ON en.el_id=ie.el_id AND en.icont_var='prev_text_en' ".
			$nohome_sql.
            $nonewsall_sql.
            $alfa_sql.
            $year_sql.
            $author_sql.
			" WHERE ".
			    $whererubric. " AND ".
			    "en.icont_text <> '' AND en.icont_text<>'<p>&nbsp;</p>' AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$nohome_where.$nonewsall_where.$specrub_sql.$alfa_where.$year_where.$author_where.
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
	
	// С учетом рубрики без лимита
function getLimitedElementsDateRubNoLimitEn($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrub="",$year="",$alfa="",$author="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
        $nonewsall_sql = " LEFT OUTER JOIN ?_ilines_content AS nna ON nna.el_id=ie.el_id AND nna.icont_var='nonewslist' ";
        $nonewsall_where = "AND (nna.icont_text IS NULL OR nna.icont_text=0) ";
		$specrub_sql="";
		if($specrub!="")
		{
			if($specrub==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else
				$specrub_sql="AND r.icont_text = '".(int)$specrub."' AND r.icont_text IS NOT NULL ";
		}
        if($year!="") {
            $year_sql = " LEFT OUTER JOIN ?_ilines_content AS yr ON yr.el_id=ie.el_id AND yr.icont_var='date' ";
            $year_where = "AND (SUBSTRING(yr.icont_text,1,4) = '".(int)$year."') ";
        }
        else {
            $year_sql = "";
            $year_where = "";
        }

        if($alfa!="") {
            $alfa=str_ireplace("select","",$alfa);
            $alfa=str_ireplace("union","",$alfa);
            $alfa=str_ireplace("sleep","",$alfa);
            $alfa=str_ireplace("drop","",$alfa);
            $alfa=str_ireplace("insert","",$alfa);
            $alfa=str_ireplace("update","",$alfa);
            if($alfa!='eng') {
                if ($_SESSION[lang] != "/en") {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE surname LIKE '" . $alfa . "%'");
                } else {
                    $spavtor0 = $DB->select("SELECT id FROM persons WHERE Autor_en LIKE '" . $alfa . "%'");
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "pep.icont_text LIKE '".$symbol."%' OR pep.icont_text LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $spavtor0 = $DB->select("SELECT id FROM persons WHERE " . $engAuthors);
            }
            $avt="";
            foreach($spavtor0 as $spavtor)
            {
                $avt.="pep.icont_text LIKE '".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."<br>%' OR pep.icont_text LIKE '%<br>".$spavtor[id]."' OR ";

            }
            if($alfa!='eng') {
                $avtorFindStr = "pep.icont_text LIKE '".$alfa."%' OR pep.icont_text LIKE '%<br>".$alfa."%'";
            } else {
                $avtorFindStr = $avtorStr;
            }
            $search_string = "( ".$avt."(( ".$avtorFindStr.") AND
                NOT pep.icont_text LIKE '%коллектив авторо%')
                )";
            $alfa_sql = " LEFT OUTER JOIN ?_ilines_content AS pep ON pep.el_id=ie.el_id AND pep.icont_var='people' ";
            $alfa_where = "AND (".$search_string.") ";
        }
        else {
            $alfa_sql = "";
            $alfa_where = "";
        }

        $author_sql = "";
        $author_where = "";

        if($author!="") {
            $authorId = (int)$author;

            if(!empty($authorId)) {
                $author_sql = " LEFT OUTER JOIN ?_ilines_content AS aut ON aut.el_id=ie.el_id AND aut.icont_var='people' ";
                $author_where = " AND (aut.icont_text LIKE '{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}<br>%' OR aut.icont_text LIKE '%<br>{$authorId}')";
            }
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
			" LEFT OUTER JOIN ?_ilines_content AS en ON en.el_id=ie.el_id AND en.icont_var='prev_text_en' ".
            $nonewsall_sql.
            $alfa_sql.
            $year_sql.
            $author_sql.
			" WHERE ".
			    $whererubric. " AND ".
			    "en.icont_text <> '' AND en.icont_text<>'<p>&nbsp;</p>' AND ".
				"ie.itype_id = ?d ".
				"AND ie.el_id = ic.el_id ".$nonewsall_where.$specrub_sql.$alfa_where.$year_where.$author_where.
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"",

			$tid,
			$statusField
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}	
	function getLimitedElementsDateRubSpecRub($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrubs = array())
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
		$specrub_sql="";
		if(!empty($specrubs))
		{
			if($specrubs[0]==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else {
                $specrub_sql .= "AND (";
                $first = true;
			    foreach ($specrubs as $specrub) {
			        if($first) {
			            $first = false;
                    } else {
                        $specrub_sql .= " OR ";
                    }
                    $specrub_sql .= "r.icont_text = '".(int)$specrub."'";
                }
                $specrub_sql .= ") AND r.icont_text IS NOT NULL ";
            }
		}
		$joinEn="";
		$whereEn="";
		if($_SESSION[lang]=="/en")
		{
			$joinEn = " LEFT OUTER JOIN ?_ilines_content AS en ON en.el_id=ie.el_id AND en.icont_var='prev_text_en' ";
			$whereEn="en.icont_text <> '' AND en.icont_text<>'<p>&nbsp;</p>' AND ";
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
			" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='specrubric_page' ".$joinEn.
			" WHERE ".
			    $whererubric. " AND ".$whereEn.
				"(ie.itype_id = 5 OR ie.itype_id = 3 OR ie.itype_id = 62) ".
				"AND ie.el_id = ic.el_id ".$specrub_sql.
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"{LIMIT ?d, ".(int)$count."} ",

			$statusField,
			$start
		);

		// применение сортировки к выбранных эл-там
		//if(!empty($sortField) && !empty($retVal) && !empty($retVal))
		//	$retVal = $this->sorting($retVal, $sortField, $sortType);

		return $retVal;
	}	
	
	// С учетом рубрики без лимита
function getLimitedElementsDateRubNoLimitSpecRub($tid, $count = 3, $page = 1, $sortFields, $sortTypes, $statusField = "",$rubric="", $specrub="")
	{

		global $DB;
		$start = "";
		if(!empty($count))
			$start = (int)$page < 1? 0: ((int)$page - 1) * $count;

		$sColArray = split(',',$sortFields);
		$sTypArray = split(',',$sortTypes);
          
		if (!empty($rubric)) $whererubric=" r.icont_text=".(int)$rubric;
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
		$specrub_sql="";
		if($specrub!="")
		{
			if($specrub==-1)
				$specrub_sql="AND r.icont_text <> '' AND r.icont_text IS NOT NULL ";
			else
				$specrub_sql="AND r.icont_text = '".(int)$specrub."' AND r.icont_text IS NOT NULL ";
		}
		$joinEn="";
		$whereEn="";
		if($_SESSION[lang]=="/en")
		{
			$joinEn = " LEFT OUTER JOIN ?_ilines_content AS en ON en.el_id=ie.el_id AND en.icont_var='prev_text_en' ";
			$whereEn="en.icont_text <> '' AND en.icont_text<>'<p>&nbsp;</p>' AND ";
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
			" LEFT OUTER JOIN ?_ilines_content AS r ON r.el_id=ie.el_id AND r.icont_var='specrubric_page' ".$joinEn.
			" WHERE ".
			    $whererubric. " AND ".$whereEn.
				"(ie.itype_id = 5 OR ie.itype_id = 3) ".
				"AND ie.el_id = ic.el_id ".$specrub_sql.
				"{AND  ic.icont_var  = ? AND ic.icont_text <> '' AND ic.icont_text IS NOT NULL}".
			"GROUP BY ie.el_id ".
//			"ORDER BY ie.el_date DESC ".
			$sortStr.
			"",

			$statusField
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
				"ie.itype_id = ".(int)$tid.
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
        $cleanId = (int)$id;

    	$rows=$DB->select("SELECT CONCAT('<a href=/index.php?page_id=',podr.page_id,'>',podr.page_name,'</a>') AS podr ".
    	          " FROM adm_pages AS podr ".
    	          " INNER JOIN adm_pages_content AS podrc ON podrc.page_id=podr.page_id AND substring(podrc.cv_name,1,6)='uslugi'".
    	          " WHERE podrc.cv_text=".$cleanId);

    	return $rows;
    }
// Список услуг для подразделения
    function getUslugaByPodr($id)
    {
    	global $DB;
        $cleanId = (int)$id;

    	$rows=$DB->select("SELECT CONCAT('<a href=/index.php?page_id=178&id=',c.el_id,'>',c.icont_text,'</a>') AS usl ".
    	          " FROM adm_pages_content AS p ".
    	          " INNER JOIN adm_ilines_content AS c ON c.el_id=p.cv_text AND c.icont_var='title'".
    	          " WHERE p.page_id=".$cleanId." AND substring(p.cv_name,1,6)='uslugi' ");

    	return $rows;
    }
    // Список лет для новостной ленты семинара
    function getSemYears($id)
    {
    	global $DB;
        $cleanId = (int)$id;

    	$rows=$DB->select("SELECT DISTINCT substring(c.icont_text,1,4) AS year FROM adm_ilines_content AS c
    	                   INNER JOIN adm_ilines_content AS dd ON dd.el_id=c.el_id AND dd.icont_var='sem'
                            LEFT JOIN adm_ilines_content AS dd2 ON dd2.el_id=c.el_id AND dd2.icont_var='sem2'
    	                   INNER JOIN adm_directories_content AS d ON d.el_id=dd.icont_text
                            LEFT JOIN adm_directories_content AS d2 ON d2.el_id=dd2.icont_text
    	                   WHERE  c.icont_var='date2' AND ((d.el_id=".$cleanId." AND substring(c.icont_text,1,4)<=". date('Y').") OR (d2.el_id=".$cleanId." AND substring(c.icont_text,1,4)<=". date('Y')."))" .
    	                  " ORDER BY substring(c.icont_text,1,4) DESC
    							 ");

    	return $rows;
    }
   // Объявление о семинаре
    function getNewSem($id)
    {
    	global $DB;
    	$cleanId = (int)$id;

    	$rows=$DB->select("SELECT ic.* FROM adm_ilines_content AS ic
    	                   INNER JOIN adm_ilines_content AS dd ON dd.el_id=ic.el_id AND dd.icont_var='sem'
    	                   LEFT JOIN adm_ilines_content AS dd2 ON dd2.el_id=ic.el_id AND dd2.icont_var='sem2'
    	                   INNER JOIN adm_ilines_content AS d ON d.el_id=ic.el_id AND d.icont_var='date2'
    	                   LEFT JOIN adm_ilines_content AS d2 ON d2.el_id=ic.el_id AND d2.icont_var='date2'
    	                   INNER JOIN adm_ilines_content AS s ON s.el_id=ic.el_id AND s.icont_var='status'
    	                   WHERE s.icont_text='1' AND ((dd.icont_text='".$cleanId."' AND d.icont_text>='". date('Y.m.d')."') OR (dd2.icont_text='".$cleanId."' AND d2.icont_text>='". date('Y.m.d')."')) ".
    	                  " ORDER BY d.icont_text ");
        $elements[0][el_id]=$v[el_id];
		foreach($rows as $v)
			$elements[$v["el_id"]]["content"][strtoupper($v["icont_var"])] = $v["icont_text"];

		return $elements;
    	
    }

    function echoFirstNews($number)
    {
		global $DB,$_CONFIG;
		if ($_SESSION[lang]!='/en')
		{
		$rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
		                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
						 FROM adm_ilines_content AS a
						 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
						 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
						 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
						 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
						 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
						 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
						 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
						 WHERE a.icont_var='title' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nh.icont_text IS NULL OR nh.icont_text=0)
		                 ORDER BY d.icont_text DESC LIMIT 2
		                ");
		/*
						else
		$rows=$DB->select("SELECT c.el_id,c.icont_text AS title,d.icont_text AS prev_text
		                  FROM adm_headers_content AS c
		                  INNER JOIN adm_headers_content AS s ON s.el_id=c.el_id AND s.icont_var='status_en' AND s.icont_text=1				  
		                  INNER JOIN adm_headers_content AS d ON d.el_id=c.el_id AND d.icont_var='text_en'
						  INNER JOIN adm_headers_element AS e ON e.el_id=c.el_id AND e.itype_id=3
						  WHERE c.icont_var='title_en' 
						  ORDER BY c.el_id DESC LIMIT 1
		                ");
		*/	
		$commentsCount = 0;
		$value=$rows[$number];
			if($commentsCount>0)
				echo '<p></p>';
			     if(isset($value["date"]))
			{
				preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $value["date"], $matches);
				$value["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
				$value["date"] = date("d.m.Y", $value["date"]);
			}			
		//echo "<div class='title red'>";
		       echo $value["date"]."<br /><b style='font-size:16px;'><a href=/index.php?page_id=502&id=".$value[id]."&ret=640>".$value['title']."</a></b>";
		//echo  "</div>";
		echo $value[prev_text];
		if (!empty($value[full_text]))
		    echo "<a href=/index.php?page_id=502&id=".$value[id]."&ret=640>подробнее...</a>";
		$commentsCount++;
		}
		else
		{
			$rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
		                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
						 FROM adm_ilines_content AS a
						 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
						 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
						 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
						 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text_en'
						 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text_en'
						 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
						 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
						 WHERE a.icont_var='title_en' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nh.icont_text IS NULL OR nh.icont_text=0)
		                 ORDER BY d.icont_text DESC LIMIT 2
		                ");
		$commentsCount = 0;
		$value=$rows[$number];
			if($commentsCount>0)
				echo '<p></p>';
			     if(isset($value["date"]))
			{
				preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $value["date"], $matches);
				$value["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
				$value["date"] = date("d.m.Y", $value["date"]);
			}			
		//echo "<div class='title red'>";
		       echo $value["date"]."<br /><b style='font-size:16px;'><a href=/en/index.php?page_id=502&id=".$value[id]."&ret=640>".$value['title']."</a></b>";
		//echo  "</div>";
		echo $value[prev_text];
		if (!empty($value[full_text]))
		    echo "<a href=/en/index.php?page_id=502&id=".$value[id]."&ret=640>more...</a>";
		$commentsCount++;
		}
    }

    function getVideos($type_id,$start,$count) {
	    global $DB;
        $query = "SELECT e.el_id AS ARRAY_KEY
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var='date'
				 WHERE s.icont_text=1 AND e.itype_id=?d
                 ORDER BY d.icont_text DESC LIMIT ?d,?d
                ";
        $videos = $DB->select($query,$type_id,$start,$count);
        return $videos;
    }

    function getCerNews($tidArray = array('1','15'),$limitStart = 0, $limit = 999999, $otdel = 424) {
	    global $DB;

        $query = "SELECT id FROM `persons` AS pers WHERE pers.otdel=?d OR pers.otdel2=?d OR pers.otdel3=?d";
        $result = $DB->select($query, $otdel, $otdel, $otdel);

        $people=" 1=1";

        $first = true;

        foreach($result as $row)
        {
            if($first) {
                $people = "(p.icont_text LIKE '" . $row[id] . "<br>%' OR p.icont_text LIKE '%<br>" . $row[id] . "<br>%' OR p.icont_text LIKE '%<br>" . $row[id] . "')";
                $first=false;
            }
            else {
                $people .= " OR (p.icont_text LIKE '" . $row[id] . "<br>%' OR p.icont_text LIKE '%<br>" . $row[id] . "<br>%' OR p.icont_text LIKE '%<br>" . $row[id] . "')";
            }
        }

        $elements = $DB->select("SELECT ac.el_id, IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date,f.icont_text AS full_text,pt.icont_text AS prev_text, d.icont_text AS date2, CASE WHEN DATEDIFF( d.icont_text, CURDATE( ) )>0 THEN pt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )<0 THEN lt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )=0 THEN tt.icont_text END AS last_text FROM adm_ilines_element AS ae
			INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id
			INNER JOIN adm_ilines_content AS s ON s.el_id=ae.el_id AND s.icont_var='status'
			LEFT OUTER JOIN adm_ilines_content AS otd ON otd.el_id=ae.el_id AND otd.icont_var='otdel'
			INNER JOIN adm_ilines_content AS p ON p.el_id=ae.el_id AND p.icont_var='people'
			INNER JOIN adm_ilines_content AS d ON d.el_id=ae.el_id AND d.icont_var='date2'
			INNER JOIN adm_ilines_content AS d0 ON d0.el_id=ae.el_id AND d0.icont_var='date'
			LEFT OUTER JOIN adm_ilines_content AS lt ON lt.el_id=ae.el_id AND lt.icont_var='last_text'
			LEFT OUTER JOIN adm_ilines_content AS tt ON tt.el_id=ae.el_id AND tt.icont_var='today_text'
			LEFT OUTER JOIN adm_ilines_content AS pt ON pt.el_id=ae.el_id AND pt.icont_var='prev_text'
			LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=ae.el_id AND f.icont_var='full_text'
 			WHERE s.icont_text=1 AND ae.itype_id IN (?a) AND (otd.icont_text=?d OR ".$people.")
 			GROUP BY el_id
 			ORDER BY d.icont_text DESC LIMIT ?d,?d", $tidArray, $otdel, $limitStart,$limit);

        return $elements;
    }

    function getNewsByTids($tidArray = array('1','15'),$limitStart = 0, $limit = 999999) {
	    global $DB;

	    $statusEl = "s";
	    if($_SESSION['lang']=="/en") {
	        $statusEl = "se";
        }

        $elements = $DB->select("
            SELECT 
               ac.el_id, 
               IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date,
               f.icont_text AS full_text,
               pt.icont_text AS prev_text, 
               fe.icont_text AS full_text_en,
               pte.icont_text AS prev_text_en, 
               d.icont_text AS date2, 
               CASE WHEN DATEDIFF( d.icont_text, CURDATE( ) )>0 THEN pt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )<0 THEN lt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )=0 THEN tt.icont_text END AS last_text,
               CASE WHEN DATEDIFF( d.icont_text, CURDATE( ) )>0 THEN pte.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )<0 THEN lte.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )=0 THEN tte.icont_text END AS last_text_en
            FROM adm_ilines_element AS ae
			INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id
			INNER JOIN adm_ilines_content AS s ON s.el_id=ae.el_id AND s.icont_var='status'
            LEFT OUTER JOIN adm_ilines_content AS se ON se.el_id=ae.el_id AND se.icont_var='status_en'
			LEFT OUTER JOIN adm_ilines_content AS otd ON otd.el_id=ae.el_id AND otd.icont_var='otdel'
			INNER JOIN adm_ilines_content AS p ON p.el_id=ae.el_id AND p.icont_var='people'
			INNER JOIN adm_ilines_content AS d ON d.el_id=ae.el_id AND d.icont_var='date2'
			INNER JOIN adm_ilines_content AS d0 ON d0.el_id=ae.el_id AND d0.icont_var='date'
			LEFT OUTER JOIN adm_ilines_content AS lt ON lt.el_id=ae.el_id AND lt.icont_var='last_text'
			LEFT OUTER JOIN adm_ilines_content AS tt ON tt.el_id=ae.el_id AND tt.icont_var='today_text'
			LEFT OUTER JOIN adm_ilines_content AS pt ON pt.el_id=ae.el_id AND pt.icont_var='prev_text'
			LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=ae.el_id AND f.icont_var='full_text'
            LEFT OUTER JOIN adm_ilines_content AS lte ON lte.el_id=ae.el_id AND lte.icont_var='last_text_en'
			LEFT OUTER JOIN adm_ilines_content AS tte ON tte.el_id=ae.el_id AND tte.icont_var='today_text_en'
			LEFT OUTER JOIN adm_ilines_content AS pte ON pte.el_id=ae.el_id AND pte.icont_var='prev_text_en'
			LEFT OUTER JOIN adm_ilines_content AS fe ON fe.el_id=ae.el_id AND fe.icont_var='full_text_en'
 			WHERE {$statusEl}.icont_text=1 AND ae.itype_id IN (?a)
 			GROUP BY el_id
 			ORDER BY d.icont_text DESC LIMIT ?d,?d", $tidArray, $limitStart,$limit);

        return $elements;
    }
}

?>