<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
include_once "form.php";

$pg=new pages();

//print_r($_REQUEST);
$pname=$pg->getPageById($_GET[id]);

echo "<br />Комментарии к странице: <strong>".$pname[page_name]."</strong><br />";
echo "<br />
        <a href=/dreamedit/index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_GET["id"].">";
if (!isset($_GET[all]))
   echo "<b>только новые</b></a> |";
else
   echo "только новые</a> |";
   
if (isset($_GET[all]))
	echo "<a href=/dreamedit/index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_GET["id"]."&all>
       <b>все</b>
       </a>";
else
	echo "<a href=/dreamedit/index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_GET["id"]."&all>
       все
       </a>";



if (!empty($_GET[id]))
{

if($_ACTIVE["action"] == "add")
{
	$phorm = new mod_phorm($mod_array);
	echo "<br/><strong>Ответ модератора</strong>";
	$data[text_new]="Здравствуйте!";
	$data[user_name]="moderator";
	$data[corr]="add";
	$phorm->mod_phorm_values($data);
	$phorm->display();
}

if($_ACTIVE["action"] == "edit" && !empty($_GET[idf]))
{
	$phorm = new mod_phorm($mod_array);
	$rows=$DB->select("SELECT * FROM comment_txt WHERE id=".$_GET[idf]);
  	echo "<br/><strong>".$rows[0][user_name]."</strong> ".$rows[0]['date'];
  	echo "<br />".$rows[0][email];
	$data[text_new]=$rows[0][text];
	$data[nic]=$rows[0][user_name];
	$data[verdict]=1;
	$data[admin]=$rows[0][admin];
	$data[corr]="corr";
	$data[id]=$_GET[idf];
	$phorm->mod_phorm_values($data);
	$phorm->display();
}
//print_r($_ACTIVE);
if(($_ACTIVE["action"] == "edit" || $_ACTIVE["action"] == "comment" || $_ACTIVE["action"]=='index') && empty($_GET[idf]))
{

 if (isset($_GET[all]))
 {
     $searchstring="verdict >=0";
     $txt = "Всего комментариев к этой странице: ";
 }
 else
 {
    $searchstring="verdict =0";
    $txt = "Новых комментариев к этой странице: ";
 }
 $rows=$DB->select("SELECT * FROM comment_txt WHERE page_id=".$_GET[id]." AND ".$searchstring." ORDER BY `date` DESC");
//print_r($rows);echo "@@@@";

 echo "<br /><strong>".$txt.count($rows)."</strong>";
    if (isset($_GET[st]) && $_GET[st]!=0)
        echo "<a href=/dreamedit/index.php?mod=pages&id=".$_REQUEST[id]."&action=comment&idc=".$row[id]."&st=".(($_GET[st]-1)*$limit).">Предыдущие ".$limit."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
    if(isset($_GET[st]) and ($_GET[st]+1)*$limit < $cmtcount[0]['count'])
       echo "<a href=/dreamedit/index.php?mod=pages&id=".$_REQUEST[id]."&action=comment&idc=".$row[id]."&st=".(($_GET[st]+1)*$limit).">Следующие ".$limit."</a>";

    echo "<form method=\"POST\" action=\"\" id=\"data_form\">\n";
    foreach ($rows as $i=>$cmnt)
    {
        echo "<input type=hidden name='comment'></input>";
    	echo "<input type=\"hidden\" name='id".$i."' value=\"".$cmnt["id"]."\" />";
    	echo "<br /><br />";
        echo "<strong>".$cmnt[user_name]."</strong> ".$cmnt[date]."<br />";
    	echo "e-mail: <b>".$cmnt[email]."</b><br />";
    	echo "<textarea name='text".$i."' cols='180' rows='6' value='";
    	echo $cmnt[text];
    	echo "'>".$cmnt[text];
    	echo "</textarea><br />";
    	if ($cmnt[verdict]==1 || $cmnt[verdict]=="on") $check="checked";else $check="";
    	echo "Опубликовать: <input type='checkbox' name='verdict".$i."' ".$check." ></input>";
	$mag=$DB->select("SELECT a.page_template AS template,a.page_parent,b.page_parent,IF(b.page_template='magazine',b.page_id,c.page_id) AS mag_id 
		FROM adm_pages AS a 
		INNER JOIN adm_pages AS b ON b.page_id=a.page_parent
		LEFT OUTER JOIN adm_pages AS c ON c.page_id=b.page_parent
		WHERE a.page_id=".$cmnt[page_id]);
//	print_r($mag);	
	if (substr($mag[0][template],0,8)=='magazine') 
	{
	//	ECHO "@@";
	
		$mag_root_page=$mag[0][mag_id];
		while(true)
		{
			$temp_root_page = $DB->select("SELECT page_parent from adm_pages WHERE page_id=".$mag_root_page );
			if($temp_root_page[0][page_parent]==522)
				break;
			else
				$mag_root_page=$temp_root_page[0][page_parent];
			
			if($temp_root_page[0][page_parent]==0)
				break;
			
		}
	
		$mag2=$DB->select("SELECT j.* FROM adm_pages_content AS p 
		INNER JOIN adm_magazine  AS j ON j.page_id=cv_text 
				WHERE p.page_id=".$mag_root_page." AND p.cv_name = 'ITYPE_JOUR'" );
		$pref="/jour/".$mag2[0][page_journame];
//print_r($mag2);				
	}
	else $pref="";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target=_blank href=".$pref."/index.php?page_id=".$cmnt[page_id]."&id=".$cmnt[page_id2].">Открыть страницу</a>";
        echo "<br /><a href=/dreamedit/index.php?mod=comment&id=".$_REQUEST[id]."&action=edit&id=".$_GET[id]."&idf=".$cmnt[id].">Отформатировать</a>";
        echo "&nbsp;&nbsp;&nbsp;<b>X </b><a href=/dreamedit/index.php?mod=comment&id=".$_REQUEST[id]."&action=del&idc=".$cmnt[id].">удалить эту запись</a>";

  }
    echo "</form>";

}
}
if($_ACTIVE["action"] == "del")
{

    $DB->query("DELETE FROM comment_txt
                WHERE  id=".$_GET[idc]
    	             );
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_GET[id]);
}
if($_ACTIVE["action"] == "save")
{


	// Если сохраняем комментерии

    if(!empty($_POST[text_new])&& $_POST[corr]=="add")
    {
    	  $DB->query("INSERT INTO comment_txt (id,page_id,text,user_name,date,verdict)
    	             VALUES (0,".
    	             $_GET[id].",".
    	             "'".$_POST[text_new]."',".
    	             "'moderator',".
    	             "'".date("Y.m.d")."',".
    	             "'".$_POST[verdict]."'".
    	             ")"
    	             );
    }




    if(isset($_REQUEST["comment"]) || $_POST[corr]=="corr")
	{

        for ($i=0;$i<10000;$i++)
        {
            if (!isset($_POST['id'.$i])) break;
            $id=$_POST[id.$i];
            $text=$_POST[text.$i];
            if($_POST[verdict.$i]) $verdict=1;else $verdict=0;
            $DB->query("UPDATE comment_txt SET text = '".$text."',".
                       "verdict='".$verdict."'".
                       " WHERE id = ". $id);
        }
        if ($_POST[corr]=="corr")
        {
        	$DB->query("UPDATE comment_txt SET text = '".$_POST[text_new]."',".
                       "verdict='".$_POST[verdict]."', admin='".$_POST[admin]."'".
                       " WHERE id = ". $_POST[id]);

        }
	}
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=comment&id=".$_GET["id"]);

 /*
	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."vars.".$_REQUEST["template"].".php";
		$phorm->add_comps($tpl_vars);
	}

	$phorm->mod_phorm_values($_REQUEST);
	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}
*/
	include_once "save_action.php";

	}







?>
