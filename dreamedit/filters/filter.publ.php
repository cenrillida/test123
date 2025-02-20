<?
// ¿ÍÚÛ‡Î¸Ì˚Â ÔÛ·ÎËÍ‡ˆËË
global $DB,$_CONFIG;
if (date("m") < 3)
{
   $year=date("y")-1;
   $month=date("m")+12-3+1;
}
else
{
   $year=date("y");
   $month=date("m")-3+1;
}
$str=$DB->select("SELECT * FROM (SELECT id,date,name,IF(name2='',name,name2) AS name2,`link`,
				 link_en, vid FROM publ
                 WHERE status=1 AND formain=1 ORDER BY substring(date,7,2),substring(date,4,2),substring(date,1,2) LIMIT 3) AS z
                  ORDER BY RAND() LIMIT 1"
                );
//print_r($str);
 if (!isset($_REQUEST[en]))
    echo '<p><strong><img hspace="14" alt="" align="left" width="71" height="64" src="/files/Image/lamp_l.jpg" />—¿Ã€≈<br />
¿ “”À‹Õ€≈<br />
—“¿“‹»</strong></p>
';
else
{
    echo '<p><strong><img hspace="14" alt="" align="left" width="71" height="64" src="/files/Image/lamp_l.jpg" />THE MOST<br />
IMPORTANT<br />
ARTICLES</strong></p>
';
//the most important articles
}
    echo "<table>";
    foreach($str as $s)
    {
	 	$tpl = new Templater();
	 	$tpl->setValues(array("ID" => $s[id]));
	 	if (!isset($_REQUEST[en]))
	 	{
	    	$tpl->appendValues(array("name" => $s['name']));
	    	$tpl->appendValues(array("link" => $s['link']));
	    }
	    else
	    {
	    	$tpl->appendValues(array("name" => $s[name2]));
	    	if (!empty($s['link_en']))
		    	$tpl->appendValues(array("link" => $s['link_en']));
		    else
		    	$tpl->appendValues(array("link" => $s['link']));
	    }
	    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.publ_actual.html");
    }

    echo "</table>";

 //echo $buffer;

?>
