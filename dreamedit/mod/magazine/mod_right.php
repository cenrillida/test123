<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
include_once "form.php";


$phorm = new mod_phorm($mod_array);
if ($_ACTIVE[action]=="index")
{
   echo "<h1>Правила ввода</h1>";
   echo "<div id='right' style='display:block;'>";
   echo "<b>Ввод нового журнала:</b><br />
   <li>Поставить 0 в поле «внутри»</li>
   <li>Использовать шаблон «Нет шаблона»</li>
   <br /><br />
   <b>Информация о журнале</b><br />
   <li>Использовать «бочонок с плюсом»</li>
   <li>Использовать шаблон «Журнал. Текстовая страница журнала»</li>
   <br /><br />
   <b>Вывод «с лица»</b><br />
  Вся необходимая структура создается автоматически в разделе «Журналы»
  
   ";
}
if($_ACTIVE["action"] == "add")
{
	$phorm->display();
}


if($_ACTIVE["action"] == "edit")
{
	// рисуем вспомогательное дерево страниц

	// отображение вспомогательного дерева
	/*echo "<div class=\"subtree\">";
	$pg = new Magazine();
	// вытаскиваем все страницы
	$rows = $pg->getLinkedPages($_REQUEST["id"]);

	$elementLink = "http://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";

	$tree = new WriteTree("subD", Dreamedit::createTreeArrayFromPages($rows, $elementLink));
	$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
	$tree->displayTree(Dreamedit::translate("Структура ссылок"));
	$tree->openTreeTo((int)@$_REQUEST["id"]);

	echo "<script>subD.openAll()</script>";
	echo "</div>";*/

	// заполняем поля формы
	$data = array();
	$row = $pg->getPageById($_REQUEST["id"]);

	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$tmp = $row[$v["field"]];
		$data[$k] = $tmp;
	}

	// заполняем поля формы относящиеся к контенту
	if(empty($row["page_link"]) && !empty($row["page_template"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsm.".$row["page_template"].".php";
		$phorm->add_comps($tpl_vars);
		$cv = $DB->select("SELECT ?_magazine_content.*, ?_magazine_content.cv_name AS ARRAY_KEY FROM ?_magazine_content WHERE page_id = ?d", $_REQUEST["id"]);
		foreach($tpl_vars as $k => $v)
		{
			if(isset($v["field"]))
				$data[$k] = @$cv[strtoupper($v["field"])]["cv_text"];
		}
	}

	$phorm->mod_phorm_values($data);
	$phorm->display();
}



if($_ACTIVE["action"] == "save")
{

	// если сохраняем сортировку
	if(isset($_REQUEST["sort"]))
	{
		$pagePosition = explode("|", $_REQUEST["list-sortPage"]);

		foreach($pagePosition as $position => $id)
			$DB->query("UPDATE ?_magazine SET page_position = ?d WHERE page_id = ?d", $position, $id);

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["sort"]);
	}

/*
	if(!empty($_REQUEST["template"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."vars.".$_REQUEST["template"].".php";
	}

	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		$phorm->add_comps($tpl_vars);
	}
*/
 // Если сохраняем комментерии
    if(isset($_REQUEST["comment"]))
	{

        for ($i=0;$i<10000;$i++)
        {
            if (!isset($_POST['id'.$i])) break;
            $id=$_POST['id'.$i];
            $text=$_POST['text'.$i];
            if($_POST['verdict'.$i]) $verdict=1;else $verdict=0;
            $DB->query("UPDATE comment_txt SET text = '".$text."',".
                       "verdict='".$verdict."'".
                       " WHERE id = ". $id);
        }
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_REQUEST["id"]."&idc=1");
	}
//
	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsm.".$_REQUEST["template"].".php";
		$phorm->add_comps($tpl_vars);
	}

	$phorm->mod_phorm_values($_REQUEST);
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

		Dreamedit::sendLocationHeader("https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_REQUEST["mod"] . "&action=view&id=" . $_REQUEST["id"]);
	}

	$sortRes = $DB->select("SELECT * FROM ?_magazine WHERE page_parent = ?d ORDER BY page_position ASC, page_name ASC", $_REQUEST["id"]);
	$sortArr = array();
	foreach($sortRes as $v)
		$sortArr[$v["page_id"]] = $v["page_name"];

	echo "<form method=\"POST\" action=\"\" id=\"data_form\">\n";
	echo "<input type=\"hidden\" name=\"sort\" value=\"".$_REQUEST["id"]."\" />";
	listSorting("sortPage", $sortArr);
	echo "</form>";
}


if($_ACTIVE["action"] == "del")
{
	$del_secure = $DB->selectCell("SELECT page_dell FROM ?_magazine WHERE page_id = ?d", $_REQUEST["id"]);
	if($del_secure)
	{
		echo Dreamedit::translate("Удаление данной страницы запрещено!<br />За подробностями обратитесь к администратору.");
		return;
	}

	$link_count = $DB->selectCell("SELECT COUNT(*) FROM ?_magazine WHERE page_link = ?d", $_REQUEST["id"]);
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
			$DB->query("DELETE FROM ?_magazine WHERE page_link = ?d", $_REQUEST["id"]);
			$DB->query("DELETE FROM ?_magazine_content WHERE page_id = ?d", $_REQUEST["id"]);
		}
		else
		{
			$rand_link = $DB->selectCell("SELECT page_id FROM ?_magazine WHERE page_link = ?d LIMIT 1", $_REQUEST["id"]);
			$DB->query("UPDATE ?_magazine SET page_link = '' WHERE page_id = ?d", $rand_link);
			$DB->query("UPDATE ?_magazine_content SET page_id = ?d WHERE page_id = ?d", $rand_link, $_REQUEST["id"]);
			$DB->query("UPDATE ?_magazine SET page_link = ?d WHERE page_link = ?d", $rand_link, $_REQUEST["id"]);
		}
	}

	$pid = $DB->selectCell("SELECT ?_magazine.page_parent FROM ?_magazine WHERE page_id = ?d", $_REQUEST["id"]);
	$DB->query("DELETE FROM ?_magazine WHERE page_id = ?d", $_REQUEST["id"]);
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
if($_ACTIVE["action"] == "comment" )
{
    $limit=10;
    $cmtcount=$DB->select("SELECT count(id) AS count FROM comment_txt
                        WHERE page_id=".$_REQUEST['id']);
    if (!isset($_GET[st])) $start=0;else $start=$_GET[st];
    $cmnt0=$DB->select("SELECT * FROM comment_txt
                        WHERE page_id=".$_REQUEST['id']." ORDER BY 'date' DESC LIMIT ".$start.",".$limit);

    echo "<br /><strong>Всего комментариев к этой странице: ".$cmtcount[0]['count']."</strong>";
    if (isset($_GET[st]) && $_GET[st]!=0)
        echo "<a href=/dreamedit/index.php?mod=magazine&id=".$_REQUEST[id]."&action=comment&idc=".$cmnt[id]."&st=".(($_GET[st]-1)*$limit).">Предыдущие ".$limit."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
    if(isset($_GET[st]) and ($_GET[st]+1)*$limit < $cmtcount[0]['count'])
       echo "<a href=/dreamedit/index.php?mod=magazine&id=".$_REQUEST[id]."&action=comment&idc=".$cmnt[id]."&st=".(($_GET[st]+1)*$limit).">Следующие ".$limit."</a>";

    echo "<form method=\"POST\" action=\"\" id=\"data_form\">\n";
    foreach ($cmnt0 as $i=>$cmnt)
    {
        echo "<input type=hidden name='comment'></input>";
    	echo "<input type=\"hidden\" name='id".$i."' value=\"".$cmnt["id"]."\" />";
    	echo "<br /><br />";
        echo "<strong>".$cmnt[user_name]."</strong> ".$cmnt[date]."<br />";
    	echo "<textarea name='text".$i."' cols='180' rows='6' value='";
    	echo $cmnt[text];
    	echo "'>".$cmnt[text];
    	echo "</textarea><br />";
    	if ($cmnt[verdict]==1 || $cmnt[verdict]=="on") $check="checked";else $check="";
    	echo "<input type='checkbox' name='verdict".$i."' ".$check." ></input>";
  }
    echo "</form>";

}
?>
