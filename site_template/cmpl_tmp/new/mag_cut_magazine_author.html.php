<?
global $DB,$_CONFIG, $site_templater;
// ������ �����
if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[jid]=(int)$DB->cleanuserinput($_REQUEST[jid]);
$_REQUEST[jj]=(int)$DB->cleanuserinput($_REQUEST[jj]);
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);

if ($_SESSION[lang]=='/en')
{
   $suff="_en";
   $txt1='Articles in journal';
   $txt2='Articles in this issue';
   $txt3='More about author';
   $txt4='Articles by this Author';
}
else
{
   $suff="";   
   $txt1='������ � �������';
   $txt2='������ � ���� ������';
   $txt3='��������� �� ������';
   $txt4='������ ������';
}
   $pg=new Magazine(); 
if (empty($_REQUEST[jid])) $_REQUEST[jid]=$_SESSION[jour_id];
if (empty($_REQUEST[jid])) //����� ������ ����� �������
{

  $jid0=$pg->getMagazineJId($_REQUEST[page_id]);
				$jid=$jid0[0][journal];
  $jid0=$pg->getLastMagazineNumber($jid0[0][journal]);



  $_REQUEST[jid]=$jid0[0][page_id];
  $_REQUEST[jj]=$jid0[0][journal];

}
//echo $_REQUEST[jid]." #" .$_REQUEST[jj];
if (empty($_REQUEST[jj])) $_REQUEST[jj]=$_SESSION[jour_id];
if (empty($_REQUEST[jj]))
{
	$jid0=$DB->select("SELECT journal FROM adm_article WHERE page_id=".$_REQUEST[jid]);
    $_REQUEST[jj]=$jid0[0][journal];

}


// ������������ �������� ������

$rows=$DB->select("SELECT
                     CONCAT(m.page_name,'. � ',a.page_name,' ',a.year) AS title,
					 m.page_name AS journal_name,m.page_name_en AS journal_name_en,
					 a.journal,
					 CONCAT(m.page_name_en,'. No ',a.page_name,' ',a.year) AS title_en
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
                     WHERE a.page_id=".$_REQUEST[jid]);
//print_r($rows);
$pr=new Persons();

if (!empty($_REQUEST[id]))
{
	if ($_SESSION[lang]!='/en')
		$pers0=$pr->getPersonsById($_REQUEST[id]);
	else	
	{
		$pers0=$pr->getPersonsByIdEn($_REQUEST[id]);

	}
	
	}
	
//print_r($pers0);	
	//echo "__".$rows[0][title]." ".$rows[0]['journal_name'.$suff];
$site_templater->appendValues(array("TITLE" => " ".$txt4));//."<br />".$rows[0]['journal_name'.$suff]));
$site_templater->appendValues(array("TITLE_EN" => " ".$txt4));
$site_templater->appendValues(array("DESCRIPTION" => "����� ".$pers0[0][fullname].". ".$txt1." ".$rows[0]['journal_name'.$suff]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


// print_r($pers0);

if ($pers0[0][otdel]=="������� ����������") $span="<span  style='border:1px solid gray;'>";else $span="<span>";
if (!empty($pers0[0][picsmall]))
{
  echo "<h2><img hspace=10 align='absbottom' src=/dreamedit/foto/".$pers0[0][picsmall]." />".$span.$pers0[0][fullname]."</span>";
  if ($pers0[0][otdel]=="������� ����������")
   echo "<br /><span style='padding-left:100px;font-size:18px;'>".$pers0[0][dates]."</span>";
  echo "</h2>";
}
else
{
  echo "<h2 class='author'>".$span.$pers0[0][fullname]."</span>";
        if ($pers0[0][otdel]=="������� ����������")
   echo "<br /><span style='padding-left:100px;font-size:18px;'>".$pers0[0][dates]."</span>";
  echo "</h2>";
 }

  $sym=" ";
  If (!empty($pers0[0][us]) && !empty($pers0[0][uz]))
     $sym=", ";
  echo "<div style='padding-left:46px;margin-top:-20px;'>";
	  if (!empty($pers0[0][ran])) echo "<br />".$pers0[0][ran]."";
	  echo "<br />".str_replace(" ,","",$pers0[0][us].$sym.$pers0[0][uz])."<br />";
	  if (!empty($pers0[0][rewards])) echo $pers0[0][rewards]."<br />";
	  if ($pers0[0][work]!='��������' && $pers0[0][dolj]!='��������� ������ �����������' && $pers0[0][otdel]!='������� ����������' && $pers0[0][otdel] <> "����" && $pers0[0][otdel] <> "������")
	     echo $pers0[0][work]."<br />".$pers0[0][dolj];
	  if ($pers0[0][work]=='��������' || $pers0[0][dolj]=='��������� ������ �����������')
	     echo $pers0[0][work];
	  if (!empty($pers0[0][about])) echo $pers0[0][about]."<br />";
	  echo   "</div>";
	   if ($pers0[0][otdel]!='������� ����������' && !empty($pers0[0][mail1]) && $pers0[0][mail1]!='no')
	     echo "mail-to: <a href='mailto: '".$pers0[0][mail1].">".$pers0[0][mail1]."</a><br />";
	  
	//  echo "<div style='padding-left:86px;'>";
	  echo "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_PAGE]."&id=".$pers0[0][id].">".
	  $txt3."</a>";
//  echo "</div>";

 $rowns=$pg->getMagazineNumber($_REQUEST[jid]);
 
//print_r($rowns);
// if (count($rowns)>0)
// echo "<div class='jrubric'>".$txt2." (".$rows[0]['title'.$suff]."):</div>";
$iii=0;

  foreach($rowns as $k=>$row)
  {
  if (strpos($row[people],">".$pers0[0][id]."<")>0 ||substr($row[people],0,strlen($pers0[0][id])+1)==$pers0[0][id]."<")

  {

     if ($iii==0)
	 {
	  echo "<div class='jrubric'>".$txt2." (".$rows[0]['title'.$suff]."):</div>";
	  $iii=1;
	 
	 }
         echo "<div class='jarticle'>";
		 if ($_SESSION[lang]!='/en')
      	   $people0=$pg->getAutors($row[people]);
		 else  
      	   $people0=$pg->getAutorsEn($row[people]);

		 echo "<div class='autors'>";

     $str_avt="";
      	   foreach($people0 as $people)
      	   {
              if(!empty($people['fio']))
              $str_avt.= "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&id=".$pers0[0][id].">".$people['fio']."</a>, "; //.$people[work].",".$people[mail1]."";
      	   }
           $str_avt=substr($str_avt, 0,-2);

           echo $str_avt;

      	   echo "</div>";
      	   echo "<div class='name'><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&at=a&pid=".$people[id].">".$row['name'.$suff]."</a></div>";
      	   echo "</div>";

	}
  }
 
  echo "<div class='jrubric'>".$txt1.":</div>";
$rowsn=$pg->getAuthorsArticleById($pers0[0][id],$_REQUEST[jj]);
//print_r($people0);echo  $pers0[0][id];
foreach($rowsn as $row)
{

   $art0=$pg->getArticleById($row[page_id]);
   foreach($art0 as $art)
   {

   	  $nn=$pg->getMagazineByArticleId($art[page_id]);
//   	  print_r($nn);
   	  echo "<div class='jarticle'>";
      	  if ($_SESSION[lang]!='/en') 
			$people0=$pg->getAutors($art[people]);
		  else
            $people0=$pg->getAutorsEn($art[people]);		  
		 
      	   echo "<div class='autors'>";
               $str_avt="";
      	   foreach($people0 as $people)
      	   {
      	      if(!empty($people['fio']))
              $str_avt.= "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&id=".$people[id].">".$people['fio']."</a>, "; //.$people[work].",".$people[mail1]."";
      	   }
          $str_avt=substr($str_avt, 0,-2);

           echo $str_avt;
      	   echo "</div>";
		   if ($_SESSION[lang]!='/en')
      	   echo "<div class='name'><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$art[page_id]."&at=a&pid=".$people[id].">".$art['name'.$suff].
      	        " <br />(� ".$nn[0][number].". ". $nn[0][yyear].'. '.$nn[0][page_name].")";
      	   else
		   echo "<div class='name'><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$art[page_id]."&at=a&pid=".$people[id].">".$art['name'.$suff].
      	        " <br />(No ".$nn[0][number].". ". $nn[0][yyear].'. '.$nn[0][jname].")";
     
		   echo "</a></div>";
      	   echo "</div>";
   }
}

//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
