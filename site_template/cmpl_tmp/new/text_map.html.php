<?
global $DB,$_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

    $name=array("Америка"=>"america","Европа"=>"europe","Азия"=>"asia","Африка"=>"africa","Австралия"=>"australia");
	
	if ($_SESSION[lang]!='/en') $txt='К карте'; else $txt="To Map";
	
	if (!empty($_TPL_REPLACMENT["CONTENT"]))
	{
//		echo @$_TPL_REPLACMENT["CONTENT"];
    if ($_SESSION[lang]!='/en')
	{
?>		
<?
}
else
{
?>		
<?
}


$land="";
if ($_SESSION[lang]!='/en')
$rows=$DB->select("SELECT c.icont_text AS project,l.icont_text AS cclass FROM adm_ilines_content AS c
                   INNER JOIN adm_ilines_content AS l ON l.el_id=c.el_id AND l.icont_var='cclass' 
				   INNER JOIN adm_ilines_content AS s ON s.el_id=c.el_id AND s.icont_var='status' AND s.icont_text=1
				   INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND e.itype_id=8
				   WHERE c.icont_var='project' 
				   ORDER BY IF(l.icont_text='Америка',1,IF(l.icont_text='Европа',2,IF(l.icont_text='Азия',3,IF(l.icont_text='Африка',4,5)))), 
				   c.icont_text ASC");
else
$rows=$DB->select("SELECT c.icont_text AS project,l.icont_text AS cclass FROM adm_ilines_content AS c
                   INNER JOIN adm_ilines_content AS l ON l.el_id=c.el_id AND l.icont_var='cclass' 
				   INNER JOIN adm_ilines_content AS s ON s.el_id=c.el_id AND s.icont_var='status' AND s.icont_text=1
				   INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND e.itype_id=8
				   WHERE c.icont_var='project_en' 
				   ORDER BY IF(l.icont_text='Америка',1,IF(l.icont_text='Европа',2,IF(l.icont_text='Азия',3,IF(l.icont_text='Африка',4,5)))), 
				   c.icont_text ASC");

				  
	if($_SESSION[lang]!='/en') echo $_TPL_REPLACMENT[TXT]; else echo $_TPL_REPLACMENT[TXT_EN];
    foreach($rows as $row)
	{ 
	    if ($land != $row[cclass])
		{
		   //if (!empty($land)) echo "<a href=#0 style='text-decoration:underline;'>>> ".$txt."</a><br />";
		   if ($_SESSION[lang]=='/en')
			echo "<br /><a name=".$name[$row[cclass]]."><h2>".ucfirst($name[$row[cclass]])."</h2></a>";
		   else	
			echo "<br /><a name=".$name[$row[cclass]]."><h2>".$row[cclass]."</h2></a>";

		   $land=$row[cclass];
		}
		echo str_replace("</p>","",str_replace("<p>","",$row[project]))."<br />";
	}
    //if (!empty($land)) echo "<a href=#0 style='text-decoration:underline;'>>> ".$txt."</a><br /><br /><br /><br />";
	}
	else {
        echo "<b>В этом разделе:</b>";
        if($_GET[debug]==2) {
            echo $_TPL_REPLACMENT["SUBMENU"];
        } else {
            include($_TPL_REPLACMENT["SUBMENU"]);
        }
    }
?>
<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
<?		
    
					

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
