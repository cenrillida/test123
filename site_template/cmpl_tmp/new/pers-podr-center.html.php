<?
global $DB,$_CONFIG, $site_templater;
//print_r($_CONFIG);


$pg = new Pages();
$ps = new Persons();

if (!empty($_REQUEST[dep]))
{
	if($_SESSION[lang]!="/en")
		$tt=$DB->select("SELECT page_name FROM adm_pages WHERE page_id=".(int)$_REQUEST[dep]);
	else
		$tt=$DB->select("SELECT page_name_en AS page_name FROM adm_pages WHERE page_id=".(int)$_REQUEST[dep]);
		
    $site_templater->appendValues(array("TITLE" => $tt[0][page_name]));
}
//if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"]))
//    Dreamedit::sendLocationHeader($pg->getPageUrl($pg->getParentId($_TPL_REPLACMENT["FULL_ID"])));

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
if (!isset($_REQUEST[printmode]))
{
	$print_text="Полный список";
	if($_SESSION[lang]=="/en")
	{
		$print_text="Full list";
	}

	?>
	<div class="text-lg-right text-center">
		<a class="btn btn-lg imemo-button text-uppercase" href="<?php if (empty($_SERVER[REDIRECT_URL])) echo "/index.php?".$_SERVER[QUERY_STRING]."&printmode&printall"; else echo "/".substr($_SERVER[REDIRECT_URL],1)."?".$_SERVER[QUERY_STRING]."&printmode&printall";?>" role="button"><?=$print_text?></a>
	</div>
	<?php
}


$center0=$pg->getPageById($_REQUEST[dep]);



if($_SESSION[lang]=="/en")
{
	$center0[page_name]=$center0[page_name_en];
	$center0[page_status]=$center0[page_status_en];
	$center0[menu_header]=$center0[menu_header_en];
}

echo $_TPL_REPLACMENT["CONTENT"];

echo "<a class='podr' href='/index.php?page_id=".$pcenter."'><strong>".$center[0][page_name]."</strong></a><br /><br />";

// Найти руководителя

$persr = $DB->select("SELECT * FROM adm_pages_content WHERE page_id='". (int)$_REQUEST[dep]."' AND cv_name='chif'");


//Считать сведения про руководителя

$rukid=0;$sekrid=0;
if($_SESSION[lang]!="/en")
	$ruk=$ps->getPersonsRegaliiByCenterId((int)$_REQUEST[dep],"chif");
else
{
	$ruk=$ps->getPersonsRegaliiByCenterIdEn((int)$_REQUEST[dep],"chif");
	if(!empty($ruk))
	{
		$name_arr=spliti(" ",$ruk[0][Autor_en]);
		if(!empty($name_arr[1]))
			$ruk[0][surname]=$name_arr[1];
		if(!empty($name_arr[2]))
			$ruk[0][surname].=" ".$name_arr[2];
		$ruk[0][name]=$name_arr[0];
		$ruk[0][fname]="";
	}
}

if(!empty($ruk)) $rukid=$ruk[0][id];

$c = 0;


       echo "<blockquote dir='ltr' style='margin-right: 0px'>";
       echo "<table cellspacing='0' cellpadding='0'>";
       echo "<tr>";
	   if($_SESSION[lang]!="/en")
		{
			echo "<td valign='top'>Руководитель: </td><td width='10'.</td>";
			echo "<td><a href=/?page_id=".$_TPL_REPLACMENT["FULL_ID"]."&id=".$ruk[0][id]."><b>".$ruk[0][surname].'
			'.$ruk[0][name].' '.$ruk[0][fname].'</b></a><br />';
		}
		else
		{
			echo "<td valign='top'>Head: </td><td width='10'.</td>";
			echo "<td><a href=/en/?page_id=".$_TPL_REPLACMENT["FULL_ID"]."&id=".$ruk[0][id]."><b>".$ruk[0][surname].'
			'.$ruk[0][name].'</b></a><br />';
		}

  //     echo trim($ruk[0][chlen]." ".$ruk[0][us]." ".$ruk[0][uz].", ".$ruk[0][dolj]);
        if (!empty($ruk[0][regalii0]))
      echo $ruk[0][regalii0].", ";
      echo $ruk[0][dolj];
      echo $ruk[0][ForSite];
       echo "<br />";
       echo  trim($ruk[0][contact]);


       echo "</td></tr>";

// Найти ученого секратря



$name_ruk=explode(" ", $persr[0][dol2]);

//Считать сведения про Ученого секретаря
if($_SESSION[lang]!="/en")
	$ruk=$ps->getPersonsRegaliiByCenterId((int)$_REQUEST[dep],"sekr");
else
{
	$ruk=$ps->getPersonsRegaliiByCenterIdEn((int)$_REQUEST[dep],"sekr");
	if(!empty($ruk))
	{
		$name_arr=spliti(" ",$ruk[0][Autor_en]);
		if(!empty($name_arr[1]))
			$ruk[0][surname]=$name_arr[1];
		if(!empty($name_arr[2]))
			$ruk[0][surname].=" ".$name_arr[2];
		$ruk[0][name]=$name_arr[0];
		$ruk[0][fname]="";
	}
}

if(!empty($ruk)) $sekrid=$ruk[0][id];

$c = 0;

if (!empty($ruk))
{
        echo "<tr>";
		
		if($_SESSION[lang]!="/en")
		{
			echo "<td valign='top'>Ученый секретарь</td><td width='10'></td>";
			echo "<td> <a  href=/?page_id=".$_TPL_REPLACMENT["FULL_ID"].
	     "&id=".$ruk[0][id]."><b>".$ruk[0][surname].'
	    '.$ruk[0][name].' '.$ruk[0][fname].'</b></a><br>';
		}
		else
		{
			echo "<td valign='top'>Science secretary</td><td width='10'></td>";
			echo "<td> <a  href=/?page_id=".$_TPL_REPLACMENT["FULL_ID"].
	     "&id=".$ruk[0][id]."><b>".$ruk[0][surname].'
	    '.$ruk[0][name].'</b></a><br>';
		}

     if (!empty($ruk[0][regalii0]))
      echo $ruk[0][regalii0].", ";
      echo $ruk[0][dolj];
      echo $ruk[0][ForSite];
    	echo "<br />";
	echo   trim($ruk[0][contact]);


        echo "</td></tr>";
}
        echo "</table>";


echo "</blockquote>";
echo "<br />";

echo "<span class='hr'>&nbsp;</span>";
echo "<br /><br />";
///////////////
$str0=$pg->getChilds($_REQUEST[dep],1);

$where="";
foreach($str0 as $s)
{

   $where.="p.otdel=".(int)$s[page_id]." OR p.otdel2=".(int)$s[page_id]." OR p.otdel3=".(int)$s[page_id]." OR ";
   $str2=$pg->getChilds((int)$s[page_id]);
   foreach($str2 as $s2)
   {
		$where.="p.otdel=".(int)$s2[page_id]." OR p.otdel2=".(int)$s2[page_id]." OR p.otdel3=".(int)$s2[page_id]." OR ";
   } 
}
if(!empty($where)) $where="(".substr($where,0,-4).")";
else $where="o.page_id=".(int)$_REQUEST[dep];
if (empty($where)) $where="1";



$result_pers = $DB->select("SELECT count(*) AS count FROM persons AS p 
                    INNER JOIN adm_pages AS o ON o.page_id=p.otdel 
					WHERE ".$where );
$vsego = $result_pers[0]['count'];

$t_page = $_REQUEST["p"];

if($t_page==0 || $t_page<0) {
	$t_page = 1;
}

// Людей на странице

$podr_id=$_GET[dep];
$pg_text="Страницы";
$next_text="следующая";
$previous_text="предыдущая";

if($_SESSION[lang]=="/en")
{
	$pg_text="Pages";
	$next_text="next";
	$previous_text="previous";
}

$part = 10;
$start_rec=0;

if (!isset($_GET[printall])) {
	?>
	<nav class="mt-2">
		<ul class="pagination pagination-sm flex-wrap">
			<?php
			$addParams = array();

			if (!empty($podr_id)) {
				$addParams['dep'] = $podr_id;
			}
			$spe2 = Pagination::createPagination($vsego, $part, $addParams);

			echo $spe2;
			?>
		</ul>
	</nav>
	<?php
}

$n_page=ceil($vsego / $part);


$start_rec=$part*($t_page-1);

//echo "select id,surname,name,fname,us,uz,chlen,dolj  from persona where ". $spisok." order by surname
//limit ".$start_rec.", ".$part;

//echo "<br />".$i_page." ".$start_rec." ".$end_rec." " . "<br />";
if(isset($_REQUEST[printall]))
{
  $start_rec=0;
  $part=1000;
}
//echo $where." ".$srart_rec." * ".$part;

if($_SESSION[lang]!="/en")
$result_pers = $DB->select("SELECT DISTINCT p.id,p.surname,p.name,p.fname,
            CONCAT(p.surname,' ',substring(p.name,1,1),'. ',substring(p.fname,1,1),'.') AS shortname,
       		d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz,o.page_name AS otdel,p.full,p.picsmall
			  FROM persons AS p
                    INNER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text'
		LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us   AND s.icont_var='text'
		LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz   AND z.icont_var='text'
		LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran   AND r.icont_var='text'
		LEFT OUTER JOIN persons AS p2 ON p.id=p2.second_profile
		INNER JOIN adm_pages AS o ON o.page_id=p.otdel
WHERE p.full<>1 AND ".$where." AND  p.id<>".$rukid." AND p.id<>".$sekrid." AND p2.id IS NULL ORDER BY p.surname,p.name,p.fname
LIMIT ".$start_rec.", ".$part);
else
$result_pers = $DB->select("SELECT DISTINCT p.id,p.surname,p.name,p.fname,p.Autor_en,
            CONCAT(p.surname,' ',substring(p.name,1,1),'. ',substring(p.fname,1,1),'.') AS shortname,
       		d.icont_text AS dolj, r.icont_text AS chlen, s.icont_text AS us, z.icont_text AS uz,o.page_name AS otdel,p.full,p.picsmall
			  FROM persons AS p
                    INNER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text_en'
		LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us   AND s.icont_var='text_en'
		LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz   AND z.icont_var='text_en'
		LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran   AND r.icont_var='text_en'
		LEFT OUTER JOIN persons AS p2 ON p.id=p2.second_profile
		INNER JOIN adm_pages AS o ON o.page_id=p.otdel
WHERE p.full<>1 AND ".$where." AND  p.id<>".$rukid." AND p.id<>".$sekrid." AND p2.id IS NULL ORDER BY p.surname,p.name,p.fname
LIMIT ".$start_rec.", ".$part);


if($_SESSION[lang]=="/en")
{
	for($i=0;$i<count($result_pers);$i++)
	{
		$name_arr=spliti(" ",$result_pers[$i][Autor_en]);
		if(!empty($name_arr[1]))
			$result_pers[$i][shortname]=$name_arr[1];
		if(!empty($name_arr[2]))
			$result_pers[$i][shortname].=" ".$name_arr[2];
		$result_pers[$i][shortname].=" ".$name_arr[0];
	}
}
print_sotr($result_pers,$_TPL_REPLACMENT[FULL_ID]);

if (!isset($_GET[printall]))
{
	?>
	<nav class="mt-2">
		<ul class="pagination pagination-sm flex-wrap">
			<?php
			echo $spe2;
			?>
		</ul>
	</nav>
	<?php
}

echo "<br>";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
//------------------

function print_sotr($row03,$FULL_ID)
{

$c = 0;
echo "<table  width='90%'	style='padding-left:40px;'>";

//while($row3 = mysql_fetch_array($result_pers)) {
//echo $row3[1]."<br />";
//------------------------------------------------
foreach ($row03 AS $ii=>$row3)
{
//echo "<br />";print_r($row3);
if (!empty($row3[picsmall]))
{
//$testfile = $_CONFIG["global"]["paths"]["admin_path"].'foto/'.$row3[picsmall];

//if(file_exists($testfile))
// $photo = "<img align=left hspace=10 vspace=10 border=1 src=/dreamedit/foto/".$row3[picsmall]." height=84 width=63>";
$photo = "<table cellspacing='0' cellpadding='0' ><td border='1' bordercolor='#c6c5d0'>
 <img  src=/dreamedit/foto/".$row3[picsmall]." >
 </td></table>
 ";

}
 else
//   $photo = "<img  src=/dreamedit/foto/nonesmall.jpg height=84 width=63>";
   $photo = "<table cellspacing='0' cellpadding='0' ><td border='1' bordercolor='#c6c5d0'>
 <img  src=/dreamedit/foto/nonesmall.jpg >
 </td></table>
 ";
echo "<tr >";
echo "<td>".$photo."</td>";
if (empty($_TPL_REPLACMENT[SWITCH_PAGE]))
{
    echo "<td>&nbsp;&nbsp;<a  href=".$_SESSION[lang]."/?page_id=".$FULL_ID."&id=".$row3[id]."><b>".$row3[shortname].'</b></a><br>';
}
else
{
	echo "<td>&nbsp;&nbsp;<a  href=".$_SESSION[lang]."/?page_id=".$FULL_ID."&id=".$row3[id]."><b>".$row3[shortname]." (".$row3[year1]."-".$row3[year_institute].")".'</b></a><br>';
}
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        trim(str_replace(', ,',',' , $row3[chlen].", ".$row3[us].", ".$row3[uz].", ".$row3[dolj]), ', ') ;
//    echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row3[otdel];
    echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row3[ForSite];

    if($_GET[debug]==1)
        var_dump($row3);
    echo "</td>";



    echo "</tr>";

    echo "<tr><td colspan='2'>&nbsp;</td></tr>";
}

//if (empty($_TPL_REPLACMENT[SWITCH_PAGE]))


// Закрыли page
echo "</table>";

}

?>
