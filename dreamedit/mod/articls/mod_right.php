<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";

if ($_ACTIVE[action]=="index")
{
	echo "<h1>Правила ввода</h1>";
	echo "<div id='right' style='display:block;'>";
	echo "<b>Ввод года:</b><br />
   <li>Использовать «бочонок с плюсом»</li>
   <li>Использовать шаблон «Нет шаблона»</li>
   <li>Проставить номер года в полях «Номер журнала» и «Год»</li>
   <br /><br />
   <b>Номер журнала</b><br />
   <li>Использовать «бочонок с плюсом»</li>
   <li>Использовать шаблон «Журнал. Номер журнала»</li>
   <br /><br />
   <b>Рубрика</b><br />
   <li>Использовать «бочонок с сеточкой»</li>
   <li>Использовать шаблон «Журнал. Рубрика»</li>
   <br /><br />
   <b>Статья</b><br />
   <li>Использовать «бочонок с рулончиком»</li>
   <li>Использовать шаблон «Журнал. Статья»</li>
   ";
}

if($_ACTIVE["action"] == "add")
{
	include_once "formNumber.php";

}

if($_ACTIVE["action"] == "addEl" || $_ACTIVE["action"] == "addArt" )
{
	include_once "form.php";
}
if($_ACTIVE["action"] == "addEl" || $_ACTIVE["action"] == "addRb" )
{

	include_once "formNumber.php";

}
if($_ACTIVE["action"] == "addArt2021" )
{
	include_once "form_2021.php";
}
$phorm = new mod_phorm($mod_array);


if($_ACTIVE["action"] == "add" || $_ACTIVE["action"] == "addEl" || $_ACTIVE["action"] == "addArt" || $_ACTIVE["action"] == "addRb" || $_ACTIVE["action"] == "addArt2021")
{

	$phorm->display();
}


if($_ACTIVE["action"] == "edit")
{
	// рисуем вспомогательное дерево страниц

	// отображение вспомогательного дерева
//	echo "<div class=\"subtree\">";
//	$pg = new Article();
	// вытаскиваем все страницы




//	$rows = $pg->getLinkedPages($_REQUEST["id"]);

//	$elementLink = "http://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";

//	$tree = new WriteTree("subD", Dreamedit::createTreeArrayFromPages($rows, $elementLink));
//	$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
//	$tree->displayTree(Dreamedit::translate("Структура ссылок"));
//	$tree->openTreeTo((int)@$_REQUEST["id"]);

//	echo "<script>subD.openAll()</script>";
//	echo "</div>";

	// заполняем поля формы
	$data = array();
	$row = $pg->getPageById($_REQUEST["id"]);

	switch ($row['page_template']) {
		case 'jarticle':
			if($row['article_special_template']=="mag_article_2021") {
				include_once "form_2021.php";
			} else {
				include_once "form.php";
			}

			break;
		default:
			include_once "formNumber.php";
	}

	$phorm = new mod_phorm($mod_array);




	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$tmp = $row[$v["field"]];
		$data[$k] = $tmp;
	}
	// заполняем поля формы относящиеся к контенту
	if(empty($row["page_link"]) && !empty($row["page_template"]) && $row["page_template"]!='jrubric')
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsm.".$row["page_template"].".php";
		$phorm->add_comps($tpl_vars);
		$cv = $DB->select("SELECT ?_article_content.*, ?_article_content.cv_name AS ARRAY_KEY FROM ?_article_content  WHERE page_id = ?d", $_REQUEST["id"]);
		foreach($tpl_vars as $k => $v)
		{
			if(isset($v["field"]))
				$data[$k] = @$cv[strtoupper($v["field"])]["cv_text"];
		}
	}

//echo "pfgjkybkb ajhve";
	$phorm->mod_phorm_values($data);

	$phorm->display();

}



if($_ACTIVE["action"] == "save")
{

// print_r($_POST);

	switch ($_POST['template']) {
		case 'jarticle':
			include_once "form.php";
			break;
		case 'jarticle_2021':
			include_once "form_2021.php";
			break;
		default:
			include_once "formNumber.php";
	}

	$phorm = new mod_phorm($mod_array);


	// если сохраняем сортировку
	if(isset($_REQUEST["sort"]))
	{
		$pagePosition = explode("|", $_REQUEST["list-sortPage"]);

		foreach($pagePosition as $position => $id)
			$DB->query("UPDATE ?_article SET page_position = ?d WHERE  page_id = ?d", $position, $id);

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["sort"]);
	}


	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsm.".$_REQUEST["template"].".php";
		$phorm->add_comps($tpl_vars);
	}

	$phorm->mod_phorm_values($_REQUEST);
//print_r($phorm);

	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}


	include_once "save_action.php";

}



if($_ACTIVE["action"] == "sort")
{
	include $_CONFIG["global"]["paths"]["admin_path"]."includes/list-sorting/sorting.inc.php";

	if(isset($_POST["order"]))
	{
		$pages_position = explode("|", $_REQUEST["order"]);

		foreach($pages_position as $k => $v)
			$DB->query("UPDATE ?_magazine SET page_position = ?d WHERE page_id = ?d", $k, $v);

		$cacheEngine = new CacheEngine();
		$cacheEngine->reset();

		Dreamedit::sendLocationHeader("https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_REQUEST["mod"] . "&action=view&id=" . $_REQUEST["id"]);
	}

	$sortRes = $DB->select("SELECT * FROM ?_article WHERE page_parent = ?d ORDER BY page_position ASC, page_name ASC", $_REQUEST["id"]);
	$sortArr = array();
	foreach($sortRes as $v) {
		if ($v[page_template]=='jnumber') {
			$sortArr[$v["page_id"]] = str_replace("Мировая экономика и международные отношения", "МЭиМО", $v['j_name'])."-".$v["year"]."-".$v["page_name"];
		}
		else
			$sortArr[$v["page_id"]] = $v["page_name"];
	}

	echo "<form method=\"POST\" action=\"\" id=\"data_form\">\n";
	echo "<input type=\"hidden\" name=\"sort\" value=\"".$_REQUEST["id"]."\" />";
	listSorting("sortPage", $sortArr);
	echo "</form>";
}


if($_ACTIVE["action"] == "del")
{


//	$link_count = $DB->selectCell("SELECT COUNT(*) FROM ?_article WHERE page_link = ?d", $_REQUEST["id"]);
	if($link_count > 0 && !isset($_REQUEST["del_type"]))
	{
		echo "<script>\n";
		echo "var type = confirm('".Dreamedit::translate("На содержимое удаляемой страницы ссылается ".$link_count." страниц. Вы желаете удалитьх их все?")."');\n";
		echo "window.location.href += '&del_type=' + type;\n";
		echo "</script>\n";
		return;
	}

	if(isset($_REQUEST["del_type"]))
	{
		if($_REQUEST["del_type"] == "true")
		{
			$DB->query("DELETE FROM ?_article WHERE page_link = ?d", $_REQUEST["id"]);
			$DB->query("DELETE FROM ?_article_content WHERE page_id = ?d", $_REQUEST["id"]);
		}
		else
		{
			$rand_link = $DB->selectCell("SELECT page_id FROM ?_article WHERE page_link = ?d LIMIT 1", $_REQUEST["id"]);
			//		$DB->query("UPDATE ?_article SET page_link = '' WHERE page_id = ?d", $rand_link);
			$DB->query("UPDATE ?_article_content SET page_id = ?d WHERE page_id = ?d", $rand_link, $_REQUEST["id"]);
			//		$DB->query("UPDATE ?_article SET page_link = ?d WHERE page_link = ?d", $rand_link, $_REQUEST["id"]);
		}
	}

	$pid = $DB->selectCell("SELECT ?_article.page_parent FROM ?_article WHERE page_id = ?d", $_REQUEST["id"]);
	$DB->query("DELETE FROM ?_article WHERE page_id = ?d", $_REQUEST["id"]);

	$cacheEngine = new CacheEngine();
	$cacheEngine->reset();

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$pid);
}


if($_ACTIVE["action"] == "preview")
{
	include_once dirname(__FILE__)."/preview.php";
}
if($_ACTIVE["action"] == "commentsave")
{
	$DB->query("UPDATE comment_txt SET verdict=".$_GET[ch]." WHERE id=".$_GET[idc]);
	$_ACTIVE["action"]="comment";

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_REQUEST[id]);

}
if($_ACTIVE["action"] == "comment")
{

	$mg-new magazine();
	$rows=$mg->getMagazineNumber($_REQUEST[id]);
	$rows=$mg->appendContentArticle($rows);
	$pageid_jour=0;


	echo "<table>";
	foreach($rows as $row)
	{
		echo "<tr>";
		switch($row[page_template])
		{

			case "jnumber":
//      	   echo "<div class='jnumber'>Номер ".$row[page_name]." за ".$row[year]." год</div><br />";
				echo "<td colspan='6'>Тема номера:<br />".substr(substr($row[content][SUBJECT],0,-4),3)."</td>";
				$pageid_jour=$row[page_id];
				break;
			case "jrubric":

				if ($row[page_parent]==$pageid_jour)
					echo "<td colspan='6'><div style='font-size:14px;'><a href=/dreamedit/index.php?mod=articls&action=edit&id=".$row[page_id]."><b>".$row[page_name]."</b></a></div></td>";
				else
					echo "<td colspan='6'><div style='font-size:12px;'><a href=/dreamedit/index.php?mod=articls&action=edit&id=".$row[page_id].">".$row[page_name]."</a></div></td>";

				break;
			case "jarticle" :
//      	   echo "<div >";
				/*
                             $people0=$mg->getAutors($row[people]);
                             echo "<div class='autors'>";
                             foreach($people0 as $people)
                             {
                                if ($people[otdel]!='Умершие сотрудники')
                                  echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>"; //.$people[work].",".$people[mail1]."";
                                else
                                echo "<a style='border:1px solid gray;' href=/index.php?page_id".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>"; //.$people[work].",".$people[mail1]."";
                           }
                             echo "</div>";

                 */
				echo "<td><a title='".$row[name]."' href=/dreamedit/index.php?mod=articls&action=edit&id=".$row[page_id]."><b>".substr($row[page_name],0,40)."</b></a></div></td>";
				if (!empty($row[annots])) echo "<td> A_ru </td>";
				else echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				if (!empty($row[annots_en])) echo "<td> A_en </td>";
				else echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				if (!empty($row[keyword])) echo "<td> K_ru </td>";
				else echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				if (!empty($row[keyword_en])) echo "<td> K_en </td>";
				else echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				if (!empty($row[link])) echo "<td> Link </td>";
				else echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "</tr>";
				//     	  echo "</div>";
				break;
		}

	}

	echo "</table>";
	echo "<br /><br /><b>Список авторов:</b><br />";
	$avt0="";
	foreach($rows as $row)
	{

		$avt0.=$row[people];
	}
	$avtsp=$mg->getAutors($avt0);
	echo "<table>";
	foreach($avtsp as $avt)
	{

		echo "<tr><td>".
			"<a href=/dreamedit/index.php?mod=personal&smbl=Г&oper=show&id=".$avt[id].">".$avt[fio]."</a></td><td>".

			substr($avt[work],0,40)."</td><td>".$avt[mail1]."</td></tr>";


	}
	echo "</table>";
}
?>
