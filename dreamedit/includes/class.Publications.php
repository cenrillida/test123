<?
class Publications
{

    var $childNodesName;
    /**
     * @var array
     */
    private $selectConditions = array();
    /**
     * @var array
     */
    private $selectParameters = array();
    /**
     * @var array
     */
    private $conditions = array();
    /**
     * @var array
     */
    private $parameters = array();
    /**
     * @var array
     */
    private $magazineConditions = array();
    /**
     * @var array
     */
    private $magazineParameters = array();
    /**
     * @var array
     */
    private $afjournConditions = array();
    /**
     * @var array
     */
    private $afjournParameters = array();
    /**
     * @var string
     */
    private $order = "";
    /**
     * @var string
     */
    private $langSql;
    /**
     * @var string
     */
    private $langPref;
    /**
     * @var string
     */
    private $langPrefPubl;
    /**
     * @var bool
     */
    private $withAfjourn = false;


	function __construct($childNodesName = "childNodes")
    {
	    $this->childNodesName = $childNodesName;

        $this->langSql = "IF(substring(z.name,1,1)<>'«',INTERVAL(191,ASCII(z.name)),
          INTERVAL(191,ASCII(substring(z.name,2))))";
        $this->langPref="";
        $this->langPrefPubl = "";
        if($_SESSION["lang"]=="/en") {
            $this->langPref = "_en";
            $this->langPrefPubl = "2";

            $this->langSql = "IF(substring(z.name2,1,1)<>'«',INTERVAL(191,ASCII(z.name2)),
          INTERVAL(191,ASCII(substring(z.name2,2))))";
        }
	}


	// Выбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPublicationsByContextSearch($context_search)
	{
	    global $DB, $_CONFIG;
	    $rows =  $DB->select(
	    "SELECT id, name, name2, vid, tip FROM `publ` WHERE name like '%".$context_search."%' OR name2 like '%".$context_search."%'");


            return $rows;
     }

	function getPublicationVidArray()
	{
 		global $DB,$_CONFIG;

           $fd=$DB->select("SELECT text FROM vid ORDER BY id");
	   foreach($fd as $i=>$fd0)
	     $qq[$i]=$fd0[text];

        return $qq;
	 }

// Получить название рубрики по Id
   function getRubricNameById($id)
   {
        global $DB,$_CONFIG;

        $cleanId = (int)$id;

        $rows=$DB->select("SELECT icont_text AS name FROM adm_directories_content WHERE el_id=".$cleanId." AND icont_var='text'");
        return $rows[0];

   }
//Получить список рубьрик в группе
function getRubricListByGroupId($id)
{
	global $DB;
	if (!empty($id))
	{
	$rows=$DB->select("SELECT el_id FROM adm_directories_content WHERE icont_text=".$id." AND icont_var='gruppa'");
	$sp="";
	foreach($rows as $row)
	   $sp.=" vid = ".$row[el_id]." OR ";
	if (!empty($sp)) $sp="(".substr($sp,0,-4).") AND ";
    }
    return $sp;
}

function getAuthorsList() {
    global $DB;

    $authorsRows = $DB->select("SELECT DISTINCT avtor
            FROM publ 
            WHERE avtor<>''");

    $authorsArray = array();

    foreach ($authorsRows as $authorsRow) {
        $authors = explode("<br>",trim($authorsRow['avtor']));
        foreach($authors as $k=>$author)
        {
            if (!empty($author))
            {
                if (is_numeric($author))
                {
                    if(!isset($authorsArray[$author])) {
                        $authorsArray[$author] = $author;
                    }
                }
            }
        }
    }

    $authorsFinalRows = $DB->select("SELECT p.id AS ARRAY_KEY, p.id AS id,
			 CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),IF(p.fname<>'','.','')) AS fio,
			 autor_en AS fio_en
			 FROM persons AS p WHERE p.id IN (?a) ORDER BY p.surname", $authorsArray);

    return $authorsFinalRows;
}

//Получить список авторов
   function getAuthors($spisok,$pers_page=555)
   {
     global $DB,$_CONFIG;
     if (empty($pers_page)) $pers_page=555;
     $cleanId = (int)$pers_page;
     $aa=explode("<br>",trim($spisok));
     $ret="";
     $retbib="";
     $persons = new Persons();
     foreach($aa as $a)
     {
     	if (!empty($a) && $a!='270')
     	{
            if (is_numeric($a))
            {
                $avt0=$DB->select("SELECT id,CONCAT(surname,' ',substring(name,1,1),'.',IF(substring(fname,1,1) IS NULL OR substring(fname,1,1)='', '',CONCAT(substring(fname,1,1), '.'))) AS fio,
                                CONCAT(surname,', ',name,' ',fname) AS fiobib,
                Autor_en, full_name_echo, otdel, otdel2, otdel3, dolj, dolj2, dolj3 FROM persons WHERE id=".$a);

                $isClosed = $persons->isClosed($avt0[0]);
                if($isClosed) {
                    if ($_SESSION[lang]!='/en' || empty($avt0[0][Autor_en]))
                    {
                        $ret.="<em>".$avt0[0][fio]."</em>, ";
                        $retbib.=$avt0[0][fiobib]." and ";
                    }
                    else
                    {
                        $ret.="<em>".$avt0[0][Autor_en]."</em>, ";
                        $retbib.=$avt0[0][Autor_en]." and ";
                    }
                } else {
                    if ($_SESSION[lang]!='/en' || empty($avt0[0][Autor_en]))
                    {
                        $ret.="<a href=/index.php?page_id=".$cleanId."&id=".$avt0[0][id].
                            " title='Об авторе подробнее' ><em>".$avt0[0][fio]."</em></a>, ";
                        $retbib.=$avt0[0][fiobib]." and ";
                    }
                    else
                    {
                        $ret.="<a href=/en/index.php?page_id=".$cleanId."&id=".$avt0[0][id].
                            " title='more...' ><em>".$avt0[0][Autor_en]."</em></a>, ";
                        $retbib.=$avt0[0][Autor_en]." and ";
                    }
                }
            } else {
               $aa=explode("|",$a);
               if (!isset($_REQUEST[en]))
               {
                   $ret.="<em>".trim($aa[0])."</em>, ";
                   $retbib.=trim($aa[0])." and ";
               }
               else
               {
                   $ret.="<em>".trim($aa[1])."</em>, ";
                   $retbib.=trim($aa[1])." and ";
               }
            }
        }
     }
     if (!empty($ret)) $ret=substr($ret,0,-2);
     if (!empty($retbib)) $retbib=substr($retbib,0,-5);
     $retar[0]=$ret;$retar[1]=$retbib;
     return $retar;
   }

    function getCrossrefAutorsEn($spisok)
    {
        global $DB;
        $str0=explode('<br>',trim($spisok));
        //       print_r($str0);
        $where='';
//		$fiosp=new Array();
        $i=0;
        foreach($str0 as $str)
        {
//			echo "<br />*".$str."*";
            if (!empty($str) && is_numeric($str)) {
                $where .= "id=" . $str . " OR ";
            }
            $fiosp[$str]['sort']=$i;
            $i++;

        }

        $where=substr($where,0,-4);

        if (!empty($where))
            $ff= $DB->select("SELECT p.id,Autor_en AS fio,Autor_en AS fioshort,ForSite_en AS work,mail1,
      				if(o.page_status=1,o.page_name,'')  AS otdel, p.name AS rusname, p.LastName_EN AS enlastname, p.Name_EN AS enfirstname, CONCAT(p.Name_EN,' ',p.LastName_EN) AS name_surname,d.icont_text AS grade,chl.icont_text AS ran,p.picsmall AS picsmall, p.full_name_echo, p.about 
			        FROM persons AS p
			        LEFT JOIN adm_pages AS o ON o.page_id = p.otdel
			        LEFT JOIN adm_directories_content AS d ON d.el_id = p.us AND d.icont_var='text_en'
			        LEFT JOIN adm_directories_content AS chl ON chl.el_id = p.ran AND chl.icont_var='text_en'
			        WHERE ".$where);

        foreach($ff as $f)
        {
            $fiosp[$f[id]][id]=$f[id];
            $fiosp[$f[id]][fio]=$f[fio];
            $fiosp[$f[id]][about]=$f[about];
            $fiosp[$f[id]][rusname]=$f[rusname];
            $fiosp[$f[id]][enlastname]=$f[enlastname];
            $fiosp[$f[id]][enfirstname]=$f[enfirstname];
            $fiosp[$f[id]][fioshort]=$f[fioshort];
            $fiosp[$f[id]][work]=$f[work];
            $fiosp[$f[id]][mail1]=$f[mail1];
            $fiosp[$f[id]][otdel]=$f[otdel];
            $fiosp[$f[id]][grade]=$f[grade];
            $fiosp[$f[id]][ran]=$f[ran];
            $fiosp[$f[id]][name_surname]=$f[name_surname];
            $fiosp[$f[id]][picsmall]=$f[picsmall];
            $fiosp[$f[id]][full_name_echo]=$f[full_name_echo];
        }

//       print_r($fiosp);
        return $fiosp;
    }

// Похожие публикации
   function RelatedPublications($publid,$count)
   {
     global $DB,$_CONFIG;

     $cleanId = (int)$publid;
     $cleanCount = (int)$count;
    //Найти похожие

       $publ0 = array();

	if (!empty($cleanId))
	{
        $source=$DB->selectRow("SELECT name,name2,annots,keyword,vid,vid_inion
        FROM publ WHERE id=".$cleanId);
        if(!empty($source)) {

            $kw0 = explode(";", trim($source[keyword]));
            $search_kw = "";
            $search_string = "";
            $pole = "";
            $order = "";
            $i = 0;

            $rname = array("2", "2d", "2_3", "2_4", "2_5");
            foreach ($kw0 as $kw) {
                if (!empty($kw)) {

                    $pole .= " MATCH (`name`,`annots`,`keyword`) AGAINST ('" . $kw . "') AS relevant" . $i . ", ";
                    $search_kw .= " ((MATCH (`name`,`annots`,`keyword`) AGAINST ('" . $kw . "') >0.5) OR  " .
                        " name LIKE '%" . $kw . "%' OR " .
                        " annots LIKE '%" . $kw . "%' OR " .
                        " keyword LIKE '%" . $kw . "%') " .
                        " OR ";
                    $pole .= " IF (name LIKE '%" . $kw . "%',0,0) AS relevantn" . $i . ", ";
                    $pole .= " IF (annots LIKE '%" . $kw . "%',0,0) AS relevanta" . $i . ", ";
                    $pole .= " IF (keyword LIKE '%" . $kw . "%',0,0) AS relevantk" . $i . ", ";
                    $order .= "relevant" . $i . "+relevantn" . $i . "+relevanta" . $i . "+relevantk" . $i . "+";
                    $i++;
                }
            }
            $order .= "relevant_vid+";
            $pole .= " IF (vid='" . $source[vid] . "',1,0) AS relevant_vid, ";
            $search_string .= " id<>" . $cleanId . " ";

            $summa = "((" . substr($order, 0, -1) . ") >0)";
            $order = "(" . substr($order, 0, -1) . " )DESC ";

            $publ0 = $DB->select("SELECT DISTINCT id," . $pole . "name,name2,avtor,year,`hide_autor` AS avthide,
            IF(substring(name,1,1)<>'«',INTERVAL(191,ASCII(name)),INTERVAL(191,ASCII(substring(name,2)))) as lang,
            vid_inion,vid
            FROM publ WHERE " . $search_string . " AND status= 1" .
                " ORDER BY " . $order .
                " LIMIT " . $cleanCount
            );


    //	echo "<br />search=".$search_string;print_r($kw0);
            if (count($publ0) == 0)
                $publ0 = $DB->select("SELECT DISTINCT id," . $pole . "name,avtor,year,`hide_autor` AS avthide,
                IF(substring(name,1,1)<>'«',INTERVAL(191,ASCII(name)),INTERVAL(191,ASCII(substring(name,2)))) AS lang,
                IF(substring(rubric2,1,1)='r' OR substring(rubric2d,1,1)='r' OR  substring(rubric2_3,1,1)='r' OR
                substring(rubric2_4,1,1)='r' OR  substring(rubric2_5,1,1)='r','retro','actual') AS rtype,tip,vid
                FROM publ WHERE id=" . $cleanId .
                    " ORDER BY rtype,lang"
                );
        }
    }
//    print_r($publ0);
    return $publ0;
   }

   function getContributorRoleById($id) {
       global $DB;

       $role = $DB->selectRow(
           "SELECT el.el_id AS id,rn.icont_text AS 'role_name',rne.icont_text AS 'role_name_en', rcn.icont_text AS 'role_crossref_name' FROM adm_directories_element AS el 
                INNER JOIN adm_directories_content AS rn ON rn.el_id=el.el_id AND rn.icont_var='role_name'
                INNER JOIN adm_directories_content AS rne ON rne.el_id=el.el_id AND rne.icont_var='role_name_en'
                INNER JOIN adm_directories_content AS rcn ON rcn.el_id=el.el_id AND rcn.icont_var='role_crossref_name'
                WHERE el.itype_id=27 AND el.el_id=?d 
                ORDER BY rn.icont_text",
           $id
       );
       return $role;
   }

   function getContributorRoles() {
	    global $DB;

	    $rolesList = $DB->select(
	        "SELECT el.el_id AS id,rn.icont_text AS 'role_name',rne.icont_text AS 'role_name_en', rcn.icont_text AS 'role_crossref_name' FROM adm_directories_element AS el 
                INNER JOIN adm_directories_content AS rn ON rn.el_id=el.el_id AND rn.icont_var='role_name'
                INNER JOIN adm_directories_content AS rne ON rne.el_id=el.el_id AND rne.icont_var='role_name_en'
                INNER JOIN adm_directories_content AS rcn ON rcn.el_id=el.el_id AND rcn.icont_var='role_crossref_name'
                WHERE el.itype_id=27
                ORDER BY rn.icont_text"
        );

	    return $rolesList;
   }

   function getCitationLinkById($id) {
	    global $DB;

	    $row = $DB->selectRow("SELECT * FROM publ WHERE id=?d",$id);

       $temp=explode("<br>",trim($row[avtor]));

       $avtor_citat_string = "";

       $ps=new Persons();

       foreach($temp as $ii=>$avt)
       {


           if (!empty($avt))
           {

               if (is_numeric($avt))
               {
                   $avtor=$ps->getAvtorById($avt);
                   if(!empty($avtor_citat_string))
                       $avtor_citat_string.=", ";

                   if($row['name']==$row['name2']) {
                       if($avtor[0]['full_name_echo']==1) {
                           $avtor_citat_string.=$avtor[0]['Autor_en'];
                       } else {
                           $avtor_citat_string .= mb_stristr($avtor[0]['Autor_en'], " ", true) . " " . substr(mb_stristr($avtor[0]['Autor_en'], " "), 1, 1) . ".";
                       }
                   } else {
                       $avtor_citat_string.=$avtor[0][fullname];
                   }
               }
               else
               {
                   if (trim($avt)!='Коллектив авторов')
                   {
                       $a=explode("|",$avt);
                       if ($_SESSION[lang]!='/en')
                       {
                           if(!empty($avtor_citat_string))
                               $avtor_citat_string.=", ";
                           $avtor_citat_string.=$a[0];
                       }
                   }
               }
           }
       }

       $name = "";
       if ($row[hide_autor] != "on")
           if (!empty($avtor_citat_string)) $name = $avtor_citat_string . " ";

       $slashes_pos = mb_stripos($row[name], "//");

       if ($slashes_pos !== FALSE) {
           if (substr($row[name], $slashes_pos - 6, 6) == 'https:' || substr($row[name], $slashes_pos - 5, 5) == 'http:')
               $name .= $row[name];
           else {
               $name .= $row[name_title];
               if (substr($row['name_title'], -1) != '.') {
                   $name .= ".";
               }
               $name .= " – " . substr($row[name], $slashes_pos + 3);
           }
       } else {
           $name .= $row[name];
       }
       return $name;
   }

    /**
     * @param array $request
     * @param int $perPage
     * @param bool $includeMagazines
     */
    function performQueryForList($request, $perPage = 40, $includeMagazines = false) {
        global $DBH;

        if (isset($request["publid"]))
        {
            return;
        }
        
        $this->selectConditions = array();
        $this->selectParameters = array();
        $this->conditions = array();
        $this->parameters = array();
        $this->magazineConditions = array();
        $this->magazineParameters = array();


        //Разбор параметров, создавление строки запроса
        if (!empty($request["field_of_knowledge"])) {
            $STH = $DBH->prepare("SELECT ae.el_id AS 'id' FROM `adm_directories_element` AS ae
                INNER JOIN adm_directories_content AS acfok ON acfok.el_id=ae.el_id AND acfok.icont_var = 'field_of_knowledge'
                WHERE ae.itype_id = 23 AND acfok.icont_text = ?");
            $STH->execute(array($request["field_of_knowledge"]));
            $rubrics = $STH->fetchAll(PDO::FETCH_ASSOC);

            $conditions = "";
            foreach ($rubrics as $rubric) {
                $conditions.= "rubric2 = ? OR rubric = ? OR ";
                $this->parameters[] = $rubric["id"];
                $this->parameters[] = $rubric["id"];
            }

            if(!empty($conditions)) {
                $conditions = substr($conditions,0, -3);
                $this->conditions[] = "($conditions)";
                $this->magazineConditions[] = "(0=1)";
                $this->afjournConditions[] = "(0=1)";
            }
        }
        if (!empty($request["rubric"]))
        {
            $this->conditions[] = "(rubric2 = ? OR rubric = ?)";
            $this->parameters[] = $request["rubric"];
            $this->parameters[] = $request["rubric"];
            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }
        if (!empty($request["vid"]) )
        {
            $this->conditions[] = "(vid = ?)";
            $this->parameters[] = $request["vid"];
            if($request["vid"]!=428) {
                $this->magazineConditions[] = "(0=1)";
                $this->afjournConditions[] = "(0=1)";
            }
        }
        if (!empty($request["land"]) )
        {
            $this->conditions[] = "(land = ?)";
            $this->parameters[] = $request["land"];
            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }

        //Задана буква для автора
        if (!empty($request["alfa"]))
        {
            if($request["alfa"]!='eng') {
                if ($_SESSION["lang"] != "/en") {
                    $STH = $DBH->prepare("SELECT id FROM persons WHERE surname LIKE ?");
                    $STH->execute(array("{$request["alfa"]}%"));
                    $spavtor0 = $STH->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $STH = $DBH->prepare("SELECT id FROM persons WHERE Autor_en LIKE ?");
                    $STH->execute(array("{$request["alfa"]}%"));
                    $spavtor0 = $STH->fetchAll(PDO::FETCH_ASSOC);
                }
            } else {
                $engAuthors = "";
                $avtorStr = "";
                foreach (range('A', 'Z') as $symbol){
                    $engAuthors .= "surname LIKE '".$symbol."%'";
                    $avtorStr .= "avtor LIKE '".$symbol."%' 
                            OR avtor LIKE '%<br>".$symbol."%' 
                            OR people_linked LIKE '".$symbol."%' 
                            OR people_linked LIKE '%<br>".$symbol."%'";
                    if($symbol!="Z") {
                        $engAuthors.=" OR ";
                        $avtorStr .= " OR ";
                    }
                }
                $STH = $DBH->prepare("SELECT id FROM persons WHERE " . $engAuthors);
                $STH->execute();
                $spavtor0 = $STH->fetchAll(PDO::FETCH_ASSOC);
            }
            $conditions="";
            foreach($spavtor0 as $spavtor)
            {
                $conditions .= "avtor LIKE ? 
                            OR avtor LIKE ? 
                            OR avtor LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ? OR ";
                $this->parameters[] = "{$spavtor["id"]}<br>%";
                $this->parameters[] = "%<br>{$spavtor["id"]}<br>%";
                $this->parameters[] = "%<br>{$spavtor["id"]}";
                $this->parameters[] = "{$spavtor["id"]}<br>%";
                $this->parameters[] = "%<br>{$spavtor["id"]}<br>%";
                $this->parameters[] = "%<br>{$spavtor["id"]}";
            }
            if(!empty($conditions)) {
                $conditions = substr($conditions,0, -3);
                $this->conditions[] = "(({$conditions}) AND NOT avtor LIKE '%коллектив авторо%')";
            }
        }

        // задан префикс в названии
        if (!empty($request["namef"]) && $request["namef"]!="*")
        {
            $namefReplaced = str_replace('ё', 'е', $request["namef"]) . "%";
            $this->conditions[] = "(name".$this->langPrefPubl." LIKE ? OR name".$this->langPrefPubl." LIKE ?)";
            $this->parameters[] = $request["namef"]."%";
            $this->parameters[] = $namefReplaced;
            $this->magazineConditions[] = "(aa.name{$this->langPrefPubl} LIKE ? OR aa.name{$this->langPrefPubl} LIKE ?)";
            $this->magazineParameters[] = $request["namef"]."%";
            $this->magazineParameters[] = $namefReplaced;
            $this->afjournConditions[] = "(p.page_name{$this->langPrefPubl} LIKE ? OR p.page_name{$this->langPrefPubl} LIKE ?)";
            $this->afjournParameters[] = $request["namef"]."%";
            $this->afjournParameters[] = $namefReplaced;
        }

        //Задан автор
        if (!empty($request["fio"]) && 	$request["fio"]!="*")
        {
            if (is_numeric($request["fio"]))
            {
                $STH = $DBH->prepare("SELECT id FROM persons WHERE second_profile=?");
                $STH->execute(array($request["fio"]));
                $second_profiles = $STH->fetchAll(PDO::FETCH_ASSOC);
                foreach($second_profiles AS $second_profile) {
                    $fioCond = " OR avtor LIKE ? 
                            OR avtor LIKE ? 
                            OR avtor LIKE ? OR people_linked LIKE ? 
                                     OR people_linked LIKE ?
                                     OR people_linked LIKE ?";
                    $this->parameters[] = "{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}";
                    $this->parameters[] = "{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}";

                    $fioCondMagazine = " OR people LIKE ? 
                            OR people LIKE ? 
                            OR people LIKE ?";
                    $this->magazineParameters[] = "{$second_profile["id"]}<br>%";
                    $this->magazineParameters[] = "%<br>{$second_profile["id"]}<br>%";
                    $this->magazineParameters[] = "%<br>{$second_profile["id"]}";

                    $fioCondAfjourn = " OR pers.cv_text LIKE ? 
                            OR pers.cv_text LIKE ? 
                            OR pers.cv_text LIKE ?";
                    $this->afjournParameters[] = "{$second_profile["id"]}<br>%";
                    $this->afjournParameters[] = "%<br>{$second_profile["id"]}<br>%";
                    $this->afjournParameters[] = "%<br>{$second_profile["id"]}";
                }
                $spavtor=$request["fio"];
                $this->conditions[] = "(avtor LIKE ? 
                            OR avtor LIKE ? 
                            OR avtor LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ? ".$fioCond.")";
                $this->parameters[] = "{$spavtor}<br>%";
                $this->parameters[] = "%<br>{$spavtor}<br>%";
                $this->parameters[] = "%<br>{$spavtor}";
                $this->parameters[] = "{$spavtor}<br>%";
                $this->parameters[] = "%<br>{$spavtor}<br>%";
                $this->parameters[] = "%<br>{$spavtor}";

                $this->magazineConditions[] = "(people LIKE ? 
                            OR people LIKE ? 
                            OR people LIKE ? ".$fioCondMagazine.")";
                $this->magazineParameters[] = "{$spavtor}<br>%";
                $this->magazineParameters[] = "%<br>{$spavtor}<br>%";
                $this->magazineParameters[] = "%<br>{$spavtor}";

                $this->afjournConditions[] = "(pers.cv_text LIKE ? 
                            OR pers.cv_text LIKE ? 
                            OR pers.cv_text LIKE ? ".$fioCondAfjourn.")";
                $this->afjournParameters[] = "{$spavtor}<br>%";
                $this->afjournParameters[] = "%<br>{$spavtor}<br>%";
                $this->afjournParameters[] = "%<br>{$spavtor}";

            }
            else
            {
                $this->conditions[] = "(avtor LIKE ? 
                            OR avtor LIKE ? 
                            OR avtor LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ?)";
                $this->parameters[] = "{$request["fio"]}%";
                $this->parameters[] = "%{$request["fio"]}%";
                $this->parameters[] = "%{$request["fio"]}";
                $this->parameters[] = "{$request["fio"]}%";
                $this->parameters[] = "%{$request["fio"]}%";
                $this->parameters[] = "%{$request["fio"]}";
            }
            $this->order="z.year DESC,z.name";
        }

        //Задан контент
        if (!empty($request["name"]) && $request["name"]!="*")
        {
            $sname=str_replace("_"," ",$request['name']);

            $this->selectConditions[] = "MATCH (`name{$this->langPrefPubl}`,`annots{$this->langPref}`,`keyword{$this->langPref}`) AGAINST (?) AS relevant, 
                IF(name{$this->langPrefPubl} LIKE ?,2,
                IF(name{$this->langPrefPubl} LIKE ? 
                OR name{$this->langPrefPubl} LIKE ?
                OR annots{$this->langPref} LIKE ? 
                OR annots{$this->langPref} LIKE ? 
                OR annots{$this->langPref} LIKE ? 
                OR keyword{$this->langPref} LIKE ?
                OR keyword{$this->langPref} LIKE ? 
                OR keyword{$this->langPref} LIKE ?,1,0)) AS find_by_name";

            $this->selectParameters[] = $sname;
            $this->selectParameters[] = "%{$sname}%";
            $this->selectParameters[] = "%{$sname}";
            $this->selectParameters[] = "{$sname}%";
            $this->selectParameters[] = "%{$sname}%";
            $this->selectParameters[] = "%{$sname}";
            $this->selectParameters[] = "{$sname}%";
            $this->selectParameters[] = "%{$sname}%";
            $this->selectParameters[] = "%{$sname}";
            $this->selectParameters[] = "{$sname}%";

            $this->conditions[] = "(MATCH (`name{$this->langPrefPubl}`,`annots{$this->langPref}`,`keyword{$this->langPref}`) AGAINST (?)>0 OR  ".
                " name{$this->langPrefPubl} LIKE ? 
        OR name{$this->langPrefPubl} LIKE ? 
        OR name{$this->langPrefPubl} LIKE ? OR ".
                " annots{$this->langPref} LIKE ? 
        OR annots{$this->langPref} LIKE ? 
        OR annots{$this->langPref} LIKE ? OR ".
                " keyword{$this->langPref} LIKE ?
        OR keyword{$this->langPref} LIKE ? 
        OR keyword{$this->langPref} LIKE ?)";

            $this->parameters[] = $sname;
            $this->parameters[] = "%{$sname}%";
            $this->parameters[] = "%{$sname}";
            $this->parameters[] = "{$sname}%";
            $this->parameters[] = "%{$sname}%";
            $this->parameters[] = "%{$sname}";
            $this->parameters[] = "{$sname}%";
            $this->parameters[] = "%{$sname}%";
            $this->parameters[] = "%{$sname}";
            $this->parameters[] = "{$sname}%";

            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        } else {
            $this->selectConditions[] = "0 AS find_by_name";
        }

        //Задан год
        if (!empty($request["year"]) && $request["year"]!="*")
        {
            $this->conditions[] = "(year = ?)";
            $this->parameters[] = $request["year"];
            $this->magazineConditions[] = "(aa.year LIKE ?)";
            $this->magazineParameters[] = $request["year"];
            $this->afjournConditions[] = "(y.page_name LIKE ?)";
            $this->afjournParameters[] = $request["year"];
        }

        //Задан isbn
        if (!empty($request["isbn"]) && $request["isbn"]!="*")
        {
            $this->conditions[] = "(izdat = ?)";
            $this->parameters[] = $request["isbn"];
            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }

        // Ключевые слова
        if (!empty($request["key"])) $request["keyword1"]=$request["key"];
        if (!empty($request["keyword1"]) ||  !empty($request["keyword2"]) || !empty($request["keyword3"]))
        {
            if (!empty($request["keyword1"]))
            {
                $this->conditions[] = "(keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ?)";
                $this->parameters[] = "{$request["keyword1"]}%";
                $this->parameters[] = "%{$request["keyword1"]}%";
                $this->parameters[] = "%{$request["keyword1"]}";
                $this->magazineConditions[] = "(aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ?)";
                $this->magazineParameters[] = "{$request["keyword1"]}%";
                $this->magazineParameters[] = "%{$request["keyword1"]}%";
                $this->magazineParameters[] = "%{$request["keyword1"]}";
                $this->afjournConditions[] = "(keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ?)";
                $this->afjournParameters[] = "{$request["keyword1"]}%";
                $this->afjournParameters[] = "%{$request["keyword1"]}%";
                $this->afjournParameters[] = "%{$request["keyword1"]}";
            }
            if (!empty($request["keyword2"]))
            {
                $this->conditions[] = "(keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ?)";
                $this->parameters[] = "{$request["keyword2"]}%";
                $this->parameters[] = "%{$request["keyword2"]}%";
                $this->parameters[] = "%{$request["keyword2"]}";
                $this->magazineConditions[] = "(aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ?)";
                $this->magazineParameters[] = "{$request["keyword2"]}%";
                $this->magazineParameters[] = "%{$request["keyword2"]}%";
                $this->magazineParameters[] = "%{$request["keyword2"]}";
                $this->afjournConditions[] = "(keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ?)";
                $this->afjournParameters[] = "{$request["keyword2"]}%";
                $this->afjournParameters[] = "%{$request["keyword2"]}%";
                $this->afjournParameters[] = "%{$request["keyword2"]}";
            }
            if (!empty($request["keyword3"]))
            {
                $this->conditions[] = "(keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ? OR keyword{$this->langPref} LIKE ?)";
                $this->parameters[] = "{$request["keyword3"]}%";
                $this->parameters[] = "%{$request["keyword3"]}%";
                $this->parameters[] = "%{$request["keyword3"]}";
                $this->magazineConditions[] = "(aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ? OR aa.keyword{$this->langPref} LIKE ?)";
                $this->magazineParameters[] = "{$request["keyword3"]}%";
                $this->magazineParameters[] = "%{$request["keyword3"]}%";
                $this->magazineParameters[] = "%{$request["keyword3"]}";
                $this->afjournConditions[] = "(keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ? OR keyword{$this->langPref}.cv_text LIKE ?)";
                $this->afjournParameters[] = "{$request["keyword3"]}%";
                $this->afjournParameters[] = "%{$request["keyword3"]}%";
                $this->afjournParameters[] = "%{$request["keyword3"]}";
            }
        }

        //Тип публикации
        if (!empty($_REQUEST['type']))
        {
            if ($request["type"]!="*")
            {
                $this->conditions[] = "(tip = ?)";
                $this->parameters[] = $request["type"];
                if($request["type"]!=442) {
                    $this->magazineConditions[] = "(0=1)";
                    $this->afjournConditions[] = "(0=1)";
                }
            }
        }

        //Есть полный текст
        if ($request["fullt"]=='on')
        {
            $this->conditions[] = "(link LIKE '%.pdf%')";
        }

        //Публикации подразделения
        // Сформировать список сотрудников
        if (!empty($request["tid"]))
        {
            $pd = new Podr();
            $fio0 = $pd->CenterPersonsWhereString($request["tid"]);
            $conditions = "";
            foreach($fio0 as $fio)
            {
                $STH = $DBH->prepare("SELECT id FROM persons WHERE second_profile=?");
                $STH->execute(array($fio["id"]));
                $second_profiles = $STH->fetchAll(PDO::FETCH_ASSOC);
                $fioCond = "";
                foreach($second_profiles AS $second_profile) {
                    $fioCond .= " OR people_linked LIKE ? 
                                     OR people_linked LIKE ?
                                     OR people_linked LIKE ? OR ";
                    $this->parameters[] = "{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}<br>%";
                    $this->parameters[] = "%<br>{$second_profile["id"]}";
                }
                $spavtorTid=$fio["id"];

                if(!empty($fioCond)) {
                    $fioCond = substr($fioCond,0, -3);
                }

                $conditions .= "avtor LIKE ? 
                            OR avtor LIKE ? 
                            OR avtor LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ?
                            OR people_linked LIKE ? ".$fioCond." OR ";
                $this->parameters[] = "{$spavtorTid}<br>%";
                $this->parameters[] = "%<br>{$spavtorTid}<br>%";
                $this->parameters[] = "%<br>{$spavtorTid}";
                $this->parameters[] = "{$spavtorTid}<br>%";
                $this->parameters[] = "%<br>{$spavtorTid}<br>%";
                $this->parameters[] = "%<br>{$spavtorTid}";

            }
            if(!empty($conditions)) {
                $conditions = substr($conditions,0, -3);
                $this->conditions[] = "({$conditions})";
            }
            $this->order="z.year DESC,{$this->langSql},z.name";
            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////
        //С грифом инстута
        if (isset($request["is"]))
        {
            $this->conditions[] = "(name2 LIKE '%ИМЭМО%' OR name2 LIKE '%ИМЭМО%' OR name2 LIKE '%ИМЭМО%' OR ".
                " name2 LIKE '%ИМЭМО%')";

            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }

        if (empty($request["fio"])) {
            $this->conditions[] = 'vid_inion<>1';
        }

        if (isset($request["last"])) {
            $this->order = "substring(z.date,7,2) DESC,substring(z.date,4,2) DESC, substring(z.date,1,2) DESC";

            $this->magazineConditions[] = "(0=1)";
            $this->afjournConditions[] = "(0=1)";
        }

        if (empty($this->order) && $_SESSION["lang"]!='/en') $this->order=$this->langSql.', REPLACE(z.name,"«",""),z.year';
        if (empty($this->order) && $_SESSION["lang"]=='/en') $this->order=$this->langSql.', REPLACE(z.name2,"«",""),year';

   }

    /**
     * @param array $request
     * @param int $perPage
     * @param bool $includeMagazines
     * @return int
     */
    function getListCountAfterQuery($request, $perPage, $includeMagazines = false) {
       global $DBH;



       if (!isset($request["publid"]))
       {
           $whereImploded = implode(" AND ", $this->conditions);
           if(empty($whereImploded)) {
               $whereImploded = "1";
           }

           if ($_SESSION["lang"]!='/en') {
               $STH = $DBH->prepare("
            SELECT count(id) AS count 
            FROM publ 
            WHERE {$whereImploded} AND status = 1
            ");
           }
           else {
               $STH = $DBH->prepare("
            SELECT count(id) AS count 
            FROM publ 
            WHERE {$whereImploded} AND status = 1 AND name2<>''
            ");

           }

           $STH->execute($this->parameters);
           $publcount0 = $STH->fetchAll(PDO::FETCH_ASSOC);
           $numpubl=(int)$publcount0[0]['count'];

           //if(!empty($request['fio'])) {
               if (empty($request["name"]) || $request["name"]=="*") {
                   $magazinesQuery = "";

                   $magazineWhereImploded = implode(" AND ", $this->magazineConditions);
                   if (empty($magazineWhereImploded)) {
                       $magazineWhereImploded = "1";
                   }

                   $STH = $DBH->prepare("SELECT count(page_id) AS count
            FROM `adm_article` AS aa
            WHERE {$magazineWhereImploded} AND aa.page_template='jarticle' AND aa.page_status=1 AND 
            (aa.to_publs_list=1 OR aa.affiliation LIKE '%Примаков%' OR aa.affiliation LIKE '%ИМЭМО%' OR aa.people_affiliation_en LIKE '%IMEMO%')");
                   $STH->execute($this->magazineParameters);
                   $publcount0 = $STH->fetchAll(PDO::FETCH_ASSOC);
                   $numpubl+=(int)$publcount0[0]['count'];

                   if($this->withAfjourn) {
                       $afjournWhereImploded = implode(" AND ", $this->afjournConditions);
                       if (empty($afjournWhereImploded)) {
                           $afjournWhereImploded = "1";
                       }

                       $STH = $DBH->prepare("
                            SELECT count(p.page_id) AS count
                            FROM afjourn.adm_pages AS p
                            INNER JOIN afjourn.adm_pages_content AS pers ON p.page_id=pers.page_id AND pers.cv_name='PEOPLE'                    
                            INNER JOIN afjourn.adm_pages AS r ON p.page_parent=r.page_id
                            INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
                            INNER JOIN afjourn.adm_pages AS y ON n.page_parent=y.page_id
                            INNER JOIN afjourn.adm_pages_content AS keyword ON p.page_id=keyword.page_id AND keyword.cv_name='KEYWORD'
                            INNER JOIN afjourn.adm_pages_content AS keyword_en ON p.page_id=keyword_en.page_id AND keyword_en.cv_name='KEYWORD_EN'
                            INNER JOIN afjourn.adm_pages_content AS affiliation ON p.page_id=affiliation.page_id AND affiliation.cv_name='AFFILIATION'
                            LEFT JOIN afjourn.adm_pages_content AS to_publs_list ON p.page_id=to_publs_list.page_id AND to_publs_list.cv_name='TO_PUBLS_LIST'
                            WHERE {$afjournWhereImploded} AND p.page_template='article' AND p.page_status=1 AND n.page_status=1 AND 
                            ((affiliation.cv_text LIKE '%Примаков%' OR affiliation.cv_text LIKE '%ИМЭМО%' OR p.people_affiliation_en LIKE '%IMEMO%') OR to_publs_list.cv_text=1)
                            ");
                       $STH->execute($this->afjournParameters);

                       $publcount0 = $STH->fetchAll(PDO::FETCH_ASSOC);
                       $numpubl+=(int)$publcount0[0]['count'];
                   }
               }
           //}

       }
       else {
           $publ0 = $this->RelatedPublications((int)$request["publid"],1000);
           $numpubl=count($publ0);
       }
        if (isset($request["last"])) $numpubl=$perPage;

       return $numpubl;
   }

   function getListAfterQuery($request, $perPage, $page, $includeMagazines = false) {
       global $DBH;
       if(empty($page)) {
           $page = 1;
       }
       if (isset($request["publid"])) // похожие
       {
           return $this->RelatedPublications((int)$request["publid"],$perPage); 
       }
       else
       {
           if (!empty($request["fio"]) && 	$request["fio"]!="*")
               $orderby_fio="";
           else {
               $sort = "";
               if($_GET['sort']=='desc') {
                   $sort = " DESC";
               }

               switch ($_GET['sort_field']) {
                   case 'name':
                       $sort_field = $this->langSql.$sort.",z.name".$sort;
                       break;
                   case 'date':
                       $sort_field = "concat(substring(date,7,2),substring(date,4,2),substring(date,1,2))".$sort;
                       break;
                   case 'year':
                       $sort_field = "z.year".$sort.",".$this->langSql.$sort.",z.name".$sort;
                       break;
                   default:
                       $sort_field = "";
               }

               if(!empty($sort_field)) {
                   $orderby_fio = $sort_field.",";
               } else {
                   if ($_SESSION["lang"] != '/en')
                       $orderby_fio = $this->langSql.$sort.",z.name".$sort.",";
                   else
                       $orderby_fio = "z.name".$sort.",";
               }

           }

           $order_land_date = "";
           if(!empty($request["land"])) {
               $order_land_date = "substring(date,7,2) DESC,substring(date,4,2) DESC,substring(date,1,2) DESC,";
           }

           $i0=($page-1)*$perPage;

           if ($_SESSION["lang"]!='/en')
           {
               $selectParamsMerged = $this->parameters;
               $magazinesQuery = "";
               $afjournQuery = "";
               //if(!empty($request["fio"])) {
                   if (empty($request["name"]) || $request["name"]=="*") {

                       $magazineWhereImploded = implode(" AND ", $this->magazineConditions);
                       if (empty($magazineWhereImploded)) {
                           $magazineWhereImploded = "1";
                       }

                       $magazinesQuery = "
                   UNION
                   SELECT 0 AS find_by_name, -aa.page_id AS id, CONCAT(aa.name) COLLATE cp1251_general_ci AS name, ps.cv_text COLLATE cp1251_general_ci AS picsmall, 441 AS tip, 0 AS hide_autor, people COLLATE cp1251_general_ci AS avtor,CONCAT(aa.name_en) COLLATE cp1251_general_ci AS name2, CONCAT(SUBSTR(aa.date,6,2),'.',SUBSTR(aa.date,4,2),'.',SUBSTR(aa.date,2,2)) AS date, CONCAT('/jour/',am.page_journame,'/index.php?page_id=',sl.cv_text,'&id=',aa.page_id,'&jid=',aa.jid,'&jj=',aa.journal) AS link, aa.year, aa.link AS magazine_file_link,  aa.link_en AS magazine_file_link_en, journal_new AS magazine_id, author_open_text AS author_open_text
                    FROM `adm_article` AS aa
                    INNER JOIN adm_magazine AS am ON aa.journal=am.page_id
                    INNER JOIN adm_pages_content AS apc ON am.page_id=apc.cv_text AND apc.cv_name='ITYPE_JOUR'
                    INNER JOIN adm_pages AS ap ON apc.page_id=ap.page_id AND ap.page_template='magazine'
                    INNER JOIN adm_pages_content AS sl ON sl.page_id=ap.page_id AND sl.cv_name='ARTICLE_ID'
                    INNER JOIN adm_pages_content AS ps ON aa.journal_new=ps.page_id AND ps.cv_name='LOGO_SLIDER'
                    WHERE {$magazineWhereImploded} AND aa.page_template='jarticle' AND aa.page_status=1 AND 
            (aa.to_publs_list=1 OR aa.affiliation LIKE '%Примаков%' OR aa.affiliation LIKE '%ИМЭМО%' OR aa.people_affiliation_en LIKE '%IMEMO%')
                   ";

                       $selectParamsMerged = array_merge($selectParamsMerged,$this->magazineParameters);

                       if($this->withAfjourn) {
                           $afjournWhereImploded = implode(" AND ", $this->afjournConditions);
                           if (empty($afjournWhereImploded)) {
                               $afjournWhereImploded = "1";
                           }

                           $afjournQuery = "
                   UNION
                   SELECT 0 AS find_by_name, -p.page_id AS id, CONCAT(p.page_name) COLLATE cp1251_general_ci AS name, ps.cv_text COLLATE cp1251_general_ci AS picsmall, 441 AS tip, 0 AS hide_autor, pers.cv_text COLLATE cp1251_general_ci AS avtor,CONCAT(p.page_name_en) COLLATE cp1251_general_ci AS name2, CONCAT(SUBSTR(p.date_created,9,2),'.',SUBSTR(p.date_created,6,2),'.',SUBSTR(p.date_created,3,2)) AS date, CONCAT('https://www.afjournal.ru','/index.php?page_id=',p.page_id) AS link, y.page_name AS year, pdf.cv_text AS magazine_file_link,  pdfe.cv_text AS magazine_file_link_en, -1 AS magazine_id, 0 AS author_open_text
                    FROM afjourn.adm_pages AS p
                    INNER JOIN afjourn.adm_pages_content AS pers ON p.page_id=pers.page_id AND pers.cv_name='PEOPLE'
                    INNER JOIN afjourn.adm_pages AS r ON p.page_parent=r.page_id
                    INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
                    INNER JOIN afjourn.adm_pages AS y ON n.page_parent=y.page_id
                    INNER JOIN adm_pages_content AS ps ON 1674=ps.page_id AND ps.cv_name='LOGO_SLIDER'
                    INNER JOIN afjourn.adm_pages_content AS pdf ON p.page_id=pdf.page_id AND pdf.cv_name='LINK_PDF'
                    INNER JOIN afjourn.adm_pages_content AS pdfe ON p.page_id=pdfe.page_id AND pdfe.cv_name='LINK_PDF_EN'
                    INNER JOIN afjourn.adm_pages_content AS keyword ON p.page_id=keyword.page_id AND keyword.cv_name='KEYWORD'
                    INNER JOIN afjourn.adm_pages_content AS keyword_en ON p.page_id=keyword_en.page_id AND keyword_en.cv_name='KEYWORD_EN'
                    INNER JOIN afjourn.adm_pages_content AS affiliation ON p.page_id=affiliation.page_id AND affiliation.cv_name='AFFILIATION'
                    LEFT JOIN afjourn.adm_pages_content AS to_publs_list ON p.page_id=to_publs_list.page_id AND to_publs_list.cv_name='TO_PUBLS_LIST'
                    WHERE {$afjournWhereImploded} AND p.page_template='article' AND p.page_status=1 AND n.page_status=1 AND 
                    ((affiliation.cv_text LIKE '%Примаков%' OR affiliation.cv_text LIKE '%ИМЭМО%' OR p.people_affiliation_en LIKE '%IMEMO%') OR to_publs_list.cv_text=1)
                   ";
                           $selectParamsMerged = array_merge($selectParamsMerged,$this->afjournParameters);
                       }
                   }
               //}


               if (!isset($request["last"])) {

                   $selectImploded = implode(", ", $this->selectConditions);
                   $whereImploded = implode(" AND ", $this->conditions);
                   if(empty($selectImploded)) {
                       $selectImploded = "1";
                   }
                   if(empty($whereImploded)) {
                       $whereImploded = "1";
                   }

                   $STH = $DBH->prepare("
            SELECT * FROM (
            SELECT {$selectImploded}, z.id, z.name, z.picsmall, z.tip, z.hide_autor, z.avtor, z.name2, z.date, z.link, z.year, '' AS magazine_file_link, '' AS magazine_file_link_en, 0 AS magazine_id, 0 AS author_open_text
            FROM publ AS z
            WHERE {$whereImploded} AND status = 1
            {$magazinesQuery}
            {$afjournQuery}
            ) AS z
            ORDER BY find_by_name DESC, {$order_land_date}{$orderby_fio}{$this->order}
            LIMIT {$i0}, {$perPage}
            ");

                    $STH->execute(array_merge($this->selectParameters,$selectParamsMerged));

                   return $STH->fetchAll(PDO::FETCH_ASSOC);

               }
               else {
                   $STH = $DBH->prepare("
            SELECT publ.* FROM publ
            WHERE status=1 AND vid_inion<>1		   
            ORDER BY substring(date,7,2) DESC,substring(date,4,2) DESC,substring(date,1,2) DESC
            LIMIT {$i0}, {$perPage}
            ");
                   $STH->execute(array_merge($this->selectParameters,$this->parameters));
                   return $STH->fetchAll(PDO::FETCH_ASSOC);
               }
           }
           else
           {
               $selectParamsMerged = $this->parameters;
               $magazinesQuery = "";
               $afjournQuery = "";
               //if(!empty($request["fio"])) {
                   if (empty($request["name"]) || $request["name"]=="*") {

                       $magazineWhereImploded = implode(" AND ", $this->magazineConditions);
                       if (empty($magazineWhereImploded)) {
                           $magazineWhereImploded = "1";
                       }

                       $magazinesQuery = "
                   UNION
                   SELECT 0 AS find_by_name, -aa.page_id AS id, CONCAT(aa.name_en) COLLATE cp1251_general_ci AS name, ps.cv_text COLLATE cp1251_general_ci AS picsmall, 441 AS tip, 0 AS hide_autor, people COLLATE cp1251_general_ci AS avtor,CONCAT(aa.name_en) COLLATE cp1251_general_ci AS name2, CONCAT(SUBSTR(aa.date,6,2),'.',SUBSTR(aa.date,4,2),'.',SUBSTR(aa.date,2,2)) AS date, CONCAT('/jour/',am.page_journame,'/index.php?page_id=',sl.cv_text,'&id=',aa.page_id,'&jid=',aa.jid,'&jj=',aa.journal) AS link, aa.year, aa.link AS magazine_file_link,  aa.link_en AS magazine_file_link_en, journal_new AS magazine_id, author_open_text AS author_open_text
                    FROM `adm_article` AS aa
                    INNER JOIN adm_magazine AS am ON aa.journal=am.page_id
                    INNER JOIN adm_pages_content AS apc ON am.page_id=apc.cv_text AND apc.cv_name='ITYPE_JOUR'
                    INNER JOIN adm_pages AS ap ON apc.page_id=ap.page_id AND ap.page_template='magazine'
                    INNER JOIN adm_pages_content AS sl ON sl.page_id=ap.page_id AND sl.cv_name='ARTICLE_ID'
                    INNER JOIN adm_pages_content AS ps ON aa.journal_new=ps.page_id AND ps.cv_name='LOGO_SLIDER'
                    WHERE {$magazineWhereImploded} AND aa.page_template='jarticle' AND aa.page_status=1 AND 
            (aa.to_publs_list=1 OR aa.affiliation LIKE '%Примаков%' OR aa.affiliation LIKE '%ИМЭМО%' OR aa.people_affiliation_en LIKE '%IMEMO%')
                   ";

                       $selectParamsMerged = array_merge($selectParamsMerged,$this->magazineParameters);

                       if($this->withAfjourn) {
                           $afjournWhereImploded = implode(" AND ", $this->afjournConditions);
                           if (empty($afjournWhereImploded)) {
                               $afjournWhereImploded = "1";
                           }

                           $afjournQuery = "
                   UNION
                   SELECT 0 AS find_by_name, -p.page_id AS id, CONCAT(p.page_name_en) COLLATE cp1251_general_ci AS name, ps.cv_text COLLATE cp1251_general_ci AS picsmall, 441 AS tip, 0 AS hide_autor, pers.cv_text COLLATE cp1251_general_ci AS avtor,CONCAT(p.page_name_en) COLLATE cp1251_general_ci AS name2, CONCAT(SUBSTR(p.date_created,6,2),'.',SUBSTR(p.date_created,4,2),'.',SUBSTR(p.date_created,2,2)) AS date, CONCAT('https://www.afjournal.ru','/en/index.php?page_id=',p.page_id) AS link, y.page_name AS year, pdf.cv_text AS magazine_file_link,  pdfe.cv_text AS magazine_file_link_en, -1 AS magazine_id, 0 AS author_open_text
                    FROM afjourn.adm_pages AS p
                    INNER JOIN afjourn.adm_pages_content AS pers ON p.page_id=pers.page_id AND pers.cv_name='PEOPLE'
                    INNER JOIN afjourn.adm_pages AS r ON p.page_parent=r.page_id
                    INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
                    INNER JOIN afjourn.adm_pages AS y ON n.page_parent=y.page_id
                    INNER JOIN adm_pages_content AS ps ON 1674=ps.page_id AND ps.cv_name='LOGO_SLIDER'
                    INNER JOIN afjourn.adm_pages_content AS pdf ON p.page_id=pdf.page_id AND pdf.cv_name='LINK_PDF'
                    INNER JOIN afjourn.adm_pages_content AS pdfe ON p.page_id=pdfe.page_id AND pdfe.cv_name='LINK_PDF_EN'
                    INNER JOIN afjourn.adm_pages_content AS keyword ON p.page_id=keyword.page_id AND keyword.cv_name='KEYWORD'
                    INNER JOIN afjourn.adm_pages_content AS keyword_en ON p.page_id=keyword_en.page_id AND keyword_en.cv_name='KEYWORD_EN'
                    INNER JOIN afjourn.adm_pages_content AS affiliation ON p.page_id=affiliation.page_id AND affiliation.cv_name='AFFILIATION'
                    LEFT JOIN afjourn.adm_pages_content AS to_publs_list ON p.page_id=to_publs_list.page_id AND to_publs_list.cv_name='TO_PUBLS_LIST'
                    WHERE {$afjournWhereImploded} AND p.page_template='article' AND p.page_status=1 AND n.page_status=1 AND 
                    ((affiliation.cv_text LIKE '%Примаков%' OR affiliation.cv_text LIKE '%ИМЭМО%' OR p.people_affiliation_en LIKE '%IMEMO%') OR to_publs_list.cv_text=1)
                   ";
                           $selectParamsMerged = array_merge($selectParamsMerged,$this->afjournParameters);
                       }
                   }
              // }

               if (!isset($request["last"])) {




                   $selectImploded = implode(", ", $this->selectConditions);
                   $whereImploded = implode(" AND ", $this->conditions);
                   if(empty($selectImploded)) {
                       $selectImploded = "1";
                   }
                   if(empty($whereImploded)) {
                       $whereImploded = "1";
                   }
                   $STH = $DBH->prepare("
            SELECT * FROM (
            SELECT {$selectImploded}, z.id, z.name, z.picsmall, z.tip, z.hide_autor, z.avtor, z.name2, z.date, z.link, z.year, '' AS magazine_file_link, '' AS magazine_file_link_en, 0 AS magazine_id, 0 AS author_open_text
            FROM publ AS z
            WHERE {$whereImploded} AND status = 1 AND IFNULL(z.name2,'')<>''
            {$magazinesQuery}
            {$afjournQuery}
            ) AS z
            ORDER BY find_by_name DESC, {$order_land_date}{$orderby_fio}{$this->order}
            LIMIT {$i0}, {$perPage}
            ");
                   $STH->execute(array_merge($this->selectParameters,$selectParamsMerged));

                   return $STH->fetchAll(PDO::FETCH_ASSOC);
               }
               else {

                   $STH = $DBH->prepare("
            SELECT publ.* FROM publ
            WHERE status=1 AND name2<> '' AND vid_inion<>1
            ORDER BY substring(date,7,2) DESC,substring(date,4,2) DESC,substring(date,1,2) DESC
            LIMIT {$i0}, {$perPage}
            ");
                   $STH->execute(array_merge($this->selectParameters,$this->parameters));
                   return $STH->fetchAll(PDO::FETCH_ASSOC);
               }
           }
       }
   }

    /**
     * @param bool $withAfjourn
     */
    public function setWithAfjourn($withAfjourn)
    {
        $this->withAfjourn = $withAfjourn;
    }

}