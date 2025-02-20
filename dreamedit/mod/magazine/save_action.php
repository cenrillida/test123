<?
include_once dirname(__FILE__)."/../../_include.php";

// создаем массив постояннных значений
$query = array();

foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]) || $k == "id")
		continue;

	$data = @$_REQUEST[$k];
	if($k == "status" || $k == "dell" || $k == "online_resource" || $k == "link_false")
		$data = (int)@$_REQUEST[$k];

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

	$query[$v["field"]] = $data;
}

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


if(!empty($_REQUEST["id"]))
{
	$DB->query("UPDATE  ?_magazine SET ?a WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);

	$DB->query("DELETE FROM ?_magazine_content WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $_REQUEST["id"]);
	foreach($content_query as $k => $v)
	{
		$DB->query("INSERT INTO ?_magazine_content SET ".$mod_array["components"]["id"]["field"] . " = ?d, cv_name = ?, cv_text = ?", $_REQUEST["id"], $k, $v);
	}

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["id"]);
}
else
{
	$id = $DB->query("INSERT   INTO ?_magazine SET ?a", $query);
	if ($query[page_template] == "0")
	{
	$jid=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_magazine");
// Сформировать страницы журнала
    $rowspage=$DB->select("SELECT page_id FROM adm_pages WHERE page_template='magazine' AND page_name='".$query[page_name]."'");
	
//	print_r($query);
    if (false && count($rowspage)==0)
    {
	   echo 'Надо формировать страницы журнала';
	   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status) 
	   VALUES('".$query[page_name]."','magazine','455','1')");
	   $page_id_magazine=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
	   $DB->query("DELETE FROM adm_pages_content WHERE page_id=".$page_id_magazine[0][id]);
	   $DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text) VALUES (".$page_id_magazine[0][id].",'TITLE','".$query[page_name]."')");
	   $DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text) VALUES (".$page_id_magazine[0][id].",'ITYPE_JOUR','".$jid[0]['id']."')");
	   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
	   VALUES ('Дополнительные страницы','0',".$page_id_magazine[0][id].",0)");
      $page_id_magazine0=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
//     Архив номеров, оглавление и страница статьи
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Архив номеров журнала «".$query[page_name]."»','magazine_archive',".$page_id_magazine0[0][id].",1)");
		   $page_id_archive=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Оглавление','magazine_page',".$page_id_archive[0][id].",1)");
		   $page_id_content=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Статья в журнале','magazine_article','".$page_id_content[0][id]."',1)");
		   $page_id_article=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages"); 
          //     Страница журнала
           $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Дополнительные страницы','0','".$page_id_magazine0[0][id]."',0)");
		   $page_id_dop=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");		   
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Страница журнала','magazine_full','".$page_id_dop[0][id]."',1)");
		   $page_id_full=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");	
//      Индекс авторов		   
           $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Индекс авторов','magazine_authors_index','".$page_id_magazine0[0][id]."',1)");
		   $page_id_avt_index=$DB->query("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Дополнительные страницы','0','".$page_id_avt_index[0][id]."',0)");
		   $page_id_avt_dop=$DB->query("SELECT LAST_INSERT_ID() AS id FROM adm_pages");	
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Все статьи автора','magazine_author','".$page_id_avt_dop[0][id]."',1)");
		   $page_id_avt=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");	  
//      Индекс рубрик		   
           $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Индекс рубрик','magazine_rubric_all','".$page_id_magazine0[0][id]."',1)");
		   $page_id_rubric_index=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");  
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Дополнительные страницы','0','".$page_id_rubric_index[0][id]."',0)");
		   $page_id_rubric_dop=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Статья в рубрике','magazine_rubric','".$page_id_rubric_dop[0][id]."',1)");
		   $page_id_rubric=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");	
// Ежегодные оглавления
		   $DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Ежегодное оглавление','magazine_spisok_year','".$page_id_magazine0[0][id]."',1)");
		    $page_id_author_year=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");  
			$DB->query("INSERT INTO  adm_pages (page_name,page_template,page_parent,page_status)
		   VALUES ('Статьи за год','magazine_rubric_all','".$page_id_magazine0[0][id]."',1)");
		    $page_id_years=$DB->select("SELECT LAST_INSERT_ID() AS id FROM adm_pages");  
//      Проставить ссылки на страницы  	
           $DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric[0][id].",'RUBRIC_ID',".$page_id_rubric[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric[0][id].",'PERSONA_ID','".$page_id_avt[0][id]."')");
			
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric_index[0][id].",'RUBRIC_ID',".$page_id_rubric[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric_index[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric_index[0][id].",'PERSONA_ID','".$page_id_avt[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric_index[0][id].",'PERSONA_ID','".$page_id_content[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_rubric_index[0][id].",'SHORT_LIST',1)");

			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt[0][id].",'RUBRIC_ID',".$page_id_rubric[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt_index[0][id].",'RUBRIC_ID',".$page_id_rubric[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt_index[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt_index[0][id].",'CONTENT_ID',".$page_id_content[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_avt_index[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_full[0][id].",'FULL_ID',".$page_id_magazine[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_full[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_full[0][id].",'ITYPE_JOUR',".$jid[0]['id'].")");	
           
            			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'ITYPE_JOUR',".$jid[0]['id'].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'RUBRIC_ID',".$page_id_rubric_index[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'CONTENT_ID',".$page_id_content[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'NUMBER_ID',".$page_id_content[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_article[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_content[0][id].",'RUBRIC_ID',".$page_id_rubric_index[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_content[0][id].",'ARTICLE_ID',".$page_id_article[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_content[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_archive[0][id].",'NUMBER_ID',".$page_id_content[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_archive[0][id].",'RUBRIC_ID',".$page_id_rubric[0][id].")");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_archive[0][id].",'PERSONA_ID',".$page_id_avt[0][id].")");	

			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'ITYPE_JOUR','".$jid[0]['id']."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'FULL_ID','".$page_id_full[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'RUBRIC_ID','".$page_id_rubric[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'RUBRICS_ID','".$page_id_rubric_index[0][id]."')"); 
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'AUTHOR_ID','".$page_id_avt[0][id]."')");  
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'AUTHORS_ID','".$page_id_avt_index[0][id]."')");  
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'SUMMARY_ID','".$page_id_content[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'ARTICLE_ID','".$page_id_article[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
			 VALUES(".$page_id_magazine[0][id].",'ARCHIVE_ID','".$page_id_archive[0][id]."')"); 

			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_magazine[0][id].",'YEARS_ID','".$page_id_years[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES(".$page_id_magazine[0][id].",'AUTORS_YEARS_ID','".$page_id_author_year[0][id]."')");
		
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_author_year[0][id]."','ARTICLE_ID','".$page_id_article[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_author_year[0][id]."','RUBRIC_ID','".$page_id_rubric[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_author_year[0][id]."','PERSONA_ID','".$page_id_avt[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_author_year[0][id]."','CONTENT_ID','".$page_id_content[0][id]."')");		
			
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_years[0][id]."','ARTICLE_ID','".$page_id_article[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_years[0][id]."','RUBRIC_ID','".$page_id_rubric[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_years[0][id]."','PERSONA_ID','".$page_id_avt[0][id]."')");
			$DB->query("INSERT INTO  adm_pages_content (page_id,cv_name,cv_text)
            VALUES('".$page_id_years[0][id]."','CONTENT_ID','".$page_id_content[0][id]."')");
// Создать запись в статьях
            $DB->query("INSERT INTO  adm_article (page_name,date,journal,j_name,page_status,year)
			 VALUES('".$query[page_name]."','".date("Ymd")."',".$jid[0]['id'].",'".$query[page_name]."',1,'".date("Y")."')"); 			
	 }  
   }
  // $DB->select("SELECT * FROM aaa");

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}


?>