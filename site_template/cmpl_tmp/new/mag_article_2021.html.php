<?
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
global $DB,$_CONFIG, $site_templater;

$_GET['id'] = $_REQUEST['article_id'];
$_REQUEST['id'] = $_REQUEST['article_id'];

$id_news=(int)$_GET['id'];
$all_views = 0;

if(!empty($id_news)) {
	$eng_stat = "";
	if($_SESSION["lang"]=="/en")
		$eng_stat = "-en";
	//Statistic::theCounter("magarticle-".$id_news.$eng_stat);
	$all_views = Statistic::getAllViews("magarticle-".$id_news.$eng_stat);
}


if ($_SESSION["lang"]=='/en')
{
	$suff='';
	$txt1="No ";
    if($_TPL_REPLACMENT["MAIN_JOUR_ID"]!=1669) {
        $txt1="no. ";
    }
	$txt2='Rubric';
	$txt3= 'download free';
	$txt4='Contents ';
	$suff2="_en";
	$txtpage="P.";
	$ppages="pp.";
	$aboutAuthorText = "About author";
}
else
{
	$suff='';$suff2="";
	$txt1="� ";$txt2='�������';$txt3='������� ���������';$txt4='���������� ������ ';
	$txtpage="�.";
	$ppages="��.";
	$aboutAuthorText = "�� ������";
}
//print_r($_REQUEST);

$pg=new MagazineNew();
if (!empty($_SESSION["jour_id"]))
{
	$_REQUEST["jid"]=$_SESSION["jour_id"];
	$_REQUEST["jj"]=$_SESSION["jour_id"];
}
if (empty($_REQUEST["jid"])) //����� ������ ����� �������
{

	$jid0=$pg->getLastMagazineNumber($_TPL_REPLACMENT["MAIN_JOUR_ID"]);

	$_REQUEST["jid"]=$jid0[0]["page_id"];
	$_REQUEST["jj"]=$jid0[0]["journal_new"];

}
$_REQUEST["id"] = (int)$_REQUEST["id"];
$_REQUEST["jid"] = (int)$_REQUEST["jid"];
$_REQUEST["jj"] = (int)$_REQUEST["jj"];
$jour0=$pg->getMagazineByArticleId($_REQUEST["article_id"],null,null,null,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);
//print_r($jour0);




$rows=$DB->select("SELECT  name AS title,name_en AS title_en,CONCAT('".$txt1." ',number,', ',year) AS jname, CONCAT(number,', ',year) AS jname_cut, number AS number, name_black, name_black_en 
   FROM adm_article WHERE  page_id=".(int)$_REQUEST["id"]);


if($_TPL_REPLACMENT["MAIN_JOUR_ID"]==1665)
	if(!is_numeric(substr($rows[0]["number"], 0, 1)))
	{
		if($_SESSION["lang"]!="/en")
			$rows[0]["jname"]=$rows[0]["jname_cut"];
		else
			$rows[0]["jname"]=str_replace("���������", "Yearbook", $rows[0]["jname_cut"]);
	}
//print_r($rows);
$_REQUEST["jid"]=(int)$jour0[0]["page_id"];
$_REQUEST["jj"]=(int)$jour0[0]["journal_new"];

$numberId = $pg->getNumberIdByArticleId($_REQUEST["article_id"],null,null,null,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);

$numberContent = $pg->getArticleContentByPageId($numberId);
//print_r($rows);
if ($_SESSION["lang"]!='/en')
{
	$jname=$txt1.$jour0[0]["page_name"].", ".$jour0[0]["year"];
	$title=$rows[0]["jname"];
}
else
{

	$jname=$txt1.$rows[0]["title_en"].", ".$jour0[0]["year"];
	$title=$rows[0]["jname"];
}
//print_r($rows);
$art_title=$rows[0]["title"];
$art_title_en=$rows[0]["title_en"];
if(!empty($rows[0]["name_black"])) {
	$rows[0]["title"] = str_replace($rows[0]["name_black"],"<span style=\"border: 1px solid black; padding: 0 3px;\">".$rows[0]["name_black"]."</span>",$rows[0]["title"]);
}
if(!empty($rows[0]["name_black_en"])) {
	$rows[0]["title_en"] = str_replace($rows[0]["name_black_en"],"<span style=\"border: 1px solid black; padding: 0 3px;\">".$rows[0]["name_black_en"]."</span>",$rows[0]["title_en"]);
}
$site_templater->appendValues(array("TITLE" => $rows[0]["title"]));
$site_templater->appendValues(array("TITLE_EN" => $rows[0]["title_en"]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if(!empty($id_news)) {
	Statistic::ajaxCounter("magarticle", $id_news);
	Statistic::getAjaxViews("magarticle", $id_news);
}

echo "<div style='text-align: right; color: #979797;'><img alt='' width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";

$rowas=$pg->getArticleById($_REQUEST["id"]);
//  print_r($rowas);
if (!empty($rowas[0]["page_parent"]))
{
	$rowrs=$DB->select("SELECT page_id, IFNULL(name,page_name) AS rubric,name_en AS rubric_en ".
		// cv_text AS rubric FROM adm_article_content  AS pc
		" FROM adm_article ".
		" WHERE  page_id=".$rowas[0]["page_parent"]." AND page_status=1 AND page_template='jrubric'"  ); //." AND cv_name='rubric".$suff2."'");

	$rowj=$DB->select("SELECT page_id,page_name AS journal,page_name_en AS journal_en FROM adm_pages WHERE page_id=".(int)$_REQUEST["jj"]);
}
foreach($rowas as $k=>$row)
{
//print_r($row);echo "name".$suff2." ".$row[name.$suff2];
	echo "<div class='jarticle'>";
	if (!isset($_REQUEST["en"]))
	{
		$people0=$pg->getAutors($row["people"]);
		$avtbib=$pg->getAutorsBib($row["people"]);
	}
	else
	{
		$secondField = false;
		if($_REQUEST['jj']==1669) {
			$secondField = true;
		}
		$people0=$pg->getAutorsEn($row['people'],$secondField);
		$avtbib=$pg->getAutorsBibEN($row["people"]);

	}
	$autorBuilder = new AuthorBuilder($people0, $_TPL_REPLACMENT["AUTHOR_ID"], $_SESSION['lang']);
	echo "<div class='autors_a mb-3'>";
		$autorBuilder->processAuthors();
		$autorBuilder->echoAuthors($row);
		$avt_list_short = $autorBuilder->getAvtListShort();
	echo "</div>";
	if($_SESSION["lang"]=="/en"){
		$row["number"]=str_replace("���������", "Yearbook", $row["number"]);
		if(!empty($row["number_en"]))
			$row["number"]=$row["number_en"];
	}

//	if(!empty($row['organization_name'.$suff2])) {
//		echo "<div>".$row['organization_name'.$suff2]."</div><br />";
//	}

	if($_REQUEST["jj"]!=1614) {
		$vol_pos = strripos($row["number"], "�.");
		if ($vol_pos === false) {
			if ($_REQUEST["jj"] == 1665 || $_REQUEST["jj"]  == 1668) {
				if (is_numeric(substr($row["number"], 0, 1)))
					echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $txt1 . " " . $row["number"];
				else
					echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $row["number"];
			} elseif ($_REQUEST["jj"] == 1667)
				echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"];
			else
				echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $txt1 . " " . $row["number"];
		} else {
			$volume = substr($row["number"], $vol_pos);
			if ($_SESSION["lang"] == '/en')
				$volume = str_replace("�.", "Vol.", $volume);
			else
				$volume = str_replace("�.", "�.", $volume);
			$number = spliti(",", $row["number"]);
			if ($_REQUEST["jj"] == 1665 || $_REQUEST["jj"]  == 1668) {
				if (is_numeric(substr($row["number"], 0, 1)))
					echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $volume . ", " . $txt1 . " " . $number[0];
				else
					echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $row["number"];
			} else
				echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $volume . ", " . $txt1 . " " . $number[0];
		}

		if ($_SESSION["lang"] == "/en")
			$row["number"] = str_replace("�.", "vol.", $row["number"]);
		if (empty($volume)) {
			if ($_REQUEST["jj"] == 1665 || $_REQUEST["jj"]  == 1668) {
				if (is_numeric(substr($row["number"], 0, 1)))
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $txt1 . " " . $row["number"];
				else
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $row["number"];
			} else {
				if ($_REQUEST["jj"] == 1667)
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"];
				elseif ($_REQUEST["jj"] != 1672)
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $txt1 . " " . $row["number"];
				else
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $txt1 . " " . $row["number"] . ", " . $row["year"];
			}
		} else {
			if ($_REQUEST["jj"] == 1665 || $_REQUEST["jj"]  == 1668) {
				if (is_numeric(substr($row["number"], 0, 1)))
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $volume . ", " . $txt1 . " " . $number[0];
				else
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $row["number"];
			} else {
				if ($_REQUEST["jj"] != 1672)
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $volume . ", " . $txt1 . " " . $number[0];
				else
					$jourissue = $rowj[0]['journal' . $suff2] . ". " . $row["year"] . ". " . $volume . ", " . $txt1 . " " . $number[0];
			}
		}
		$issuename = $rowj[0]['journal' . $suff2];
		$issueyear = $row["year"];
		$issuenumber = $row["number"];
		if (!empty($row["pages"]))
			echo ". " . $txtpage . " " . $row["pages"];
		echo "</div>";
	}
	else
	{
		$vol_pos = strripos($row["number"], "�.");
		if($vol_pos !== false) {
			$volume = substr($row["number"], $vol_pos);
			if ($_SESSION["lang"] == '/en')
				$volume = str_replace("�.", "Vol.", $volume);
			else
				$volume = str_replace("�.", "�.", $volume);
			$number = spliti(",", $row["number"]);
		}
		if ($_SESSION["lang"] != '/en') {
			if (empty($volume)) {
				$jourissue = $rowj[0]['journal' . $suff] . ". " . $row["year"] . ", " . $txt1 . " " . $row["number"];
			}
			else {
				$jourissue = $rowj[0]['journal' . $suff] . ". " . $row["year"] . ", " . $number[1] . ", " . $txt1 . " " . $number[0];
			}
		} else {
			if (empty($volume)) {
				$jourissue = $rowj[0]['journal_en'] . ". " . $row["year"] . ", " . $txt1 . " " . str_replace("�.", "vol.", $row["number"]);
			}
			else {
				$jourissue = $rowj[0]['journal_en'] . ". " . $row["year"] . ", " . str_replace("�.", "vol.", $number[1]) . ", " . $txt1 . " " . $number[0];
			}
		}

	}

	$doiText = "";
	$ednText = "";
	if (!empty($row["doi"]))
		$doiText = "DOI: ".$row["doi"];
	if (!empty($row["edn"]))
        $ednText = "EDN: <a target='_blank' href=\"https://elibrary.ru/{$row["edn"]}\">{$row["edn"]}</a>";
	?>
	<div class="jrubric_a mb-3">
		<div class="row">
			<div class="col-12 col-xl"><?=$doiText?></div>
			<div class="col-12 col-xl text-xl-right"><?=$ednText?></div>
		</div>
	</div>
	<?php

	if (!empty($rowrs[0]["rubric"]) && $rowrs[0]["rubric"]!='1')
		echo "<div class='jrubric_a mb-3'>".
			$txt2.": <a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"].
			"&article_id=".$rowrs[0]["page_id"].
			">".$rowrs[0]['rubric'.$suff2]."</a>".

			"</div>";

	if($_SESSION['lang']!="/en") {
		if(!empty($row['published_date_text'])) {
			echo $row['published_date_text'];
		}
	} else {
		if(!empty($row['published_date_text_en'])) {
			echo $row['published_date_text_en'];
		}
	}

	if (!empty($row["annots"]) && $row["annots"]!='<p>&nbsp;</p>' && $_SESSION["lang"]!='/en')
	{
		if (!empty($row["annots"]) && $row["annots"]!='<p>&nbsp;</p>')
		{
			//echo "<div class='jrubric_a'><b>���������</b></div>";
			$row["annots"] = preg_replace_callback('/<(?:p|(?:div)).*>/U', function ($matches) {
				return $matches[0] . '<b>���������.</b> ';
			}, $row['annots'], 1);

			echo "<div class='annot_text text-justify font-italic'>".$row["annots"]."</div>";
		}
	}

	if (!empty($row["annots_en"]) && $row["annots_en"]!='<p>&nbsp;</p>' && $_SESSION["lang"]=='/en')
	{
		if (!empty($row["annots_en"]) && $row["annots_en"]!='<p>&nbsp;</p>') {
			$row["annots_en"] = preg_replace_callback('/<(?:p|(?:div)).*>/U', function ($matches) {
				return $matches[0] . '<b>Abstract.</b> ';
			}, $row['annots_en'], 1);
		}
		//if (!empty($row["annots_en"]) && $row["annots_en"]!='<p>&nbsp;</p>') echo "<br /><div class='jrubric_a'><b>Abstract</b></div>";

		if (strpos($row["annots_en"], '<p style="text-align: center;">REFERENCES</p>') !== false) {
			echo "<div class='annot_text text-justify'>".substr($row["annots_en"], 0, strpos($row["annots_en"], '<p style="text-align: center;">REFERENCES</p>'))."</div><br>";
		}
		else
			echo "<div class='annot_text text-justify font-italic'>".$row["annots_en"]."</div>";
	}
	if (!empty($row["add_text"]) && $row["add_text"]!='<p>&nbsp;</p>' && $_SESSION["lang"]!='/en')
	{
		echo "<div class='text-justify'>".$row["add_text"]."</div><br />";
	}
	if (!empty($row["add_text_en"]) && $row["add_text_en"]!='<p>&nbsp;</p>' && $_SESSION["lang"]=='/en')
	{
		echo "<div class='text-justify'>".$row["add_text_en"]."</div><br />";
	}
	//    if (!empty($row["keyword"]) || ! empty($row["keyword_en"]))
	//   {
	if (!empty($row["keyword"]) && $row["keyword"]!='<p>&nbsp;</p>' && $_SESSION["lang"]!='/en')
	{
		$row["keyword"] = preg_replace_callback('/<(?:p|(?:div)).*>/U', function ($matches) {
			return $matches[0] . '<b>�������� �����:</b> ';
		}, $row['keyword'], 1);
		//echo "<div class='jrubric_a'><b>�������� �����</b></div>";
		echo "<div class='annot_text font-italic'>".$row["keyword"]."</div><br />";
	}
	if (!empty($row["keyword_en"]) && $row["keyword_en"]!='<p>&nbsp;</p>' && $_SESSION["lang"]=='/en')
	{
		if(!empty($row["keyword_en"]) && $row["keyword_en"]!='<p>&nbsp;</p>') {
			$row["keyword_en"] = preg_replace_callback('/<(?:p|(?:div)).*>/U', function ($matches) {
				return $matches[0] . '<b>Keywords:</b> ';
			}, $row['keyword_en'], 1);
		}
		//if (!empty($row["keyword_en"]) && $row["keyword_en"]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Keywords</b></div>";
		echo "<div class='annot_text font-italic'>".$row["keyword_en"]."</div><br />";
	}

	if(!empty($row['affiliation'.$suff2]) && $row['affiliation'.$suff2]!="<p>&nbsp;</p>") {
		echo "<div class='jrubric_a'><b>{$aboutAuthorText}</b></div>";
		echo "<div>".$row['affiliation'.$suff2]."</div><br />";
	}



	if (!empty($row["contents"]) && $_SESSION["lang"]!='/en' && $row["contents"]!="<p>&nbsp;</p>")
	{

		//   if (!empty($row["contents"]) && $row["contents"]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>���������</b></div>";
		echo "<div class='annot_text'>".$row["contents"]."</div><br />";
	}
	if (!empty($row["contents_en"]) && $_SESSION["lang"]=='/en' && $row["contents_en"]!="<p>&nbsp;</p>")
	{

		//   if (!empty($row["contents"]) && $row["contents"]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>���������</b></div>";
		echo "<div class='annot_text'>".$row["contents_en"]."</div><br />";
	}

    if (!empty($row["references"]) && $_SESSION["lang"]!='/en' && $row["references"]!="<p>&nbsp;</p>")
    {
        ?>
        <p style="text-align: center;">������ ����������</p>
        <?php
        //   if (!empty($row["contents"]) && $row["contents"]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>���������</b></div>";
        echo "<div class='annot_text'>".$row["references"]."</div><br />";
    }
    if (!empty($row["references_en"]) && $_SESSION["lang"]=='/en' && $row["references_en"]!="<p>&nbsp;</p>")
    {
        ?>
        <p style="text-align: center;">REFERENCES</p>
        <?php
        //   if (!empty($row["contents"]) && $row["contents"]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>���������</b></div>";
        echo "<div class='annot_text'>".$row["references_en"]."</div><br />";
    }

    if (!empty($row["sources"]) && $_SESSION["lang"]!='/en' && $row["sources"]!="<p>&nbsp;</p>")
    {
        ?>
        <p style="text-align: center;">������ ���������</p>
        <?php
        echo "<div class='annot_text'>".$row["sources"]."</div><br />";
    }
    if (!empty($row["sources_en"]) && $_SESSION["lang"]=='/en' && $row["sources_en"]!="<p>&nbsp;</p>")
    {
        ?>
        <p style="text-align: center;">SOURCES</p>
        <?php
        echo "<div class='annot_text'>".$row["sources_en"]."</div><br />";
    }

	if (!empty($row["annots_en"]) && isset($_REQUEST["en"])) {
		if (strpos($row["annots_en"], '<p style="text-align: center;">REFERENCES</p>') !== false) {
			echo "<div class='annot_text'>".substr($row["annots_en"], strpos($row["annots_en"], '<p style="text-align: center;">REFERENCES</p>'))."</div><br />";
		}
	}
	//         }

/////////

	if (strpos($row['link'],'href=',0) >0)
	{

		/* if(strpos($row['link'],"http:")==0)
        {
          $row['link']=str_replace("/files/File/","http://".$_SERVER["HTTP_HOST"]."/files/File/",$row['link']);

        }
         if(strpos($row['link_en'],"http:")==0)
        {
          $row['link_en']=str_replace("/files/File/","http://".$_SERVER["HTTP_HOST"]."/files/File/",$row['link_en']);

        }*/

		if(strpos($row['link'],"https:")==0 && strpos($row['link'],"http:")==0)
		{
			$row['link']=str_replace("/files/File/","https://".$_SERVER["HTTP_HOST"]."/files/File/",$row['link']);

		}
		if(strpos($row['link_en'],"https:")==0 && strpos($row['link'],"http:")==0)
		{
			$row['link_en']=str_replace("/files/File/","https://".$_SERVER["HTTP_HOST"]."/files/File/",$row['link_en']);

		}
		$filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";

		preg_match_all($filter,$row['link'],$res);
		//  print_r($res); echo "<br />";echo "<br />";
		$script_download = "";
		if($_REQUEST["jj"]==1614) {
			$script_download = "&script_download=1";
		}
		//  echo $res[0][0]." ".count($res)."**";
		for($i=0;$i<=count($res);$i++)
		{
			$row['link']=str_replace($res[0][$i],$_SESSION["lang"]."/index.php?page_id=647&module=article&id=".$_REQUEST["id"].$script_download."&param=".str_replace(' ','^',$res[0][$i]),$row['link']);
		}

		preg_match_all($filter,$row['link_en'],$res_en);
		//  print_r($res); echo "<br />";echo "<br />";
		//  echo $res[0][0]." ".count($res)."**";
		for($i=0;$i<=count($res_en);$i++)
		{
			$row['link_en']=str_replace($res_en[0][$i],$_SESSION["lang"]."/index.php?page_id=647&module=article&id=".$_REQUEST["id"].$script_download."&param=".str_replace(' ','^',$res_en[0][$i]),$row['link_en']);
		}


//   echo $row['link'];
		if($_REQUEST["jj"]!=1614) {
			if($_SESSION["lang"]=="/en") {
				if(!empty($row['link_en']) && $row['link_en']!='<p>&nbsp;</p>')
					$link_text=$row['link_en'];
				else
					$link_text=str_replace('�����','Text',str_replace("����� ������", "Text", $row['link']));
			}
			else
				$link_text=$row['link'];

			echo "<div class='mb-3'><div class='jrubric_a'>".str_replace("<a ","<i class=\"far fa-file-pdf text-danger\"></i> <a title='".$txt3."' ",$link_text)."</div></div>";
		}
		else
		{
			if(($_SESSION['meimo_authorization']==1) || $row['fulltext_open']==1 || $numberContent['FULL_TEXT_OPEN']==1) {
				if($_SESSION["lang"]=="/en") {
					if(!empty($row['link_en']) && $row['link_en']!='<p>&nbsp;</p>')
						$link_text=$row['link_en'];
					else
						$link_text=str_replace('�����','Text',str_replace("����� ������", "Text", $row['link']));
				}
				else
					$link_text=$row['link'];

				echo "<div class='mb-3'><div class='jrubric_a'>".str_replace("<a ","<i class=\"far fa-file-pdf text-danger\"></i> <a title='".$txt3."' ",$link_text)."</div></div>";
			}
		}
	}
//////////

	////////////
	if (!empty($row["rinc"]))
	{
		if($_SESSION["lang"]!='/en')
			echo "<a href=".$row["rinc"].">��������� � ����</a><br><br>";
		else echo "<a href=".$row["rinc"].">Registered in System SCIENCE INDEX</a><br><br>";
	}
	//if (empty($row["annots"]) && !empty($row['contents'])) echo $row["contents"];

	if($row['name'] == $row['name_en'] && $_SESSION['lang'] != '/en') {
		$_SESSION['lang'] = "/en";
		$people0=$pg->getAutorsEn($row["people"]);
		$autorBuilderEn = new AuthorBuilder($people0, $_TPL_REPLACMENT["AUTHOR_ID"], $_SESSION['lang'], false);
		$autorBuilderEn->processAuthors();
		$avt_list_short = $autorBuilderEn->getAvtListShort();
		$_SESSION['lang'] = "";
	}

	///////////
	if ($_SESSION["lang"]!='/en')
	{
        if(!empty($row['citation_authors_correct'])) {
            $avt_list_short = $row['citation_authors_correct'];
        }

		// print_r($rowj);
		echo "<div style='padding:2px;border:1px solid #EEE9E9;background-color:#EEE9E9;'> ������ ��� �����������: <br /><br />";
		echo "<h6 style='font-weight: bold'>"."";
		if($_REQUEST["jj"]==1665 || $_REQUEST["jj"]==1668) {
			if(is_numeric(substr($row["number"], 0,1)))
				echo $avt_list_short." ".$art_title.". ".$rowj[0]['journal'.$suff].". � ". $row["year"].". � ".$txt1." ".$row["number"];
			else
				echo $avt_list_short." ".$art_title.". ".$rowj[0]['journal'.$suff].". � ". $row["year"];
		} elseif($_REQUEST["jj"]==1673) {

			echo $avt_list_short." ".ltrim(ltrim($art_title,"1234567890.")," ").". <i>".str_replace(" (�����������)","",$rowj[0]['journal'.$suff])."</i>, ". $row["year"].", ".$txt1." ".$row["number"];
		}
		else {
			if(empty($volume)) {
				if($_REQUEST["jj"]==1667)
					echo $avt_list_short." ".$art_title." // ".$rowj[0]['journal'.$suff].". ". $row["year"];
				else
					echo $avt_list_short." ".$art_title." // ".$rowj[0]['journal'.$suff].". ". $row["year"].". ".$txt1." ".$row["number"];
			}
			else
				echo $avt_list_short." ".$art_title." // ".$rowj[0]['journal'.$suff].". ". $row["year"].". ".$number[1].", ".$txt1." ".$number[0];
		}
		if (!empty($row["pages"]))
			echo ". ".$txtpage." ".$row["pages"];
		if (!empty($row["doi"])) echo ". <a href=\"https://doi.org/".$row["doi"]."\">https://doi.org/".$row["doi"]."</a>";
        if(!empty($ednText)) echo "     ".$ednText;
		echo  "</h6></div><br />";
	}
	else
	{
        if(!empty($row['citation_authors_correct_en'])) {
            $avt_list_short = $row['citation_authors_correct_en'];
        }

		echo "<div style='padding:2px;border:1px solid #EEE9E9;background-color:#EEE9E9;'> For citation: <br />";
		echo "<h6 style='font-weight: bold'>"."";
		if($_REQUEST["jj"]==1665 || $_REQUEST["jj"]==1668) {
			if(is_numeric(substr($row["number"], 0,1)))
				echo $avt_list_short." ".$art_title_en.". ".$rowj[0]['journal_en'].". � ". $row["year"].". � ".$txt1." ".str_replace("�.","vol.",$row["number"]);
			else
				echo $avt_list_short." ".$art_title_en.". ".$rowj[0]['journal_en'].". � ". $row["year"];
		}
		elseif($_REQUEST["jj"]==1673) {

			echo $avt_list_short." ".ltrim(ltrim($art_title_en,"1234567890.")," ").". <i>".$rowj[0]['journal_en']."</i>, ". $row["year"];
		}
		else {
			if(empty($volume)){
				if($_REQUEST["jj"]==1667)
					echo $avt_list_short." ".$art_title_en." // ".$rowj[0]['journal_en'].". ". $row["year"];
				else
					echo $avt_list_short." ".$art_title_en." // ".$rowj[0]['journal_en'].". ". $row["year"].". ".$txt1." ".str_replace("�.","vol.",$row["number"]);
			}
			else
				echo $avt_list_short." ".$art_title_en." // ".$rowj[0]['journal_en'].". ". $row["year"].". ".str_replace("�.","vol.",$number[1]).", ".$txt1." ".$number[0];
		}
		if (!empty($row["pages"]))
			echo ". ".$txtpage." ".$row["pages"];
		if (!empty($row["doi"])) echo ". <a href=\"https://doi.org/".$row["doi"]."\">https://doi.org/".$row["doi"]."</a>";
        if(!empty($ednText)) echo "     ".$ednText;
		echo  "</h6></div><br />";


	}




	echo "</div>";
	$jidcurr=$row["jid"];

}

if(!empty($jourissue) && $jourissue!='<p>&nbsp;</p>') {
	echo "<hr />";
	echo "<div class='jrubric'>";
//  print_r($_REQUEST["jid"]);
	echo $txt4;
	echo "<a style='text-decoration:underline;' href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $numberId . $suff . ">" .
		$jourissue . "</a>";
	echo "</div>";
}

echo "<br clear='all'>";
$row["jtitle"]=$jour0[0]['page_name'.$suff2];
$row["number"]=$issuenumber;//$jour0[0]['page_name'];
$row["issn"]=$jour0[0]["issn"];
$row["year"]=$jour0[0]["year"];
$row["issue"]=$jour0[0]['page_name'];
$row["vid"]=2;
$bib=new BibEntry();
$aa=$bib->toCoinsMySQL($row,$avtbib);
print_r($aa);
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
