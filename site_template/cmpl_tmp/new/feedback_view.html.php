<?
	global $DB, $_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
	<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
<?

	echo $_TPL_REPLACMENT["CONTENT"];

    $feedcount=$DB->select("SELECT count(id) as count FROM feedback WHERE fio <> ''");
    $fcount=$feedcount[0][count];
    $numpages=ceil($fcount/$_TPL_REPLACMENT['COUNT']);

    if(!$_REQUEST['page']) $page = 1;
      else $page = $_REQUEST['page'];


   if (($_REQUEST['page']) && ($_REQUEST['page']>1))
   $previos = "<a href=index.php?page_id=" .
              $_REQUEST[page_id]."&page=".($_REQUEST['page']-1).$request_string."><b>предыдущая&nbsp&nbsp&larr;&nbsp&nbsp; </b></a>";

    if ($_REQUEST['page']<=$numpages)

	if ($_REQUEST[page]=="") $tpage=1;
	else $tpage = $_REQUEST[page];
	$next = "<a href=index.php?page_id=".$_REQUEST[page_id]."&page=".($tpage+1).$request_string."><b>&nbsp&rarr;&nbsp&nbsp   cледующая</b></a>";

	if($_REQUEST[page] > 1) $spe .= $previos;
	if($page>3) $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].$request_string.'&page=1>1</a>&nbsp;&nbsp ';
	if($page>4) $spe .= '... ';
	if($page>2) $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].$request_string.'&page='.($page-2).'>'.($page-2).'</a>&nbsp;&nbsp; ';
	if($page>1) $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].$request_string.'&page='.($page-1).'>'.($page-1).'</a>&nbsp;&nbsp; ';
	$spe .= '<b>'.$page.'</b>&nbsp;&nbsp; ';
	if($page<$numpages) $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].$request_string.'&page='.($page+1).'>'.($page+1).'</a> &nbsp;&nbsp;';
	if($page<$numpages-1) $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].$request_string.'&page='.($page+2).'>'.($page+2).'</a>&nbsp;&nbsp; ';
	if($page<$numpages-3) $spe .= " ...  ";
	if($page<$numpages-2) $spe .= " <a href=index.php?page_id=".$_REQUEST[page_id].$request_string."&page=$numpages>".$numpages."</a>";
	if ($_REQUEST[page]< $numpages && $numpages > 1) $spe .= "&nbsp;&nbsp;".$next;


      if ($numpages > 1)
        echo "<center>".$spe."</center><br /><hr>";
// Посчитать начальную и конечную публикацию в списке
       $i0=($page-1)*$_TPL_REPLACMENT['COUNT'];
       $in=$page*$numpages;

    $feed0=$DB->select(
                "SELECT * FROM feedback WHERE fio <> '' ORDER BY date DESC LIMIT ".$i0.", ".$_TPL_REPLACMENT['COUNT']
                );

     echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
     foreach($feed0 as $k=>$feed)
     {

   echo "<tr> <td>&nbsp;&nbsp;&nbsp;</td>".
           "<td>".
           "<strong>".$feed[fio]."</strong>&nbsp;&nbsp;&nbsp;".
           substr($feed['date'],8,2)."/".substr($feed['date'],5,2)."/".substr($feed['date'],0,4).
           "<br />".
           "<a href='mailto:".$feed[email]."'>".$feed[email]."</a> ".$feed[telephone]."<br />".
           "<a title='подробно' href='/index.php?page_id=".$_TPL_REPLACMENT[FEEDBACK_FULL_ID]."&id=".$feed[id]."'>".
           substr(strip_tags($feed[text]),0,100)."</a><br /><br /><hr>";
      echo "</td></tr>";
}
echo "</table>";
 if ($numpages > 1) echo "<br /><center>".$spe."</center>";
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>