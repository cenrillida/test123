<script language="JavaScript">
function ch(param)
{
	var a=document.getElementById('cnt').style;
	var b=document.getElementById('cnt2').style;
	var c=document.getElementById('cnt3').style;
	if(param=='on')
	{
	   a.display='block';
	   b.display='block';
       c.display='none';
	}
	else
	{
	   a.display='none';
	   b.display='none';
       c.display='block';
	}

}
</script>
<?

$pg=new Pages;
$ps=new Persons();
global $DB, $_CONFIG, $site_templater;

if($_TPL_REPLACMENT['ARTICLE_MODE']==1) {
    if($_GET['ap']==1) {
        $rows=$DB->select("
SELECT t.cv_text AS 'name' 
FROM afjourn.adm_pages AS ar
INNER JOIN afjourn.adm_pages_content AS t ON t.page_id=ar.page_id AND t.cv_name='TITLE'
WHERE ar.page_id=?d
         ",
         (int)$_GET[id]
        );
    } else {
        $rows=$DB->select("SELECT name FROM adm_article WHERE page_id=".(int)$_GET[id]);
    }
} else {
    $rows=$DB->select("SELECT name,name_title FROM publ WHERE id=".(int)$_GET[id]);
}

if($rows[0][name_title]!="")
    $site_templater->appendValues(array("TITLE" => $rows[0][name_title]));
else
    $site_templater->appendValues(array("TITLE" => $rows[0][name]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


echo "<div class='content' style='text-align:left;'><a href=/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID].">к списку публикаций</a></div>";
$speid=(int)$_GET['id'];

$avt = '';



$mname=array(1=>"январь",2=>"февраль",3=>"март",4=>"апрель",5=>"май",6=>"июнь",7=>"июль",8=>"август",9=>"сентябрь",10=>"октябрь",11=>"ноябрь",12=>"декабрь");

if($_TPL_REPLACMENT['ARTICLE_MODE']==1) {
    if($_GET['ap']==1) {
        $result=$DB->select(
            "
        SELECT 
          t.cv_text AS 'name',
          p.cv_text AS 'avtor',
          ane.cv_text AS 'annots',
          n.date_created AS 'date'
          FROM afjourn.adm_pages AS ar 
          INNER JOIN afjourn.adm_pages_content AS t ON t.page_id=ar.page_id AND t.cv_name='TITLE'
          INNER JOIN afjourn.adm_pages_content AS p ON p.page_id=ar.page_id AND p.cv_name='PEOPLE'
          INNER JOIN afjourn.adm_pages_content AS ane ON ane.page_id=ar.page_id AND ane.cv_name='ANNOTS'
          INNER JOIN afjourn.adm_pages AS r ON ar.page_parent=r.page_id
          INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
          WHERE ar.page_id=?d
         ",$speid);

        try {
            $dt = date_create_from_format("Y.m.d H:i",$result[0]['date']);
            $result[0]['date'] = $dt->format('d.m.Y');
        } catch (Exception $e) {
        }

        $journal = $pg->getContentByPageId(1674);

        if (!empty($journal["LOGO_SLIDER"]) && $journal["LOGO_SLIDER"] != '<p>&nbsp;</p>') {
            preg_match_all('@src="([^"]+)"@', $journal["LOGO_SLIDER"], $imgSrc);

            $imgSrc = array_pop($imgSrc);
            $imgAlt = array_pop($imgAlt);
            if(!empty($imgSrc[0])) {
                $result[0]['picbig'] = $imgSrc[0];
            }
        }

        $count0=$DB->select("SELECT SUM(publ_count) AS publ_count,SUM(pdf_count) AS pdf_count,month,year,date FROM publ_stat WHERE (`module`='afjourn') AND publ_id=?d GROUP BY CONCAT(`year`,`month`) ORDER BY `year` DESC,`month` DESC",(int)$_GET[id]);
    } else {
        $result=$DB->select(
            "SELECT journal_new,`name`,`annots`,`date`, adm_article.people AS avtor	          
          FROM adm_article 
         WHERE page_id=?d",$speid);

        $journal = $pg->getContentByPageId($result[0]['journal_new']);

        if (!empty($journal["LOGO_MAIN"]) && $journal["LOGO_MAIN"] != '<p>&nbsp;</p>') {
            preg_match_all('@src="([^"]+)"@', $journal["LOGO_MAIN"], $imgSrc);

            $imgSrc = array_pop($imgSrc);
            $imgAlt = array_pop($imgAlt);
            if(!empty($imgSrc[0])) {
                $result[0]['picbig'] = $imgSrc[0];
            }
        }

        $count0=$DB->select("SELECT SUM(publ_count) AS publ_count,SUM(pdf_count) AS pdf_count,month,year,date FROM publ_stat WHERE (`module`='article' OR `module`='') AND publ_id=?d GROUP BY CONCAT(`year`,`month`) ORDER BY `year` DESC,`month` DESC",(int)$_GET[id]);
    }
} else {
    $result=$DB->select(
        "SELECT publ.*,vid.text as vid,rubric2 AS rubric_id,publ.date,
     IF(rubric2<>0 OR rubric2d<>0,
        CONCAT(CONCAT('<br /><a href=https://www.imemo.ru/index.php?page_id=',?,'&rub2=',r.id,' title=\"Все публикации в этой рубрике\" >',r.name,'</a>'),IF(rubric2d<>0,CONCAT('<br /><a href=/index.php?page_id=',?,'&rub2=',r2.id,' title=\"Все публикации в этой рубрике\" >',r2.name,'</a>'),'')),publ.rubric) AS rubric
	          FROM publ
		      LEFT OUTER JOIN vid ON vid.id=publ.vid
		      LEFT OUTER JOIN publ_rubric AS r ON r.id=publ.rubric2
              LEFT OUTER JOIN publ_rubric AS r2 ON r2.id=publ.rubric2d
                         WHERE publ.id=?d", $_TPL_REPLACMENT[PUBL_SPISOK],$_TPL_REPLACMENT[PUBL_SPISOK],$speid);

    $count0=$DB->select("SELECT SUM(publ_count) AS publ_count,SUM(pdf_count) AS pdf_count,month,year,date FROM publ_stat WHERE (`module`='publ' OR `module`='') AND publ_id=?d GROUP BY CONCAT(`year`,`month`) ORDER BY `year` DESC,`month` DESC",(int)$_GET[id]);
}

foreach($result as $k=>$row)
{


// Разборка авторов
$temp=explode("<br>",trim($row[avtor]));
$avtor_string;
foreach($temp as $ii=>$avt)
{

    if (!empty($avt))
    {
       if (is_numeric($avt))
       {
       $avtor=$ps->getAvtorById($avt);
       $avtor_string.="<a href=https://www.imemo.ru/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_A']."&id=".$avtor[0][id].">".
             $avtor[0][fullname]."</a>, ";

       }
       else
           if (trim($avt)!='Коллектив авторов') $avtor_string.=$avt.", ";
       }
}
$avtor_string=substr($avtor_string,0,-2);
// Картинка


if (!empty($result[0][picbig]) && !isset($_GET['new'])) {
    if($_TPL_REPLACMENT['ARTICLE_MODE']==1) {
        $pfoto = "<img style='width: 65px;' src='" . $result[0][picbig] . "' >";
    } else {
        $pfoto = "<img style='width: 65px;' src=https://www.imemo.ru/dreamedit/pfoto/" . $result[0][picbig] . " >";
    }
}

?>
<br>

<div class="row">

    <div class="col-12 col-md-2">
        <div class="text-center">
        <? echo $pfoto;?>
        </div>
    </div>

<div class="col-12 col-md-10">
<?
    if($_TPL_REPLACMENT['ARTICLE_MODE']==1) {
        if(!empty($journal)) {
            echo '<div>Журнал: '.$journal['TITLE'].'</div>';
        }
    }

//echo "<br />";
if ($row['as']!='on') echo "<em>".$avtor_string."</em><br />";

echo "<strong>".str_replace("'",'`',str_replace('"','`',$row[name]))."</strong>";
echo "<br /><strong>".str_replace("'",'`',str_replace('"','`',$row[name2]))."</strong>";

$ii = strpos($avtor_string,'Коллектив авторов',0);
echo '<br />';
//Счетчик просмотров
$s=0;$spdf=0;
?>
</div>
</div>
    <div class="row">
        <div class="col-12">
            <?php
echo "<br/><div style='background-color:#efefef;color:#333333;'>";
echo "<blockquote><b>Количество:<br /></b>";
echo "<blockquote><div  style='color:#333333;'><table bgcolor='#efefef' style='color:#333333;'>";
echo "<tr><td class='px-2' style='color:#333333;'>Месяц</td><td class='px-2' style='color:#333333;'>Просмотров</td><td class='px-2' style='color:#333333;'>Скачиваний</td><td class='px-2' style='color:#333333;'>Рейтинг</td></tr>";
foreach($count0 as $count)
{
	$s+=$count['publ_count'];
	$spdf+=$count['pdf_count'];
	echo "<tr><td class='px-2' style='color:#333333;'>".$mname[$count[month]]." ".$count[year].":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td class='px-2' style='color:#333333;'><b>".$count[publ_count]."</b></td>";
	echo "<td class='px-2' style='color:#333333;'><b>".$count[pdf_count]."</b></td>";
	echo "<td class='px-2' style='color:#333333;'><b>".number_format(sqrt($count[publ_count]*$count[publ_count]+$count[pdf_count]*$count[pdf_count]),2)."</b></td>";
	echo "</tr>";
}
    echo "<tr style='color:#333333;'><td class='px-2' style='color:#333333;'><b>  Всего: </td><td class='px-2' style='color:#333333;'>".$s."</b></td>";
    echo "<td class='px-2' style='color:#333333;'>".$spdf."</b></td>";
    echo "<td class='px-2' style='color:#333333;'>".number_format(sqrt($s*$s+$spdf*$spdf),2)."</b></td>";
    echo "</tr>";
    echo "</table></div></blockquote>";
    echo "В каталоге с : ".$row['date'];
    if(!empty($count0[0])) {
        echo "<br />Последний раз просматривали: " .
            substr($count0[0]['date'], 6, 2) . "." . substr($count0[0]['date'], 4, 2) . "." . substr($count0[0]['date'], 0, 4);
    }
    echo"</blockquote>";
echo "</div>";
if(!empty($avtor_string) && $row['as']!='on') {
if ($row['as'] == 'on' && $ii==0)
   {
   echo "<br />";
   echo "<blockquote><b>Авторский коллектив:</b><br />";

     echo "<em>".$avtor_string."</em>";
   echo "</blockquote><br />";
}}

if (!empty($row[rubric]) && false) //отключили рубрики
{
?>

<br />
<b>Рубрики</b>

<?
//echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT[PUBL_SPISOK]."&rub2=".$row[rubric_id]." title=' Все публикации в этой рубрике' >".ltrim($row[rubric]," .0123456789")."</a>";
echo $row[rubric];
}
?>
   <br />
<? echo $row[annots]; ?>

<?

if(!empty($row[izdat]))
{
    switch ($row[tip])
    {
        case 441:
            echo "<br />ISBN ".$row[izdat];
            break;

        case 442:
            echo "<br />ISSN ".$row[izdat];
            break;

        case 443:
            $electronic_resource_izdat="ISBN";

            if(preg_match("/(^[0-9]{4}+)-([0-9]{4}+$)/",$row[izdat]))
                $electronic_resource_izdat="ISSN";

            echo "<br />".$electronic_resource_izdat." ".$row[izdat];
            break;

        default:
            echo "<br />ISBN ".$row[izdat];
    }
}?>
    <? if(!empty($row[doi]))
    {
        if(!empty($row[izdat]))
            echo "<br />";
        echo "<br />DOI: ".$row[doi];
    };?>
<br />    <br />

<?
if (!empty($row[contents]))
{
	 echo "<div id='cnt2' style='display:none;'>";
	 echo "<a style='cursor:pointer;cursor:hand;' onclick=ch('off') title='скрыть оглавление'>скрыть оглавление</a>";
	 echo "</div>";
	 echo "<div id='cnt3' style='display:block;'>";
	 echo "<a style='cursor:pointer;cursor:hand;' onclick=ch('on') title='показать оглавление'>показать оглавление</a>";
	 echo "</div>";
	 echo "<div id='cnt' style='display:none;'>";
	 echo $row[contents];
	 echo "</div>";

}

if (!(trim($row[link])=="." || trim($row[link])=="_" || trim($row[link])=="-"))
   echo $row['link'];


?>

</div>
</div>

<?
$kw=trim($row[keyword]);
if(!empty($kw))
{
	echo "<hr />";
	$tmp = trim(str_replace("\n", " | ", trim($row[keyword])));
	if (count($tmp)==1)
	   $tmp = trim(str_replace("<br>", " | ", trim($row[keyword])));
	$tmp = explode (" | ", $tmp);
	for ($i=0; $i<count($tmp); $i++)
	   echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&key=".str_replace(' ', '_', $tmp[$i]).">".$tmp[$i]."</a> | ";
	echo "<br /><br /><br /><a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&tpubl_id=".$speid.
	     ">Найти похожие публикации</a>";
}
}



$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>