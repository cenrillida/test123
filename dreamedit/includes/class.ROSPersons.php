<?
class ROSPersons
{

    var $childNodesName;

	function __construct($childNodesName = "childNodes")
        {
	    $this->childNodesName = $childNodesName;
	}

        function Persons($childNodesName = "childNodes")
	{
            $this->__construct($childNodesName);
	}

	// ¬ыбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPersonById($id,$name)
	{
	    global $DB, $_CONFIG;

	    $rows =  $DB->select(
	   				     "SELECT CONCAT(a.surname,' ',a.name,' ',a.fname) AS fio,a.Autor_en,a.ForSite,
	   				         a.status
                          FROM persons AS a

                          WHERE a.id=".$id
                          );

            return $rows;
     }


//ѕолные сведени€
function getPersonFullById($id,$name)
	{
	    global $DB, $_CONFIG;

	    $rows =  $DB->select(
	   				     "SELECT CONCAT(a.surname,' ',a.name) AS fio".$name.",
                             d0.name AS academ".$name.",
                             d1.name AS degree".$name.",
                             d2.name AS rank".$name.",
                             d3.name AS post".$name.",
                             a.member_card,a.id,
                             a.post,a.work,
                             a.error,
                             a.regional_branch AS region_id,
                             r.name AS region,
                             CONCAT('<a href=mailto:',a.email,'>',a.email,'</a>',' | ', a.work_phone) AS contact,
                             rr.icont_text AS regional_branch,
                             dd.name AS ros_post

                          FROM members AS a
                              LEFT JOIN members_academ AS d0 ON d0.id=a.academ
                              LEFT JOIN members_degree AS d1 ON d1.id=a.degree
                              LEFT JOIN members_rank AS d2 ON d2.id=a.rank
                              LEFT JOIN members_post AS d3 ON d3.id=a.post
                              LEFT OUTER JOIN members_post AS dd ON dd.id=a.ros_post
                              LEFT OUTER JOIN members_region AS r ON r.id=a.region
                              LEFT OUTER JOIN adm_tenders_content AS rr ON rr.el_id=a.regional_branch AND rr.icont_var='title'

                          WHERE a.id=".$id
                          );

            return $rows;
     }

   function getPersonsAll($bukva)
	{
	    global $DB, $_CONFIG;
        if ($bukva=="*") $where=" WHERE 1 ";
        else
            if ($bukva!="AZ")
                $where =" WHERE substring(a.surname,1,1)='".$bukva."'";
            else
                $where =" WHERE substring(a.surname,1,1)>='A' AND substring(a.surname,1,1)<='Z'";

	    $rows =  $DB->select(
	   				     "SELECT a.id AS id,
	   				        IF (status=1,
	   				        CONCAT(a.surname,' ',a.name,' ',a.fname),
	   				        CONCAT('*',a.surname,' ',a.name,' ',a.fname))
	   				         AS fullname,
	   				         IF (status=1,
	   				        CONCAT(substring(a.name,1,1),'.',substring(a.fname,1,1),'. ',a.surname),
	   				        CONCAT('*',substring(a.name,1,1),'.',substring(a.fname,1,1),'. ',a.surname))
	   				         AS shortname,
	   				         a.mail1 AS contact,
	   				         a.Autor_en,
	   				         a.ForSite,
	   				         a.status

                          FROM persons AS a ".

                          $where.
                         " ORDER BY a.surname,a.name,a.fname

                         ");

      return $rows;
     }
////////////
     function getPersonsByFio($surname,$name,$fname)
     {
        global $DB, $_CONFIG;
	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT p.id, p.surname,p.name,p.fname, CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',' | ', tel1) AS contact,
	    d.text AS dolj, chlen, s.short AS us, z.short AS uz  FROM persona AS p
            LEFT OUTER JOIN doljn AS d ON d.id=p.dolj
	    LEFT OUTER JOIN stepen AS s ON s.id=p.us
	    LEFT OUTER JOIN zvanie AS z ON z.id=p.uz

             WHERE
	     surname = '".$surname."' and name = '".$name."' and fname = '".$fname."'"
	 );
//	for($i=0; $i< count($rows);$i++)
//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}

       return $rows;


    }

// основные сведени€ о персоне
     function getPersonsById($id)
     {
        global $DB, $_CONFIG;
	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT p.id,
	    CONCAT(p.surname,' ',p.name,' ',p.fname) AS fullname,
	    CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fioshort,
	    p.rewards,p.about,p.ruk,p.usp,podr.invis, CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',' | ', tel1) AS contact,
	    d.text AS dolj, chlen, s.full AS us, z.full AS uz, p.otdel,
	    o.page_id AS otdelid,p.picsmall,p.picbig
	    FROM persona AS p
            LEFT OUTER JOIN doljn AS d ON d.id=p.dolj
	    LEFT OUTER JOIN stepen AS s ON s.id=p.us
	    LEFT OUTER JOIN zvanie AS z ON z.id=p.uz
	    LEFT OUTER JOIN podr ON podr.name=p.otdel
	    INNER JOIN adm_pages AS o ON o.page_name=p.otdel
             WHERE p.id=".$id

	 );
//	for($i=0; $i< count($rows);$i++)
//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}

       return $rows;


    }





     function getAvtorById($id)
     {
        global $DB, $_CONFIG;
//	include_once $_CONFIG["global"]["paths"]["template_path"]."/src/func.php";

	$rows =  $DB->select(
	    "SELECT persona.id,CONCAT(surname,' ',SUBSTRING(name,1,1),'.',SUBSTRING(fname,1,1),'.') AS fullname
             FROM persona

             WHERE
	     id = '".$id."'"
	 );
//	for($i=0; $i< count($rows);$i++)

//	{
//	    $rows[$i]["dolj"] = ltrim(spe_convert($rows[$i]["dolj"],"dolj.txt"));
//            $rows[$i]["us"] = substr(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),0,stripos(ltrim(spe_convert($rows[$i]["us"],"stepen.txt")),'|'));
//	    $rows[$i]["uz"] = substr(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),0,stripos(ltrim(spe_convert($rows[$i]["uz"],"u4.txt")),'|'));
//	}



       return $rows;


    }

}
?>
