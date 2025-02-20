<?
/*
mysql_connect("localhost", "root", "da9Libisi");
mysql_select_db("isras2007");

$res = mysql_query("SELECT * FROM adm_ilines_content WHERE icont_var = 'date'");

while($row = mysql_fetch_assoc($res))
{
	$date = preg_match("/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})/i", $row["icont_text"], $matches);
	array_shift($matches);
	mysql_query("UPDATE adm_ilines_content SET icont_text = '".$matches[2].".".$matches[1].".".$matches[0]." 00:00' WHERE el_id = ".$row["el_id"]." AND icont_var  = 'date'");
	echo "convert ".$row["icont_text"]." to ".$matches[2].".".$matches[1].".".$matches[0]." 00:00<br />";
}
*/
/*
$search = '/header\(/';

searchInDir($_SERVER["DOCUMENT_ROOT"]."/");

function searchInDir($dir)
{
	global $search;

	if(!is_dir($dir) || !glob($dir."*"))
		return;

	foreach(glob($dir."*") as $v)
	{
		if(is_dir($v))
		{
//			echo "<b>".$v."</b><br />";
			searchInDir($v."/");
		}
		else
		{
//			echo $v;
			if(preg_match($search, file_get_contents($v)))
				echo $v." - <u>pattern founded</u><br />";
//				echo " - <u>pattern founded</u>";
//			echo "<br />";
		}
	}
}
*/
?>
