<?
class Persons
{

    var $childNodesName;
	private $closedPositions = array(
		'100'
	);
	private $closedDivisions = array(
		'1240',
		'561'
	);

	function __construct($childNodesName = "childNodes")
	{
	    $this->childNodesName = $childNodesName;
	}

    	// Выбрать все персоны
	function getPersonsAll($alf=null)
	{
	    global $DB, $_CONFIG;

		$alf=$DB->cleanuserinput($alf);
		$alf = substr($alf,0,5);

        if (empty($alf)) $where = " WHERE 1";
        else $where = " WHERE substring(surname,1,1)='".$alf."'";
	    $rows =  $DB->select(
	    "SELECT persona.id, CONCAT(surname, ' ',  name,  ' ', fname) AS fullname, otd.page_name AS otdel,
	    CONCAT(tel1,' ', mail1) AS contact,
	    d.icont_text AS dolj, r.icont_text as chlen, s.icont_text AS us, z.icont_text AS uz, picsmall, picbig

	        FROM persons AS persona".
           " LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=persona.dolj AND d.icont_var='text'
           LEFT OUTER JOIN adm_pages AS otd ON otd.page_id=persona.otdel
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=persona.us AND s.icont_var='value'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=persona.uz AND z.icont_var='value'
	    LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=persona.ran AND r.icont_var='value' ".
	    $where.
	    " ORDER BY persona.surname, persona.name");


            return $rows;
     }
//Прочитать весь список персоналий на заданную букву или * - все
	function getFioAll($bukva)
	{
	
	$bukva=$DB->cleanuserinput($bukva);
		$bukva = substr($bukva,0,5);
	
		global $DB, $_CONFIG;
		if ($bukva=="*") $where = 1;
		else $where = "substring(surname,1,1)='".$bukva."'";


		if ($bukva=='en') $where="(substring(surname,1,1)>='A' AND substring(surname,1,1)<='Z')";

		$rows=$DB->select("SELECT id,IF(status=1,CONCAT(surname,' ',name,' ',fname),
		  CONCAT('*',surname,' ',name,' ',fname)) AS fio
		  FROM persons WHERE ".$where. " ORDER BY surname,name,fname");

		return $rows;
	}
	// Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPersonsByPodrId($podr_id)
	{
	
	 global $DB, $_CONFIG;
	$podr_id=(int)$podr_id;
	
	   
//	    include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";
	    $rows =  $DB->select(
	    "SELECT DISTINCT persons.id, CONCAT(surname, ' ',  name,  ' ', fname) AS fullname, otdel, otdel2, otdel3,
	    CONCAT(surname, ' ',  substring(name,1,1),  '. ', substring(fname,1,1),'.') AS shortname,
	    CONCAT(tel1,' ', mail1) AS contact,
	    d.icont_text AS dolj, d2.icont_text AS dolj2, d3.icont_text AS dolj3, ran.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz, picsmall, picbig  FROM persons
        LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=persons.dolj   AND d.icont_var='text'
        LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=persons.dolj2   AND d2.icont_var='text'
        LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=persons.dolj3   AND d3.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=persons.us    AND s.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=persons.uz  AND z.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS ran ON ran.el_id=persons.ran  AND ran.icont_var='text'

	     WHERE (otdel<>1240 AND otdel2<>1240 AND otdel3<>1240) AND full<>1 AND (otdel IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
		OR otdel2 IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
		OR otdel3 IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
	    OR persons.id IN
         (
         SELECT cv_text  FROM
	      (
	       SELECT cv_text FROM `adm_pages` AS p
	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
	        WHERE p.page_id = ".$podr_id."
	       UNION
	        SELECT cv_text FROM `adm_pages` AS p
	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
            WHERE p.page_parent = ".$podr_id."
	       UNION
	        SELECT cv_name FROM adm_pages AS p
  	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
      	    WHERE p.page_parent
	        IN (SELECT cv_name FROM `adm_pages` AS p
  	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
	           WHERE p.page_parent = ".$podr_id.")
	       )
	       AS allpodr2
	    ))

   	    ORDER BY persons.surname, persons.name");

//            for($i=0; $i< count($rows);$i++)
// 	    {
//	        $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//		$rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	        $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	    }

            return $rows;
     }
// English Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"

	function getPersonsByPodrIdEn($podr_id)
	{
	
	 global $DB, $_CONFIG;
	$podr_id=(int)$podr_id;

	    $rows =  $DB->select(
	    "SELECT DISTINCT persons.id, Autor_en AS fullname, otdel, otdel2, otdel3,
	    Autor_en AS shortname,
	    CONCAT(tel1,' ', mail1) AS contact,
	    d.icont_text AS dolj, d2.icont_text AS dolj2, d3.icont_text AS dolj3, ran.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz, picsmall, picbig  FROM persons
        LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=persons.dolj   AND d.icont_var='text_en'
        LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=persons.dolj2   AND d2.icont_var='text_en'
        LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=persons.dolj3   AND d3.icont_var='text_en'
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=persons.us    AND s.icont_var='text_en'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=persons.uz  AND z.icont_var='text_en'
	    LEFT OUTER JOIN adm_directories_content AS ran ON ran.el_id=persons.ran  AND ran.icont_var='text_en'

	     WHERE (otdel<>1240 AND otdel2<>1240 AND otdel3<>1240) AND full<>1 AND (Autor_en<>'' AND otdel IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
		OR Autor_en<>'' AND otdel2 IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
		OR Autor_en<>'' AND otdel3 IN
	    (
	    SELECT allpodr.page_id FROM
	     (
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_id = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id."
	      UNION
	      SELECT adm_pages.page_id,adm_pages.page_name_en FROM adm_pages WHERE adm_pages.page_parent
	      IN (SELECT adm_pages.page_id FROM `adm_pages` WHERE adm_pages.page_parent = ".$podr_id.")
	      )
	      AS allpodr
	    )
	    OR persons.id IN
         (
         SELECT cv_text  FROM
	      (
	       SELECT cv_text FROM `adm_pages` AS p
	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
	        WHERE p.page_id = ".$podr_id."
	       UNION
	        SELECT cv_text FROM `adm_pages` AS p
	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
            WHERE p.page_parent = ".$podr_id."
	       UNION
	        SELECT cv_name FROM adm_pages AS p
  	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
      	    WHERE p.page_parent
	        IN (SELECT cv_name FROM `adm_pages` AS p
  	        INNER JOIN adm_pages_content AS c ON c.page_id=p.page_id AND cv_name='chif'
	           WHERE p.page_parent = ".$podr_id.")
	       )
	       AS allpodr2
	    ))

   	    ORDER BY persons.Autor_en");



            return $rows;
     }
////////////
     function getPersonsByFio($surname,$name,$fname)
     {
        global $DB, $_CONFIG;
	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$surname=$DB->cleanuserinput($surname);
	$name=$DB->cleanuserinput($name);
	$fname=$DB->cleanuserinput($fname);
	
	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname,
	    CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',' , ', tel1) AS contact,
	    d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz  
		FROM persons AS p
        LEFT OUTER JOIN adm_directories_content AS d ON d.id=p.dolj    AND d.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us      AND d.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz    AND d.icont_var='text'
        LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran    AND r.icont_var='text'
        WHERE
	     surname = ? and name = ? and fname = ?",$surname,$name,$fname
	 );
//	for($i=0; $i< count($rows);$i++)
//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}

       return $rows;


    }
      function getPersonsRegaliiById($id)
     {
        global $DB, $_CONFIG;

		$id=(int)$id;

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname,
	    CONCAT(IF(tel1<>'' AND tel1<>'0',tel1,''),IF(mail1<>'' AND tel1<>'' AND tel1<>'0' ,' | ',''),'<a href=mailto:',mail1,'>',mail1,'</a>') AS contact,
	    d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz  FROM persons AS p
            INNER JOIN adm_directories_content AS d ON d.el_id=p.dolj  AND d.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us   AND s.icont_var='text'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz AND z.icont_var='text'
        LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran AND r.icont_var='text'
             WHERE p.id='".$id."'"

	 );

       return $rows;
    }
	 //Сведения о персоне на английском
	 function getPersonsRegaliiByIdEn($id)
     {
        global $DB, $_CONFIG;

		 $id=(int)$id;

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname,p.Autor_en,
	    CONCAT(IF(tel1<>'' AND tel1<>'0',tel1,''),IF(mail1<>'' AND tel1<>'' AND tel1<>'0' ,' | ',''),'<a href=mailto:',mail1,'>',mail1,'</a>') AS contact,
	    d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz  FROM persons AS p
            LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj  AND d.icont_var='text_en'
	    LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us   AND s.icont_var='text_en'
	    LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz AND z.icont_var='text_en'
        LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran AND r.icont_var='text_en'
             WHERE p.id='".$id."'"

	 );

       return $rows;
    }
      function getPersonsRegaliiByCenterId($id,$param)
     {
        global $DB, $_CONFIG;

		 $id=(int)$id;
		$param=$DB->cleanuserinput($param);

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname,
	    CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF(tel1<>'' AND tel1<>'0',CONCAT(' | ', tel1),'')) AS contact,
			    CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),
			    IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0,
 	    d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz  FROM adm_pages_content AS pg ".
        " INNER JOIN persons AS p ON p.id =pg.cv_text " .
        " LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj AND d.icont_var='text' ".
	    " LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='text' ".
	    " LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='text' ".
	    " LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='text' ".
        " WHERE pg.page_id='".$id."' AND cv_name='".$param."'"

	 );
     return $rows;
    }
	//На английском
	function getPersonsRegaliiByCenterIdEn($id,$param)
     {
        global $DB, $_CONFIG;

		 $id=(int)$id;
		$param=$DB->cleanuserinput($param);

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname,Autor_en,
	    CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF(tel1<>'' AND tel1<>'0',CONCAT(' | ', tel1),'')) AS contact,
			    CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),
			    IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0,
 	    d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz  FROM adm_pages_content AS pg ".
        " INNER JOIN persons AS p ON p.id =pg.cv_text " .
        " LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj AND d.icont_var='text_en' ".
	    " LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='text_en' ".
	    " LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='text_en' ".
	    " LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='text_en' ".
        " WHERE pg.page_id='".$id."' AND cv_name='".$param."'"

	 );
     return $rows;
    }
     function getPersonsById($id)
	     {
	        global $DB, $_CONFIG;

			 $id=(int)$id;
		
		
		$rows =  $DB->select(
		    "SELECT id,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fullname,
						d1.icont_text AS us,
			           d2.icont_text AS 'uz',d3.icont_text AS ran,
		               CONCAT(p.surname,' ',substring(p.name,1,1),'.',IF (p.fname<>'',CONCAT(substring(p.fname,1,1),'.'),'')) AS fioshort,
		               ForSite AS about,status,mail1,full,orcid,otdel,otdel2,otdel3,dolj,dolj2,dolj3,is_closed, p.full_name_echo, CONCAT(p.name,' ',p.surname) AS name_surname
		               FROM persons AS p 
		               LEFT OUTER JOIN adm_directories_content AS d1 ON d1.el_id=p.us AND d1.icont_var='value' 
					   LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=p.uz AND d2.icont_var='value' 
					   LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=p.ran AND d3.icont_var='value' 
	             WHERE p.id='".$id."'"
		 );

	       return $rows;
	  }
      function getPersonsByIdEn($id)
	     {
	        global $DB, $_CONFIG;

			 $id=(int)$id;
		
		
		$rows =  $DB->select(
		    "SELECT id,Autor_en AS fio,Autor_en AS fullname,d1.icont_text AS us,
			           d2.icont_text AS 'uz',
		               Autor_en AS fioshort,d3.icont_text AS ran,
		               ForSite_en AS about,status,mail1,full,orcid,otdel,otdel2,otdel3,dolj,dolj2,dolj3, Name_EN, LastName_EN, p.full_name_echo, CONCAT(p.Name_EN,' ',p.LastName_EN) AS name_surname
		               FROM persons AS p 
					   LEFT OUTER JOIN adm_directories_content AS d1 ON d1.el_id=p.us AND d1.icont_var='value_en' 
					   LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=p.uz AND d2.icont_var='value_en' 
					   LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=p.ran AND d3.icont_var='value_en' 
	             WHERE p.id='".$id."'"
		 );

	       return $rows;
	  }
// Вся информация о персоне
	function getPersonsByIdFull($id)
		     {
		        global $DB, $_CONFIG;

				 $id=(int)$id;
            if ($_SESSION[lang]!='/en')
			{
			$rows =  $DB->select(
			    "SELECT p.*,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,Autor_en AS fio_en, Name_EN AS f_name_en, LastName_EN AS f_lastname_en,
			              CONCAT(p.surname,' ',substring(p.name,1,1),'.',IF(p.fname<>'',CONCAT(substring(p.fname,1,1),'.'),'')) AS fioshort,
			    CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),
			    IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0, p.otdel as otdel_id,
			    ForSite_en,
                       d.icont_text AS dolj,d2.icont_text AS dolj2,d3.icont_text AS dolj3,
			              IF (o.page_status<>0,CONCAT('<a href=/index.php?page_id=',o.page_id,'>',o.page_name,'</a>'),'') AS otdel,
						  IF (o2.page_status<>0,CONCAT('<a href=/index.php?page_id=',o2.page_id,'>',o2.page_name,'</a>'),'') AS otdel2,
						  IF (o3.page_status<>0,CONCAT('<a href=/index.php?page_id=',o3.page_id,'>',o3.page_name,'</a>'),'') AS otdel3,
			              CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF(tel1<>'' AND tel1<>'0',CONCAT(' | ', tel1),'')) AS contact,
			              status,about,about_en,picbig,full,p.surname
			            FROM persons AS p
			            LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us AND s.icont_var='value'
			            LEFT OUTER JOIN adm_directories_content  AS z ON z.el_id=p.uz AND z.icont_var='value'
			            LEFT OUTER JOIN adm_directories_content  AS r ON r.el_id=p.ran AND r.icont_var='value'
			            LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj AND d.icont_var='text'
						LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=p.dolj2 AND d2.icont_var='text'
						LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=p.dolj3 AND d3.icont_var='text'
			            LEFT OUTER JOIN adm_pages AS o ON o.page_id=p.otdel
						LEFT OUTER JOIN adm_pages AS o2 ON o2.page_id=p.otdel2
						LEFT OUTER JOIN adm_pages AS o3 ON o3.page_id=p.otdel3
		             WHERE p.id='".$id."'"
			 );
             }
			 else
			 {
			 $rows =  $DB->select(
			    "SELECT p.*,Autor_en AS fio,Autor_en AS fio_en,
			              Autor_en AS fioshort, Name_EN AS f_name_en, LastName_EN AS f_lastname_en,
			    CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),
			    IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0,
			    ForSite_en,
                       d.icont_text AS dolj,d2.icont_text AS dolj2,d3.icont_text AS dolj3,
			              IF (o.page_status<>0,CONCAT('<a href=/en/index.php?page_id=',o.page_id,'>',o.page_name_en,'</a>'),'') AS otdel,
						  IF (o2.page_status<>0,CONCAT('<a href=/en/index.php?page_id=',o2.page_id,'>',o2.page_name_en,'</a>'),'') AS otdel2,
						  IF (o3.page_status<>0,CONCAT('<a href=/en/index.php?page_id=',o3.page_id,'>',o3.page_name_en,'</a>'),'') AS otdel3,
			              CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF(tel1<>'' AND tel1<>'0',CONCAT(' | ', tel1),'')) AS contact,
			              status,about_en AS about,picbig
			            FROM persons AS p
			            LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us AND s.icont_var='value_en'
			            LEFT OUTER JOIN adm_directories_content  AS z ON z.el_id=p.uz AND z.icont_var='value_en'
			            LEFT OUTER JOIN adm_directories_content  AS r ON r.el_id=p.ran AND r.icont_var='value_en'
			            LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj AND d.icont_var='text_en'
						LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=p.dolj2 AND d2.icont_var='text_en'
						LEFT OUTER JOIN adm_directories_content AS d3 ON d3.el_id=p.dolj3 AND d3.icont_var='text_en'
			            LEFT OUTER JOIN adm_pages AS o ON o.page_id=p.otdel
						LEFT OUTER JOIN adm_pages AS o2 ON o2.page_id=p.otdel2
						LEFT OUTER JOIN adm_pages AS o3 ON o3.page_id=p.otdel3
		             WHERE p.id='".$id."'"
			 );
			 }
		       return $rows;
		  }


     function getAvtorById($id)
     {
        global $DB, $_CONFIG;
//	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

		 $id=(int)$id;

    if(!isset($_REQUEST[en]))
	$rows =  $DB->select(
	    "SELECT persons.id,CONCAT(surname,' ',SUBSTRING(name,1,1),'.',SUBSTRING(fname,1,1),'.') AS fullname, Autor_en, otdel, otdel2, otdel3, dolj, dolj2, dolj3,
	         CONCAT(surname,', ',name,' ',fname) AS fullname_bib, CONCAT(surname,', ',SUBSTRING(name,1,1),'.',SUBSTRING(fname,1,1),'.') AS fullname_cit
             FROM persons

             WHERE
	     id = '".$id."'"
	 );
	else
	$rows =  $DB->select(
	    "SELECT persons.id,Autor_en AS fullname,Autor_en AS fullname_bib, otdel, otdel2, otdel3, dolj, dolj2, dolj3
             FROM persons

             WHERE
	     id = '".$id."'"
	 );

      return $rows;


    }

	public function searchPerson($text) {
		global $DB;

		$persons = $DB->select("
		SELECT * FROM persons
		WHERE surname = ? OR 
		      name = ? OR 
		      fname = ? OR 
		      Name_EN = ? OR 
		      LastName_EN = ? OR 
		      Autor_en = ? OR
		      CONCAT(surname, ' ', name) = ? OR 
		      CONCAT(name, ' ', surname) = ? OR 
			  CONCAT(LastName_EN, ' ', Name_EN) = ? OR 
		      CONCAT(Name_EN, ' ', LastName_EN) = ? OR 
		      CONCAT(name, ' ', fname, ' ', surname) = ? OR 
		      CONCAT(surname, ' ', name, ' ', fname) = ? OR 
		      CONCAT(surname, ' ', SUBSTR(name, 1, 1),'.') = ? OR 
		      CONCAT(surname, ' ', SUBSTR(name, 1, 1),'. ',SUBSTR(fname, 1, 1),'.') = ? OR 
		      CONCAT(surname, ' ', SUBSTR(name, 1, 1),'.',SUBSTR(fname, 1, 1),'.') = ?
		", $text, $text, $text, $text, $text, $text, $text, $text, $text, $text, $text, $text, $text, $text, $text);

		return $persons;
	}

	public function extractDivisions($row) {
		$divisions = array();
		$divisions[] = $row['otdel'];
		$divisions[] = $row['otdel2'];
		$divisions[] = $row['otdel3'];
		return $divisions;
	}

	public function extractPositions($row) {
		$positions = array();
		$positions[] = $row['dolj'];
		$positions[] = $row['dolj2'];
		$positions[] = $row['dolj3'];
		return $positions;
	}

	public function isClosed($row) {

		if($row['is_closed'] == 1) {
			return true;
		}

		$divisions = $this->extractDivisions($row);
		$positions = $this->extractPositions($row);

		foreach ($positions as $position) {
			if(in_array($position,$this->closedPositions)) return true;
		}

		foreach ($divisions as $division) {
			if(in_array($division,$this->closedDivisions)) return true;
		}

		return false;
	}

}
?>
