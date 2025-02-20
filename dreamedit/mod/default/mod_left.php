<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content,$DB;
include_once dirname(__FILE__)."/../../_include.php";

//include("/../../includes/class.Ilines.php");
$ilines = new Ilines();


/*$retVal = $DB->select("SELECT * FROM adm_ilines_warning");

//echo "<a hidden=true href=id>".$retVal[0][id]."</a>";

foreach ($retVal as $k) {
	echo "<a hidden=true href=id>".$k[id]."</a>";
	echo "<a hidden=true href=checked>".$k[checked]."</a>";
}
*/


echo Dreamedit::translate("Здравствуйте").", <b>".$_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_name"]."</b>!";

$rows = $ilines->getLimitedElementsMultiSortMainNewFunc(1, 5, 1,"DATE", "DESC", "status");

if(!empty($rows))
{
	//echo "<a hidden=true href=aaa>test</a>";
	$rows = $ilines->appendContent($rows);
	
	foreach($rows as $k => $v)
	{
		if(substr($v["content"]["DATE2"],0,10)!=date("Y.m.d"))
			unset($rows[$k]);
		else {
			if(substr($v["content"]["DATE"],0,10)>date("Y.m.d"))
				unset($rows[$k]);
			else if(substr($v["content"]["DATE2"],0,10)==date("Y.m.d") && date("Y.m.d H:i:s")>=date("Y.m.d 16:00:00"))
				unset($rows[$k]);
		}

						
	}

	$rows=array_values($rows);

	if(!empty($rows))
	{
		foreach ($rows as $k => $v) 
			{
				//$retVal = $DB->select("SELECT * FROM adm_ilines_warning WHERE id=".$v[el_id]." LIMIT 1");
				//if(!empty($retVal))
					if($v["content"]["CHECKED"])
						unset($rows[$k]);
			}
	}
	$rows=array_values($rows);
	
	foreach($rows as $k => $v)
	{
		
		if($v[itype_id]==1 || $v[itype_id]==4)
		{
			//echo "<a hidden=true src=test>".$v[itype_id]."</a>";
			}
			else
			unset($rows[$k]);
						
	}

	$rows=array_values($rows);
	
	foreach($rows as $k => $v)
	{
		//echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
		if($ilines->getNewsOutOfMain($v[el_id]))
			unset($rows[$k]);
						
	}

	$rows=array_values($rows);


}

if(!empty($rows))
{
	echo "<p></p>";
	echo "<table><tbody><tr><td height=25 width=25><p align=justify><img src=https://www.imemo.ru/files/Image/warning.png height=25 width=25></p></td><td height=25 width=3></td><td height=25><p align=justify><span style='vertical-align: middle; font-size: 0.7em;'>Следующие новости перешли в блок \"Новости и события\":</span></p></td></tr></tbody></table>";
	foreach ($rows as $k => $v) 
	{
		$temp_str=substr($v["content"]["TITLE"], 0, 22) . "...";
		echo "<table><tbody><tr><td height=25><p align=justify><strong><a target=_blank href=https://www.imemo.ru/dreamedit/index.php?mod=ilines&action=edit&type=l&id=".$v[el_id]."><img alt='width=15' src=https://www.imemo.ru/files/Image/button.png height=16 hspace=3></a></strong></p></td><td height=25><strong><span style='vertical-align: middle; font-size: 0.7em; position: fixed;'><a target=_blank href=https://www.imemo.ru/dreamedit/index.php?mod=ilines&action=edit&type=l&id=".$v[el_id].">".$temp_str."</a></span></strong><strong> </strong><p></p></td></tr></tbody></table>";
	}
}

?>