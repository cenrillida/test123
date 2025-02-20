<?
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);


include_once dirname(__FILE__)."/../../_include.php";

function updateChildPageUrlArticle($page_id) {
    global $DB;
    $pg = new Article();
    $childs = $pg->getChilds($page_id);

    foreach ($childs as $child) {
        if(!empty($child['article_url'])) {
            $url = createUrlArticleByPageId($child['article_url'], $child['page_id']);
            while (true) {
                $used = $DB->select("SELECT * FROM adm_article WHERE article_url=? AND page_id<>?d AND journal_new=?d",$url,$child['page_id'],$_REQUEST['journal_new']);

                if (!empty($used)) {
                    $url .= "-" . $child['page_id'];
                } else {
                    break;
                }
            }
            $DB->query("UPDATE adm_article SET article_url='".$url."' WHERE page_id=".$child['page_id']);
            $pages[$child['page_id']]['article_url'] = $url;
        }
        updateChildPageUrlArticle($child['page_id']);
    }
}

function createUrlArticleByPageId($data, $page_id) {
    global $pagesUrls;
    $page_url_name = "";
    $urlPagesArr = array();
    if(!empty($pagesUrls)) {
        $pages_urls = explode("/", $data);
        $pages_urls = array_reverse($pages_urls);
        $k = $page_id;
        while(true) {
            if($pagesUrls[$k]['page_parent']!=0 && !empty($pagesUrls[$k]['page_parent'])) {
                $k = $pagesUrls[$k]['page_parent'];
                $parent_pages_urls = explode("/", $pagesUrls[$k]['article_url']);
                $parent_pages_urls = array_reverse($parent_pages_urls);
                if (!empty($pagesUrls[$k]['article_url'])) {
                    $urlPagesArr[] = $parent_pages_urls[0];
                }
            } else {
                break;
            }
        }
        $urlPagesArr = array_reverse($urlPagesArr);
        $urlPagesStr = implode("/",$urlPagesArr);
        if($urlPagesStr!="") {
            $url = $urlPagesStr . "/" . $pages_urls[0];
        } else {
            $url = $pages_urls[0];
        }
        unset($pages_urls);
        unset($parent_pages_urls);
        return $url;
    }
    return $data;
}


function createUrlArticle($data, $pages) {
    $page_url_name = "";
    if(!empty($pages)) {
        $pages_urls = explode("/", $data);
        $pages_urls = array_reverse($pages_urls);
        foreach ($pages as $page_k => $page) {
            $parent_pages_urls = explode("/", $page['article_url']);
            $parent_pages_urls = array_reverse($parent_pages_urls);
            if (!empty($page['article_url'])) {
                $page_url_name .= $parent_pages_urls[0]."/";
            }
        }
        $url = $page_url_name.$pages_urls[0];
        return $url;
    }
    return $data;
}

// создаем массив посто€ннных значений
$query = array();


$pg = new Article();
$pages = $pg->getParents($_REQUEST['parent']);

foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]) || $k == "id")
		continue;

	$data = @$_REQUEST[$k];
	if($k == "status" || $k == "dell")
		$data = (int)@$_REQUEST[$k];

// print_r($data);
	if($k == "urlname")
	{
		$urlnameVars = Templater::getVarsFromStr($data);
		$urlData = "";
		if(!empty($urlnameVars))
		{
			$urlData = str_replace(array(".", "/"), array("\.", "\/"), $data);
			$urlData  = "^".preg_replace("/{[A-Z]+[A-Z_]*}/", "([a-zA-Z0-9_]+)", $urlData)."$";
		}
		$query[$v["field"]."_regexp"] = $urlData;
	}

	if($k == "article_url" && $_REQUEST['parent']!=0) {

        if (empty($data)) {

            if($_REQUEST['template']=="jarticle") {
                if (!empty($_REQUEST["name_en"])) {
                    $latName = Dreamedit::cyrToLat($_REQUEST["name_en"]);
                } else {
                    $latName = Dreamedit::cyrToLat($_REQUEST["name"]);
                }
            }
            elseif($_REQUEST['template']=="jrubric") {
                if (!empty($_REQUEST["name_en"])) {
                    $latName = Dreamedit::cyrToLat($_REQUEST["name_en"]);
                } else {
                    $latName = Dreamedit::cyrToLat($_REQUEST["page_name"]);
                }
            }
            else {
                if (!empty($_REQUEST["page_name_en"])) {
                    $latName = Dreamedit::cyrToLat($_REQUEST["page_name_en"]);
                } else {
                    $latName = Dreamedit::cyrToLat($_REQUEST["page_name"]);
                }
            }
            $latName = str_replace("(", "-", $latName);
            $latName = str_replace(")", "-", $latName);
            $latName = preg_replace("/[^a-zA-Z-\d ]/", "", $latName);
            $latName = preg_replace("/ +/", " ", $latName);

            $latName = ltrim(rtrim($latName));
            $latName = str_replace(" ", "-", $latName);
            $latName = preg_replace("/-+/", "-", $latName);
            $latName = ltrim(rtrim($latName,"-"),"-");
            $latName = mb_strtolower($latName);

            $latName = Dreamedit::cyrToLatExcl($latName);


        } else {
            $latName = $data;
        }

        while (true) {
            $used = $DB->select("SELECT * FROM adm_article WHERE article_url=? AND page_id<>?d AND journal_new=?d",$latName,$_REQUEST['id'],$_REQUEST['journal_new']);

            if (!empty($used)) {
                $latName .= "-" . $_REQUEST['id'];
            } else {
                break;
            }
        }

        $data = createUrlArticle($latName, $pages);
    }

	$query[$v["field"]] = $data;
}

if(empty($query['page_status']))
	$query['page_status']=0;
if(empty($query['page_status_en']))
    $query['page_status_en']=0;
if(empty($query['fulltext_open']))
	$query['fulltext_open']=0;
if(empty($query['author_open_text']))
    $query['author_open_text']=0;
if(empty($query['to_publs_list']))
    $query['to_publs_list']=0;

// создаем массив значений контента
$content_query = array();
if(empty($query["page_link"]) && isset($tpl_vars))
{
	foreach($tpl_vars as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$data = "";
		if(isset($_REQUEST[$k]))
			$data = $_REQUEST[$k];

		$content_query[strtoupper($v["field"])] = $data;
	}
}
//if (!empty($query[journal]))
//	$jj=$DB->select("SELECT page_name FROM adm_magazine WHERE page_id=".$query[journal]);
//$query[page_name]=$jj[0][page_menuname]."-".$query[year]."-".$query[page_name];

// if ($query['page_template']=='jnumber') $query['page_parent']=0;

if (!empty($query[journal]))
{
	$jj=$DB->select("SELECT page_menuname,page_name FROM adm_magazine WHERE page_id=".$query[journal]);
	$query[j_name]=$jj[0][page_name];

}
else
{
   if ($_POST['template']=='jarticle')
   $jj=$DB->select("SELECT j_name,page_name  FROM adm_article WHERE page_id=".$_POST[parent]);
 //  $query[j_name]=$jj[0][j_name]."-".$query[year]."-".$jj[0][page_name];

}
//print_r($_POST);
//echo "<br /><br />";

if($_POST['template']=='jarticle' && !empty($_POST[jid]) && $_POST[jid]!=0) {
    $jid=$DB->select("SELECT cv_text AS date_public FROM adm_article_content WHERE cv_name='DATE_PUBLIC' AND page_id=".$_POST[jid]);
    if(!empty($jid[0][date_public])) {
        $query[date_public] = $jid[0][date_public];
    }
}


  if ($_POST['template']=='jrubric')
   if (empty($query[page_name]))
       	$query[page_name]=$_POST['page_name'];
   else
       if (!empty($_POST['name']))$query[page_name]=$_POST['name'];


if(!empty($_REQUEST["id"]))
{


//print_r($content_query);
if (!empty($content_query[DATE_PUBLIC]) && $_POST[template]=='jnumber')
{

   $mz=new Article();
   $rows=$mz->getChilds($_REQUEST["id"],"1");

//   print_r($rows);
   foreach($rows AS $k=>$row)
   {
   	   $nn[$k][page_id]=$row[page_id];
   	   $nn[$k][page_name]=$row[page_name];
   	   $rows2=$mz->getChilds($row["page_id"],"1");

        foreach($rows2 AS $k2=>$row2)
	   {
	   	   $nn[$k2][page_id]=$row2[page_id];
	   	   $nn[$k2][page_name]=$row[page_name];
	   	   $rows3=$mz->getChilds($row2["page_id"],"1");
            foreach($rows3 AS $k3=>$row3)
		   {
		   	   $nn[$k3][page_id]=$row3[page_id];
		   	   $nn[$k3][page_name]=$row[page_name];
		   	   $rows3=$mz->getChilds($row3["page_id"],"1");

		   }
	   }
   }
//   print_r($_POST);echo "<br />________________<br />";
//   print_r($mod_array);
//   echo "<br />________________<br />";
//   print_r($nn);

   foreach($nn as $n)
   {
   	  $DB->query("UPDATE ?_article  SET jid=".$_REQUEST["id"].",number='".$_POST[page_name]."',number_en='".$_POST[page_name_en]."',year='".$_POST[year]."',date_public='".$_POST[date_public]."'
   	       WHERE page_id=".$n[page_id]);
//	$id0=$DB->select("SELECT LAST_INSERT_ID() AS id FROM ?_article");
	if($_POST[order]==1)
    {	
      $o=$DB->select("SELECT page_id FROM adm_article_content WHERE page_id=".$n[page_id]." AND cv_name='order'");
	  if(count($o) >0) $DB->query("UPDATE adm_article_content SET cv_text=1 WHERE page_id=".$n[page_id]." AND cv_name='order'");
	  else $DB->query("INSERT adm_article_content(page_id,cv_name,cv_text) VALUES(".$n[page_id].",'ORDER','1')");
	}  
 
   }
}
//print_r($query);
$DB->query("UPDATE ?_article SET ?a WHERE   ".$mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);

	$DB->query("DELETE FROM ?_article_content WHERE  ".$mod_array["components"]["id"]["field"] . " = ?d", $_REQUEST["id"]);
	foreach($content_query as $k => $v)
	{
		$DB->query("INSERT INTO ?_article_content  SET ".$mod_array["components"]["id"]["field"] . " = ?d, cv_name = ?, cv_text = ?", $_REQUEST["id"], $k, $v);


	}
    $pagesUrls = $pg->getPages();
    updateChildPageUrlArticle($_REQUEST["id"]);

}
else
{
	$id = $DB->query("INSERT INTO ?_article SET  ?a ", $query);
	    $id0=$DB->select("SELECT LAST_INSERT_ID() AS id FROM ?_article");


	    $_REQUEST[id]=$id0[0][id];
}
// –азобратьс€ с авторами

$avt0=explode("<br>",trim($query[people]));
$i=0;
if (empty($avt0)) $sauthors="редакци€";

//if (!empty($query[j_name]))
//	$DB->query("DELETE FROM  persons WHERE error=1 AND journal='".$query[j_name]."'");

$affiliationsArray = array();
$organizationNameArray = array();
$organizationNameEnArray = array();

foreach($avt0 as $avt)
{
    if(!empty($_POST['affiliation_hidden'.$i])) {
        $affiliations = explode("{{{DELIMITER}}}",$_POST['affiliation_hidden'.$i]);
        $affiliationsArray[$i] = array();
        foreach ($affiliations as $affiliation) {
            if(!empty($affiliation)) {
                $affiliationsArray[$i][] = $affiliation;
            }
        }
    }
    if(!empty($_POST['organization_name_hidden'.$i])) {
        $organizations = explode("{{{DELIMITER}}}",$_POST['organization_name_hidden'.$i]);
        $organizationNameArray[$i] = array();
        foreach ($organizations as $organization) {
            if(!empty($organization)) {
                $organizationNameArray[$i][] = $organization;
            }
        }
    }
    if(!empty($_POST['organization_name_en_hidden'.$i])) {
        $organizationsEn = explode("{{{DELIMITER}}}",$_POST['organization_name_en_hidden'.$i]);
        $organizationNameEnArray[$i] = array();
        foreach ($organizationsEn as $organizationEn) {
            if(!empty($organizationEn)) {
                $organizationNameEnArray[$i][] = $organizationEn;
            }
        }
    }
$i++;
	if (!empty($avt))
	{
		if (!is_numeric($avt))
		{

            $aen=explode("|",$avt);
			$a=explode(" ",$aen[0]);
 //           $DB->query("INSERT INTO  persons  (id,surname,name,fname,work,journal,error,id_article,num_fio)
 //                        VALUES(0,'".$a[0]."','".$a[1]."','".$a[2]."','Ќе известно','".$query[j_name]."',1,".$_REQUEST["id"].",".$i.")");

		 	$otd=$DB->select("SELECT page_id FROM adm_pages WHERE page_name='".$query[j_name]."' ".
			                      " AND page_template='podr'"
			                 );
	       if (count($otd)==0) $otdel=561; else $otdel=$otd[0][page_id];
	      
		   $DB->query("INSERT INTO persons
	                  (id,surname,name,fname,otdel,jnumber,dolj,Autor_en)
	                  VALUES(
	                  0,".
	                  "'".$a[0]."',"."'".$a[1]."',"."'".$a[2]."',".
	                  $otdel.
	                  ",'".$query[j_name]."|".$query[number]."|".$query[year]."',".
					  "'100', ".
					  "'".$aen[1]."'".
	                  ")");
	       $pid = $DB->select("SELECT LAST_INSERT_ID() AS pid FROM persons LIMIT 1");
	       $sauthors.=$pid[0][pid]."<br>";
		}
		 else
		      $sauthors.=$avt."<br>";

	}


}

$affiliationsSerialized = serialize($affiliationsArray);
$DB->query("UPDATE adm_article SET people_affiliation_en=? WHERE page_id=?d",$affiliationsSerialized,$_REQUEST[id]);
$organizationsSerialized = serialize($organizationNameArray);
$DB->query("UPDATE adm_article SET organization_name=? WHERE page_id=?d",$organizationsSerialized,$_REQUEST[id]);
$organizationsEnSerialized = serialize($organizationNameEnArray);
$DB->query("UPDATE adm_article SET organization_name_en=? WHERE page_id=?d",$organizationsEnSerialized,$_REQUEST[id]);



$query[people]=$sauthors;
$DB->query("UPDATE adm_article SET people='".$sauthors."' WHERE page_id=".$_REQUEST[id]);
////
if(!empty($_REQUEST["id"]))
{
    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();
  	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["id"]);
}
else
{
    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}


?>