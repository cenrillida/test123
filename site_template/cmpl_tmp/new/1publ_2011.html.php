<?
/*

*/
if($_SESSION["lang"] != "/en")
{
	$lang_suf = "_RU";
	$txt_rub='�������';
  $txt_type='��� ����������';
  $relatedText = "��� ���������� �� ����";
}
else
{
	$lang_suf = "_EN";
	$_REQUEST[en]=true;
	$txt_rub='Rubric';
  $txt_type='Publication Type';
    $relatedText = "Related publications";
}
$pg=new Pages;
$ps=new Persons();
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[publ]=$DB->cleanuserinput($_REQUEST[publ]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);


 if ($_SESSION[lang]!='/en')
   {
      $next_txt='���������';
      $prev_txt='����������';
      $delayed='��������';
      $delayed2='�� ��������� ��� ����������';
   }
   else
   {
   	  $next_txt='next';
      $prev_txt='previous';
      $delayed='save';
      $delayed2='You save this publication';
   }
///// �� ������ ����������� �������!!!!
//�������� �������

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

//$count0=$DB->select("SELECT id,publ_count FROM publ_stat WHERE `module`='publ' AND publ_id=".$_REQUEST[id]." AND month=".date('m')." AND year=".date('Y'));
//     $publ_count=$count0[0][publ_count]+1;

//if (count($count0) >0)
//    $DB->query("UPDATE publ_stat SET publ_count=".$publ_count.", date='".date(Ymd)."' WHERE id=".$count0[0][id]);
//else
//    $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year,`module`)
//                   VALUES(0,".(int)$_GET[id].",1,0,'".date(Ymd)."',".date('m').",".date('Y').",'publ')");

//////////////////

//if ($_SESSION[lang]!='/en')
//{
    if ($_SESSION[lang]!='/en')
	    $rows=$DB->select("SELECT name,name_title FROM publ WHERE id=?d",$_REQUEST[id]);
	else
	    $rows=$DB->select("SELECT IFNULL(name2,name) As name FROM publ WHERE id=?d",$_REQUEST[id]);


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
	     ">� ������ ���������� >></a>";
else
$nam2="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a  href=/en/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID'].
	     ">To the list of publications >></a>";

if($rows[0][name_title]!="")
  $site_templater->appendValues(array("TITLE" => $rows[0][name_title]));
else
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
//	     ">� ������ ����������</a>";

if(!empty($_REQUEST[id])) {
    Statistic::ajaxCounter("publ", $_REQUEST[id]);
}



?>
<script type='text/javascript'>

function ins_k(publ_id,date)
{

    var largeExpDate = new Date ();
    largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));
    var publ_list=getCookie('publ');
    if (strpos("|"+publ_list+"|","|"+publ_id+"|")>0) alert("�� ��� �������� ��� ����������");
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
$speid=(int)$_REQUEST['id'];

$avt = '';
//echo "<br />___________".$_TPL_REPLACMENT[FULL_ID];

if ($_SESSION[lang]!='/en')
$result=$DB->select(
         "SELECT publ.*,CONCAT(publ.name,IF(publ.parent_id<>'',' // ',''),IFNULL(p2.name,'')) AS name,p2.name AS main, 
     rub.icont_text AS rubric_name,
     rub2.icont_text AS rubric2_name,
     publ.annots, publ.keyword,
	 IF(publ.vid_inion>0,
	 CONCAT('<a href=/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&vid=',vi.el_id,' title=\"��� ���������� ����� ����\" >',vi.icont_text,'</a>'),'') AS vid_inion, vi.icont_text AS vid_text, vi.el_id AS vid_id
	          FROM publ

		 INNER JOIN adm_directories_content AS vi ON vi.el_id=publ.vid AND vi.icont_var='text'
         INNER JOIN adm_directories_content AS t ON t.el_id=publ.tip AND t.icont_var='text'
         LEFT OUTER JOIN adm_directories_content AS rub ON rub.el_id=publ.rubric AND rub.icont_var='text'
		 LEFT OUTER JOIN adm_directories_content AS rub2 ON rub2.el_id=publ.rubric2 AND rub2.icont_var='text'
		 LEFT OUTER JOIN publ AS p2 ON p2.id=publ.parent_id 

                         WHERE publ.id=".$speid);
else
$result=$DB->select(
         "SELECT publ.*,CONCAT(publ.name,IF(publ.parent_id<>'',' // ',''),IFNULL(p2.name,'')) AS name,p2.name AS main,
          rub.icont_text AS rubric_name,
     rub2.icont_text AS rubric2_name,

	 publ.annots_en AS annots, publ.keyword_en AS keyword,
	 IF(publ.vid_inion>0,
	 CONCAT('<a href=/en/index.php?page_id=',".$_TPL_REPLACMENT[FULL_ID].",'&vid=',vi.el_id,' title=\"All publications in this type\" >',vi.icont_text,'</a>'),'') AS vid_inion, vi.icont_text AS vid_text, vi.el_id AS vid_id
	          FROM publ

		 INNER JOIN adm_directories_content AS vi ON vi.el_id=publ.vid AND vi.icont_var='text_en'
         INNER JOIN adm_directories_content AS t ON t.el_id=publ.tip AND t.icont_var='text'
		 LEFT OUTER JOIN adm_directories_content AS rub ON rub.el_id=publ.rubric AND rub.icont_var='value'
         LEFT OUTER JOIN adm_directories_content AS rub2 ON rub2.el_id=publ.rubric2 AND rub2.icont_var='value'
		 LEFT OUTER JOIN publ AS p2 ON p2.id=publ.parent_id 

                         WHERE publ.id=".$speid);


						 


// print_r($result);

foreach($result as $k=>$row)
{

// echo "<br />".$row[avtor]."@";
// �������� �������
$temp=explode("<br>",trim($row[avtor]));



$avtor_string;
$avtor_citat_string = "";

$avtor_bib;

foreach($temp as $ii=>$avt)
{


    if (!empty($avt))
    {
      
	   if (is_numeric($avt))
       {

       $avtor=$ps->getAvtorById($avt);
       if($ps->isClosed($avtor[0])) {
           $avtor_string.= $avtor[0][fullname].", ";
       } else {
           $avtor_string.="<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_A']."&id=".$avtor[0][id].">".
               $avtor[0][fullname]."</a>, ";
       }
       $avtor_bib.=$avtor[0][fullname_bib]." and ";
       if(!empty($avtor_citat_string))
        $avtor_citat_string.=", ";
       //$avtor_citat_string.=$avtor[0][fullname_cit];

           if($row['name']==$row['name2']) {
               if($avtor[0]['full_name_echo']==1) {
                   $avtor_citat_string.=$avtor[0]['Autor_en'];
               } else {
                   $avtor_citat_string .= mb_stristr($avtor[0]['Autor_en'], " ", true) . " " . substr(mb_stristr($avtor[0]['Autor_en'], " "), 1, 1) . ".";
               }
           } else {
               $avtor_citat_string.=$avtor[0][fullname];
           }

       }
       else
       {

           if (trim($avt)!='��������� �������')
           {
           		$a=explode("|",$avt);

           		if ($_SESSION[lang]!='/en')
           		{
	           		$avtor_string.=$a[0].", ";
                if(!empty($avtor_citat_string))
                  $avtor_citat_string.=", ";
                $avtor_citat_string.=$a[0];
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
// ��������

if (!empty($result[0][picbig]) && $result[0][picbig]!='e_logo.jpg' && !isset($_REQUEST['new']))
 $pfoto = "<td><table border='1' cellspacing=0 cellpadding=0 bordercolor='#c6c5d0'><td>".
 "<img title='".$result[0][name]."'src=/dreamedit/pfoto/".$result[0][picbig]." height=240 width=180>".
 "</td></table></td>";
if (!empty($result[0][picbig]) && isset($_REQUEST['new']))
 $pfoto = "<td><table border='1' cellspacing=0 cellpadding=0 bordercolor='#c6c5d0'><td>".
 $result[0][picbig].
 "</td></table></td>";

 if (!empty($result[0][picsmall]))
    $name_photo= $result[0][picsmall];
 else
 {
     if ($_SESSION[lang]!='/en')	 
      {
        switch ($result[0][tip]) {
          case 441:
            $name_photo='e_logo_book.jpg';
            break;
          case 442:
            $name_photo='e_logo_journal.jpg';
            break;
          case 443:
            $name_photo='e_logo_electronic.jpg';
            break;
          
          default:
          $name_photo='e_logo_book.jpg';
          break;
        }
      }
	 else 
    {
      switch ($result[0][tip]) {
          case 441:
            $name_photo='e_logo_book_en.jpg';
            break;
          case 442:
            $name_photo='e_logo_journal_en.jpg';
            break;
          case 443:
            $name_photo='e_logo_electronic_en.jpg';
            break;
          
          default:
          $name_photo='e_logo_book.jpg';
          break;
        }
    }
 }
 if (!empty($result[0][picbig]))
    $big_photo= $result[0][picbig];
 else
 {
   if ($_SESSION[lang]!='/en')   
      {
        switch ($result[0][tip]) {
          case 441:
            $big_photo='e_logo_book.jpg';
            break;
          case 442:
            $big_photo='e_logo_journal.jpg';
            break;
          case 443:
            $big_photo='e_logo_electronic.jpg';
            break;
          
          default:
          $big_photo='e_logo_book.jpg';
          break;
        }
      }
   else 
    {
      switch ($result[0][tip]) {
          case 441:
            $big_photo='e_logo_book_en.jpg';
            break;
          case 442:
            $big_photo='e_logo_journal_en.jpg';
            break;
          case 443:
            $big_photo='e_logo_electronic_en.jpg';
            break;
          
          default:
          $big_photo='e_logo_book.jpg';
          break;
        }
    }
 }

 $pfoto= '<p><img title="'.$result[0][name].'" src="/dreamedit/pfoto/'.$big_photo.'" name="example_img" border="0" /></p>';



?>
<br>
<!--- �������� ������� �� ��������  /-->
<div class="container-fluid">
<div class="row">
<div class="col-12 col-md-3 text-center">
<? echo $pfoto;?>
<?
// pdf

if ($_SESSION[lang]=='/en') $row[link]=$row[link_en];
if (!(trim($row[link])=="." || trim($row[link])=="_" || trim($row[link])=="-"))
//print_r($row);
// ����� �� pdf

if (strpos($row['link'],'/files/el/',0) >0)
{
//�������� �������
$count0=$DB->select("SELECT id,pdf_count FROM publ_stat WHERE `module`='publ' AND publ_id=".$_REQUEST[id]." AND month=".date('m')." AND year=".date('Y'));
     $pdf_count=$count0[0][pdf_count]+1;
echo $count0[0][id]." ". $count0[0][pdf_count];
if (count($count0) >0)
    $DB->query("UPDATE publ_stat SET pdf_count=".$pdf_count.", date='".date(Ymd)."' WHERE id=".$count0[0][id]);
else
    $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year,`module`)
                   VALUES(0,".$_REQUEST[id].",1,1,'".date(Ymd)."',".date('m').",".date('Y').",'publ')");

 echo $row['link'];
}
else
{

if (strpos($row['link'],'href=',0) >0)
{
    $row['link'] = str_replace("\"/files","\"https://imemo.ru/files",$row['link']);

   $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]\.pdf/i";

   preg_match_all($filter,$row['link'],$res);

   for($i=0;$i<=count($res);$i++)
   {
      $row['link']=str_replace($res[0][$i],"/index.php?page_id=647&module=publ&id=".$row[id]."&param=".str_replace(' ','^',$res[0][$i]),$row['link']);
   }

    $row['link'] = preg_replace("/<img[^>]+src=\"(https?:\/\/(www\.)?imemo\.ru)?\/files\/Image\/pdf\.gif\"[^>]*\/? ?> ?(&nbsp;)?/i","<i class=\"far fa-file-pdf text-danger\"></i> ",$row['link']);
    $row['link'] = preg_replace("/<img[^>]+src=\"(https?:\/\/(www\.)?imemo\.ru)?\/files\/Image\/internet_explorer\.png\"[^>]*\/? ?> ?(&nbsp;)?/i","",$row['link']);



    echo $row['link'];
}
}
?>
</div>
<div class="col-12 col-md-9">
<?
//print_r($row);
if ($row[hide_autor]!='on') echo "<em>".$avtor_string."</em><br />";
if ($_SESSION[lang]!='/en' || empty($row[name2]))
	echo "<strong>".str_replace("'",'`',str_replace('"','`',$row[name]))."</strong>";
if ($_SESSION[lang]=='/en' && !empty($row[name2]))
	echo "<strong>".str_replace("'",'`',str_replace('"','`',$row[name2]))."</strong>";


$ii = strpos($avtor_string,'��������� �������',0);


echo '<br />';

if(!empty($avtor_string) && $row[hide_autor]!='on') {
if ($row[hide_autor] == 'on' && $ii==0)
   {
   echo "<br />";
   echo "<blockquote><b>��������� ���������:</b><br />";

     echo "<em>".$avtor_string."</em>";
   echo "</blockquote><br />";
}}


 //if (!empty($row[vid_inion]))
 //  echo "<br />".$row[vid_inion]."<br />";

  if ($row[parent_id]>0)
   echo "<br />������� �������� ����������: <a href=/index.php?page_id=".$_REQUEST[page_id]."&id=".$row[parent_id].">".$row[main]."</a><br />";  

   if (!empty($row[vid_text]))
{

  echo "<div class='mt-4'><b>".$txt_type.":</b></div>";
  echo "<div><a href=\"".$_SESSION["lang"]."/index.php?page_id=732&vid=".$row[vid_id]."\">".$row[vid_text]."</a></div>";


}

if((!empty($row['rubric']) && $row['rubric']!=466) || (!empty($row['rubric2']) && $row['rubric2']!=466)) {
    echo "<div class='mt-4'><b>$txt_rub:</b></div>";

    if(!empty($row['rubric']) && $row['rubric']!=466) {
        echo "<div><a href=\"{$_SESSION["lang"]}/index.php?page_id={$_TPL_REPLACMENT['FULL_ID']}&rubric={$row['rubric']}\">{$row['rubric_name']}</a></div>";
    }
    if(!empty($row['rubric2']) && $row['rubric2']!=466) {
        echo "<div><a href=\"{$_SESSION["lang"]}/index.php?page_id={$_TPL_REPLACMENT['FULL_ID']}&rubric={$row['rubric2']}\">{$row['rubric2_name']}</a></div>";
    }
}

if(!empty($row[izdat]))
{
  if($row[tip]==441)
  echo "<br /><br />ISBN ".$row[izdat]; 
  
  if($row[tip]==442)
  echo "<br /><br />ISSN ".$row[izdat];

    if($row[tip]==443) {
        $electronic_resource_izdat="ISBN";

        if(preg_match("/(^[0-9]{4}+)-([0-9]{4}+$)/",$row[izdat]))
            $electronic_resource_izdat="ISSN";
        echo "<br /><br />".$electronic_resource_izdat." " . $row[izdat];
    }
}?>
<? if(!empty($row[doi]))
{
  echo "<br /><br />DOI ".$row[doi]."<br /><br />";
} elseif(!empty($row[izdat]) && ($row[tip]==441 || $row[tip]==442 || $row[tip]==443)) echo "<br /><br />";?>
<?


   if ($_SESSION[lang]!='/en' || empty($row[annots_en]))
	   echo $row[annots];
	else echo $row[annots_en];

?>

<?
$rows2=$DB->select("SELECT id,name FROM publ WHERE parent_id=".$_REQUEST[id]." ORDER BY page_beg");
if (count($rows2)>0)
{
echo "<b>��. ��������� �������: </b><ul>";
foreach($rows2 as $row2)
{
echo "<li><a href=/index.php?page_id=".$_REQUEST[page_id]."&id=".$row2[id]." title='�������'>".$row2[name]."</a></li>";

}
echo "</ul>";

}


?>

<?
if (!empty($row[contents]))
{
	 echo "<div id='cnt2' style='display:none;'>";
	 echo "<a style='cursor:pointer;cursor:hand;' onclick=ch('off') title='������ ����������'>������ ����������</a>";
	 echo "</div>";
	 echo "<div id='cnt3' style='display:block;'>";
	 echo "<a style='cursor:pointer;cursor:hand;' onclick=ch('on') title='�������� ����������'>�������� ����������</a>";
	 echo "</div>";
	 echo "<div id='cnt' style='display:none;'>";
	 echo $row[contents];
	 echo "</div>";

}
?>

</div></div>
<div class="row">
    <div class="col">
<?

if ($_SESSION[lang]!='/en' || empty($row[keyword_en])) $keyword=$row[keyword]; else $keyword=$row[keyword_en];
// ������ �������� �����
//$keyword='';
$kw=trim($keyword);
if(!empty($kw))
{
	if ($_SESSION[lang]!='/en')
		echo "<br />�������� �����: ";
	else echo "<br />Keywords: ";
	$tmp = trim(str_replace("\n", ";", trim($keyword)));
	if (count($tmp)==1)
	   $tmp = trim(str_replace("<br>", ";", trim($keyword)));
	$tmp = explode (";", $tmp);
	for ($i=0; $i<count($tmp); $i++)
	   echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&key=".str_replace(' ', '_', $tmp[$i]).">".$tmp[$i]."</a> | ";

}

?>
<br />
<br />
<? 
if ($_SESSION[lang]!='/en' && !empty($row[rinc])) echo "<a href=".$row[rinc]." target=_blank>��������� � ���� </a><br /><br />";
if ($_SESSION[lang]=='/en' && !empty($row[rinc])) echo "<a href=".$row[rinc]." target=_blank>Russian Science Citation Index </a><br /><br />";
?>
<?

if ($_SESSION[lang]!='/en') {
    if($row['vid_id']!=428 || $row['year']!=2020) {
        echo "<div style=\"background-color: #EEE9E9; color: grey; padding: 0 10px;\"><br />������ ��� �����������: <br /><br />";
        if ($row[hide_autor] != "on")
            if (!empty($avtor_citat_string)) echo $avtor_citat_string . " ";

        $slashes_pos = mb_stripos($row[name], "//");

        if ($slashes_pos !== FALSE) {
            if (substr($row[name], $slashes_pos - 6, 6) == 'https:' || substr($row[name], $slashes_pos - 5, 5) == 'http:')
                echo $row[name] . '<br /></div>';
            else {
                echo $row[name_title];
                if (substr($row['name_title'], -1) != '.') {
                    echo ".";
                }
                echo " � " . substr($row[name], $slashes_pos + 3) . "<br /></div>";
            }
        } else {
            echo $row[name] . '<br /></div>';
        }
        echo "<br />";
        echo "<br />";
    }
}

//echo "<div id='dl".$_REQUEST[id]."' style='display:".$disp.";'>&nbsp;</div>";
	 //echo "<div id='dl".$_REQUEST[id]."' style='display:".$disp.";'><a style='cursor:hand;cursor:pointer;' onclick=ins_k(".$_REQUEST[id].",".date("Ymd").") >".$delayed."</a></div>";
     //echo "<div id='dll".$_REQUEST[id]."' style='display:".$disp2.";'>".$delayed2."</div>";


}
?>
<?
//����� �������


$pp=new Publications();
$publ0=$pp->RelatedPublications($_REQUEST[id],20);

//echo "<br />search=".$search_string;print_r($kw0);
    if ($_SESSION[lang]!='/en')
	    echo "<br /><hr /><b>������ ���������� �� ��� ����:</b>";
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
	    		echo  "<hr /><b>�������������</b>";
	    	else echo "<hr /><b>RETROSPECTIVE</b>";
    	}
    	if ($publ[avthide]!='on' && $publ[avtor]!='��������� �������' && strpos($publ[avtor],"��������� �������")===false)
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

     echo "</a>";
    //echo "<br />___".$avt[1];
//    $aa=$bib->toCoinsMySQL($publ,$avt[1]);
//	print_r($aa);
    }
    }
    if (count($publ0)>19)
    {
	    echo "<hr /><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&publid=".$_REQUEST[id]." style='text-decoration:underline;'>{$relatedText}</a>";
    }
?>
    </div>
</div>
</div>
<br /><br />
<?

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>