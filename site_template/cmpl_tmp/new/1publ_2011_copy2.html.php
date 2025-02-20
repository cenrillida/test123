<?

if($_SESSION[lang] == "")
{
	$lang_suf = "_RU";
	$txt_rub='Тематическая рубрика';
}
else
{
	$lang_suf = "_EN";
	$_REQUEST[en]=true;
	$txt_rub='Topical Term';
}
$pg=new Pages;
$ps=new Persons();
global $DB,$_CONFIG, $site_templater;
 if ($_SESSION[lang]!='/en')
   {
      $next_txt='следующая';
      $prev_txt='предыдущая';
      $delayed='отложить';
      $delayed2='Вы сохранили эту публикацию';
   }
   else
   {
   	  $next_txt='next';
      $prev_txt='previous';
      $delayed='save';
      $delayed2='You save this publication';
   }
///// НЕ ЗАБЫТЬ ВОССТНОВИТЬ СЧЕТЧИК!!!!
//Записать счетчик

$disp='block';$disp2='none';
if (!empty($_REQUEST[publ]))
{
   $pp=explode("|",$_REQUEST[publ]);
   if (in_array($_REQUEST[id],$pp))
   {
   	   $disp="none";$disp2="block";
   }
}
if (is_numeric($_REQUEST[useridext]))
{

 $rowsu=$DB->select("SELECT id,count_click  FROM  user_publ WHERE publ_id=".$_REQUEST[id]." AND user_id=".$_REQUEST[useridext]);
// print_r($rowsu);
 if (count($rowsu)>0)
 {
     $disp="none";$disp2="block";
     foreach($rowsu as $ru)
     {
          $DB->select("UPDATE user_publ SET count_click=".($ru[count_click]+1).
                      ",date_of=".date("Ymd").
          " WHERE publ_id=".$_REQUEST[id]." AND user_id=".$_REQUEST[useridext]);
     }

 }
}

$count0=$DB->select("SELECT id,publ_count FROM publ_stat WHERE publ_id=".$_REQUEST[id]." AND month=".date('m')." AND year=".date('Y'));
     $publ_count=$count0[0][publ_count]+1;

if (count($count0) >0)
    $DB->query("UPDATE publ_stat SET publ_count=".$publ_count.", date='".date(Ymd)."' WHERE id=".$count0[0][id]);
else
    $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year)
                   VALUES(0,".$_GET[id].",1,0,'".date(Ymd)."',".date('m').",".date('Y').")");

//////////////////

//if ($_SESSION[lang]!='/en')
//{
    if ($_SESSION[lang]!='/en')
	    $rows=$DB->select("SELECT name FROM publ WHERE id=".$_REQUEST[id]);
	else
	    $rows=$DB->select("SELECT IFNULL(name2,name) As name FROM publ WHERE id=".$_REQUEST[id]);


//}
//else
//{
//   $rows=$DB->select("SELECT icont_text AS name FROM adm_ilines_content WHERE el_id=".$_REQUEST[id]. " AND icont_var='title'");

//}


//echo strlen($rows[0][name]);
if(strlen($rows[0][name])>1000)
{

	$i0=strpos("*".$rows[0][name],".",70);
	if ($i0==0 || $i0>80)
	    $i0=strpos("*".$rows[0][name],"/",70);

	if ($i0==0 || $i0>80)
	    $i0=strpos("*".$rows[0][name],",",70);
	if ($i0==0 || $i0>80)
	    $i0=strpos("*".$rows[0][name]," ",70);
	if ($i0==0 || $i0>80) $i0=70;
	$nam=substr($rows[0][name],0,$i0)."...";
//	echo $i0.$nam;

}
else $nam00=split("/",$rows[0][name]);
$nam=$nam00[0];

if ($_SESSION[lang]!='/en')
$nam2="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a  href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID'].
	     ">К списку публикаций >></a>";
else
$nam2="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a  href=/en/publ.html".
	     ">To the list of publications >></a>";


$site_templater->appendValues(array("TITLE" => $nam));
$site_templater->appendValues(array("TITLE2" => $nam2));
if ($_SESSION[lang]!='/en')
{
	$rows=$DB->select("SELECT publ.*,CONCAT(publ.name,IF(publ.parent_id<>'',' // ',''),p2.name) AS namefull,p2.name AS main FROM publ 
	LEFT OUTER JOIN publ AS p2 ON p2.id=publ.parent_id 
	WHERE publ.id=".$_REQUEST[id]);
}
	else
{
	
	$rows=$DB->select("SELECT name2 as name,annots_en AS annots,keyword_en AS keyword,link_en AS link FROM publ WHERE id=".$_REQUEST[id]);
	
}
	$rows[0][name]=$rows[0][namefull];
//echo "<br />____".$rows[0][name];print_r($rows);
//$site_templater->appendValues(array("TITLE" => $rows[0][name]));
$site_templater->appendValues(array("DESCRIPTION" => strip_tags($rows[0][annots])));
$site_templater->appendValues(array("KEYWORDS" => str_replace("<br>",",",$rows[0][keyword])));
//$site_templater->appendValues(array("TITLE" => $rows[0][name]));

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
//echo "<br /><br /><br /><a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID'].
//	     ">К списку публикаций</a>";




?>
<script type='text/javascript'>

function ins_k(publ_id,date)
{

    var largeExpDate = new Date ();
    largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));
    var publ_list=getCookie('publ');
    if (strpos("|"+publ_list+"|","|"+publ_id+"|")>0) alert("Вы уже отложили эту публикацию");
    else
    {
     	setCookie('publ',publ_list+"|"+publ_id,largeExpDate);
     	setCookie('date_ins',date,largeExpDate);

    }
    document.getElementById('dl'+publ_id).style.display='none';
    document.getElementById('dll'+publ_id).style.display='block';

 //   alert(window.pageXOffset+" "+window.pageYOffset);
 //   window.scrollTo(0,window.pageYOffset);
 //   return false;
}
</script>
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
<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
<?
$speid=$_REQUEST['id'];

$avt = '';
//echo "<br />___________".$_TPL_REPLACMENT[FULL_ID];

if ($_SESSION[lang]!='/en')
$result=$DB->select(
         "SELECT publ.*,CONCAT(publ.name,IF(publ.parent_id<>'',' // ',''),IFNULL(p2.name,'')) AS name,p2.name AS main, 
		 publ.rubric2 AS rubric_id,
     IF(publ.vid<>0,CONCAT('<a href=/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&rub2=',rub.el_id,' title=\"Все публикации в этой рубрике\" >',rub.icont_text,'</a>'),'') AS rubric,
    CONCAT('<a href=/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&grub=',rub.el_id,' title=\"Все публикации в этой рубрике\" >',rub.icont_text,'</a>') AS t_gruppa,
     publ.annots, publ.keyword,
	 IF(publ.vid_inion>0,
	 CONCAT('<a href=/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&vi=',vi.el_id,' title=\"Все публикации этого вида\" >',vi.icont_text,'</a>'),'') AS vid_inion
	          FROM publ

		 INNER JOIN adm_directories_content AS vi ON vi.el_id=publ.vid AND vi.icont_var='text'
         INNER JOIN adm_directories_content AS t ON t.el_id=publ.tip AND t.icont_var='text'
		 LEFT OUTER JOIN adm_directories_content AS rub ON rub.el_id=publ.rubric2 AND rub.icont_var='text'
		 LEFT OUTER JOIN publ AS p2 ON p2.id=publ.parent_id 

                         WHERE publ.id=".$speid);
else
$result=$DB->select(
         "SELECT publ.*,CONCAT(publ.name,IF(publ.parent_id<>'',' // ',''),IFNULL(p2.name,'')) AS name,p2.name AS main, publ.rubric2 AS rubric_id,
     IF(publ.vid<>0,CONCAT('<a href=/en/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&rub2=',rub.el_id,' title=\"All publications in this category\" >',rub.icont_text,'</a>'),'') AS rubric,
    CONCAT('<a href=/en/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&grub=',rub.el_id,' title=\"All publications in this category\" >',rub.icont_text,'</a>') AS t_gruppa,

	 publ.annots_en AS annots, publ.keyword_en AS keyword,
	 IF(publ.vid_inion>0,
	 CONCAT('<a href=/en/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&vi=',vi.el_id,' title=\"All publications in this type\" >',vi.icont_text,'</a>'),'') AS vid_inion
	          FROM publ

		 INNER JOIN adm_directories_content AS vi ON vi.el_id=publ.vid AND vi.icont_var='text'
         INNER JOIN adm_directories_content AS t ON t.el_id=publ.tip AND t.icont_var='text'
		 LEFT OUTER JOIN adm_directories_content AS rub ON rub.el_id=publ.rubric2 AND rub.icont_var='value'
		 LEFT OUTER JOIN publ AS p2 ON p2.id=publ.parent_id 

                         WHERE publ.id=".$speid);


						 


// print_r($result);

foreach($result as $k=>$row)
{

// echo "<br />".$row[avtor]."@";
// Разборка авторов
$temp=explode("<br>",trim($row[avtor]));



$avtor_string;

$avtor_bib;

foreach($temp as $ii=>$avt)
{


    if (!empty($avt))
    {
      
	   if (is_numeric($avt))
       {

       $avtor=$ps->getAvtorById($avt);
       $avtor_string.="<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_A']."&id=".$avtor[0][id].">".
             $avtor[0][fullname]."</a>, ";
       $avtor_bib.=$avtor[0][fullname_bib]." and ";
       }
       else
       {

           if (trim($avt)!='Коллектив авторов')
           {
           		$a=explode("|",$avt);

           		if ($_SESSION[lang]!='/en')
           		{
	           		$avtor_string.=$a[0].", ";
//	           		$avtor_bib.="".$avt[0]." and ";
	           	}
	           	else
	           	{
	           		$avtor_string.=$a[1].", ";
//                    $avtor_bib.="".$a[1]." and ";
           }
        }
        }
      }
}
$avtor_string=substr($avtor_string,0,-2);
$avtor_bib=substr($avtor_bib,0,-5);
///////////////

//include_once "bib.php";
$bib=new BibEntry();
$aa=$bib->toCoinsMySQL($rows[0],$avtor_bib);
print_r($aa);
///////////////
// Картинка

if (!empty($result[0][picbig]) && $result[0][picbig]!='e_logo.jpg' && !isset($_REQUEST['new']))
 $pfoto = "<td><table border='1' cellspacing=0 cellpadding=0 bordercolor='#c6c5d0'><td>".
 "<img title='".$result[0][name]."'src=/dreamedit/pfoto/".$result[0][picbig]." height=240 width=180>".
 "</td></table></td>";
if (!empty($result[0][picbig]) && isset($_REQUEST['new']))
 $pfoto = "<td><table border='1' cellspacing=0 cellpadding=0 bordercolor='#c6c5d0'><td>".
 $result[0][picbig].
 "</td></table></td>";

 if (!empty($result[0][picmain]))
    $name_photo= $result[0][picmain];
 else
 {
     if ($_SESSION[lang]!='/en')	 $name_photo='e_logo_book.jpg';
	 else $name_photo='e_logo_book_en.jpg';
 }
 $pfoto= '    <td valign=top>


                                    <table cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td class="pic2_padd">
                                                <table cellspacing="0" cellpadding="0" border="0" align="center" class="pic_b">
                                                    <tbody>
                                                        <tr>
                                                            <td class="pic_r">
                                                            <div class="pic_t">
                                                            <div class="pic_l">
                                                            <div class="pic_tl">
                                                            <div class="pic_tr">
                                                            <div class="pic_bl">
                                                            <div class="pic_br">
                                                            <div class="width_100"><a href=#><img title="'.$result[0][name].'" src="/dreamedit/pfoto/'.$name_photo.'"  border="0"   /></a></div>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>';



?>
<br>
<!--- Основная таблица на странице  /-->
<table style='width:90%'>
<tr><td width=70% valign='top'>
<table><tr valign="top">

<? echo $pfoto;?>
<?
// pdf

if ($_SESSION[lang]=='/en') $row[link]=$row[link_en];
if (!(trim($row[link])=="." || trim($row[link])=="_" || trim($row[link])=="-"))
//print_r($row);
// Клики на pdf

if (strpos($row['link'],'/files/el/',0) >0)
{
//Записать счетчик
$count0=$DB->select("SELECT id,pdf_count FROM publ_stat WHERE publ_id=".$_REQUEST[id]." AND month=".date('m')." AND year=".date('Y'));
     $pdf_count=$count0[0][pdf_count]+1;
echo $count0[0][id]." ". $count0[0][pdf_count];
if (count($count0) >0)
    $DB->query("UPDATE publ_stat SET pdf_count=".$pdf_count.", date='".date(Ymd)."' WHERE id=".$count0[0][id]);
else
    $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year)
                   VALUES(0,".$_REQUEST[id].",1,1,'".date(Ymd)."',".date('m').",".date('Y').")");

 echo $row['link'];
}
else
{

if (strpos($row['link'],'href=',0) >0)
{
   $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]\.pdf/i";

   preg_match_all($filter,$row['link'],$res);

   for($i=0;$i<=count($res);$i++)
   {
      $row['link']=str_replace($res[0][$i],"/index.php?page_id=647&id=".$row[id]."&param=".str_replace(' ','^',$res[0][$i]),$row['link']);
   }

  
      echo $row['link'];
}
}
?>
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
<?
//print_r($row);
if ($row[hide_autor]!='on') echo "<em>".$avtor_string."</em><br />";
if ($_SESSION[lang]!='/en' || empty($row[name2]))
	echo "<strong>".str_replace("'",'`',str_replace('"','`',$row[name]))."</strong>";
if ($_SESSION[lang]=='/en' && !empty($row[name2]))
	echo "<strong>".str_replace("'",'`',str_replace('"','`',$row[name2]))."</strong>";


$ii = strpos($avtor_string,'Коллектив авторов',0);


echo '<br />';

if(!empty($avtor_string) && $row[hide_autor]!='on') {
if ($row[hide_autor] == 'on' && $ii==0)
   {
   echo "<br />";
   echo "<blockquote><b>Авторский коллектив:</b><br />";

     echo "<em>".$avtor_string."</em>";
   echo "</blockquote><br />";
}}


 if (!empty($row[vid_inion]))
   echo "<br />".$row[vid_inion]."<br />";

  if ($row[parent_id]>0)
   echo "<br />Открыть страницу публикации: <a href=/index.php?page_id=".$_REQUEST[page_id]."&id=".$row[parent_id].">".$row[main]."</a><br />";  
   
   if (!empty($row[rubric]) && $row[t_gruppa]!='Требует рубрицирования')
{

	echo "<br /><b>".$txt_rub.":</b>";
	echo "<br />".$row[t_gruppa];


}


   if ($_SESSION[lang]!='/en' || empty($row[annots_en]))
	   echo $row[annots];
	else echo $row[annots_en];

?>

<br />
<? echo "ISBN ".$row[izdat]; ?>
<br />    
<? 
if (!empty($row[rinc])) echo "<a href=".$row[rinc]." target=_blank>Размещено в РИНЦ </a>";
?>
<br />
<?
$rows2=$DB->select("SELECT id,name FROM publ WHERE parent_id=".$_REQUEST[id]." ORDER BY page_beg");
if (count($rows2)>0)
{
echo "<b>См. отдельные разделы: </b><ul>";
foreach($rows2 as $row2)
{
echo "<li><a href=/index.php?page_id=".$_REQUEST[page_id]."&id=".$row2[id]." title='открыть'>".$row2[name]."</a></li>";

}
echo "</ul>";

}


?>

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
?>

</td></tr></table>

<?

if ($_SESSION[lang]!='/en' || empty($row[keyword_en])) $keyword=$row[keyword]; else $keyword=$row[keyword_en];
// Убрать ключевые слова
//$keyword='';
$kw=trim($keyword);
if(!empty($kw))
{
	if ($_SESSION[lang]!='/en')
		echo "<br />Ключевые слова: ";
	else echo "<br />Keywords: ";
	$tmp = trim(str_replace("\n", ";", trim($keyword)));
	if (count($tmp)==1)
	   $tmp = trim(str_replace("<br>", ";", trim($keyword)));
	$tmp = explode (";", $tmp);
	for ($i=0; $i<count($tmp); $i++)
	   echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&key=".str_replace(' ', '_', $tmp[$i]).">".$tmp[$i]."</a> | ";

}

echo "<br />";
echo "<br />";
//echo "<div id='dl".$_REQUEST[id]."' style='display:".$disp.";'>&nbsp;</div>";
	 echo "<div id='dl".$_REQUEST[id]."' style='display:".$disp.";'><a style='cursor:hand;cursor:pointer;' onclick=ins_k(".$_REQUEST[id].",".date("Ymd").") >".$delayed."</a></div>";
     echo "<div id='dll".$_REQUEST[id]."' style='display:".$disp2.";'>".$delayed2."</div>";


}
?>
</td> <!-- Основной таблицы --> </tr><tr>
<td width=30% valign='top'>
<?
//Найти похожие


$pp=new Publications();
$publ0=$pp->RelatedPublications($_REQUEST[id],20);

//echo "<br />search=".$search_string;print_r($kw0);
    if ($_SESSION[lang]!='/en')
	    echo "<br /><hr /><b>ДРУГИЕ ПУБЛИКАЦИИ НА ЭТУ ТЕМУ:</b>";
	else echo "<br /><hr /><b>OTHER PUBLICATIONS ON THIS TOPIC</b>";

    $rtype='actual';
    foreach($publ0 as $publ)
    {

 //   	print_r($publ);
    	$sum=$publ[relevant0]+$publ[relevantn0]+$publ[relevanta0]+$publ[relevantk0]+
    	$publ[relevant1]+$publ[relevantn1]+$publ[relevanta1]+$publ[relevantk1]+
    	$publ[relevant2]+$publ[relevantn2]+$publ[relevanta2]+$publ[relevantk2]+
    	$publ[relevant3]+$publ[relevantn3]+$publ[relevanta3]+$publ[relevantk3]+$publ[relevant_vid];
    	if ($sum>0)
    	{
    	if ($publ[rtype]=='retro' && $rtype=='actual')
    	{

    		$rtype='retro';
    		if ($_SESSION[lang]!='/en')
	    		echo  "<hr /><b>РЕТРОСПЕКТИВА</b>";
	    	else echo "<hr /><b>RETROSPECTIVE</b>";
    	}
    	if ($publ[avthide]!='on' && $publ[avtor]!='Коллектив авторов' && strpos($publ[avtor],"Коллектив авторов")===false)
	 {

		 $avt=$pp->getAuthors($publ[avtor]);
		 echo "<br /><br />".$avt[0]."<br />";
	 }
	 else
	     echo "<br /><br />";
	 if ($_SESSION[lang]!='/en')
		 echo  "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[PUBL_PAGE]."&id=".$publ[id].
	       " title='".$publ[name].$publ[name2]."' >";
	 else
	     echo  "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[PUBL_PAGE]."&id=".$publ[id].
	       " title='".$publ[name].$publ[name2]."' >";

    if ($_SESSION[lang]!='/en' || empty($publ[name2]))
		 echo substr($publ[name],0,1000)."";
     else
		 echo substr($publ[name2],0,1000)."";
    //echo "<br />___".$avt[1];
//    $aa=$bib->toCoinsMySQL($publ,$avt[1]);
//	print_r($aa);
    }
    }
    if (count($publ0)>19)
    {
	    echo "<hr /><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&publid=".$_REQUEST[id]." style='text-decoration:underline;'>Еще публикации по теме</a>";
    }
?>
</td>
</tr>
</table>
<br /><br />
<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>