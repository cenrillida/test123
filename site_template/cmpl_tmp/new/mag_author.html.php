<?
global $DB,$_CONFIG, $site_templater;
// Выбран автор
if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[jid]=(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"];
$_REQUEST[jj]=(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"];
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);

if ($_SESSION[lang]=='/en')
{
   $suff="_en";
   $txt1='Articles in journal';
   $txt2='Articles in this issue';
   $txt3='More about author';
   $txt4='Articles by this Author';
    $orcidText = "Author's profile in ORCID";
}
else
{
   $suff="";   
   $txt1='Статьи в журнале';
   $txt2='Статьи в этом номере';
   $txt3='Подробнее об авторе';
   $txt4='Статьи автора';
    $orcidText = "Профиль автора в ORCID";

}
   $pg=new MagazineNew();


//print_r($rows);
$pr=new Persons();

if (!empty($_REQUEST[id]))
{
	if ($_SESSION[lang]!='/en')
		$pers0=$pr->getPersonsById($_REQUEST[id]);
	else	
	{
		$pers0=$pr->getPersonsByIdEn($_REQUEST[id]);
        if($_REQUEST['jj']==1669 && !empty($pers0[0]['LastName_EN']) && !empty($pers0[0]['Name_EN'])) {
            $pers0[0]['fullname'] = "{$pers0[0]['LastName_EN']} {$pers0[0]['Name_EN']}";
        }
	}

    if($pers0[0]['full_name_echo']==1) {
        $pers0[0]['fullname'] = $pers0[0]['name_surname'];
    }
	
}


	
//print_r($pers0);	
	//echo "__".$rows[0][title]." ".$rows[0]['journal_name'.$suff];
$site_templater->appendValues(array("TITLE" => " ".$txt4));//."<br />".$rows[0]['journal_name'.$suff]));
$site_templater->appendValues(array("TITLE_EN" => " ".$txt4));
$site_templater->appendValues(array("DESCRIPTION" => "Автор ".$pers0[0][fullname].". ".$txt1));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


// print_r($pers0);

if ($pers0[0][otdel]=="Умершие сотрудники") $span="<span  style='border:1px solid gray;'>";else $span="<span>";
if (!empty($pers0[0][picsmall]))
{
  echo "<h2><img hspace=10 align='absbottom' src=/dreamedit/foto/".$pers0[0][picsmall]." />".$span.$pers0[0][fullname]."</span>";
  if ($pers0[0][otdel]=="Умершие сотрудники")
   echo "<br /><span style='padding-left:100px;font-size:18px;'>".$pers0[0][dates]."</span>";
  echo "</h2>";
}
else
{
  echo "<h2 class='author'>".$span.$pers0[0][fullname]."</span>";
        if ($pers0[0][otdel]=="Умершие сотрудники")
   echo "<br /><span style='padding-left:100px;font-size:18px;'>".$pers0[0][dates]."</span>";
  echo "</h2>";
 }

  $sym=" ";
  If (!empty($pers0[0]['us']) && !empty($pers0[0]['uz']))
     $sym=", ";
  echo "<div class='pl-4 mb-2'>";
	  if (!empty($pers0[0]['ran'])) echo $pers0[0]['ran']."";
	  echo "<div>".str_replace(" ,","",$pers0[0]['us'].$sym.$pers0[0]['uz'])."</div>";

	  if (!empty($pers0[0]['about']))
          echo "<div>{$pers0[0]['about']}</div>";
	  echo   "</div>";
	   if ($pers0[0][otdel]!='Умершие сотрудники' && !empty($pers0[0][mail1]) && $pers0[0][mail1]!='no')
	     echo "mail-to: <a href='mailto:".$pers0[0][mail1]."'>".$pers0[0][mail1]."</a><br />";
	  
	//  echo "<div style='padding-left:86px;'>";
    if(!$pr->isClosed($pers0[0])) {
        echo "<a target='_blank' href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["PERSONA_PAGE"] . "&id=" . $pers0[0]["id"] . ">" .
            $txt3 . "</a>";
    }
//  echo "</div>";

if(!empty($pers0[0]["orcid"])) {
    echo "<div><a target='_blank' href=\"https://orcid.org/{$pers0[0]['orcid']}\">$orcidText <i class=\"fab fa-orcid\" style=\"color: #a5cd39\"></i></a></div>";
}
 
  echo "<div class='jrubric'>".$txt1.":</div>";

$rowsn=$pg->getAuthorsArticleById($pers0[0][id],$_REQUEST[jj]);
//print_r($people0);echo  $pers0[0][id];
foreach($rowsn as $row)
{

   $art0=$pg->getArticleById($row[page_id]);
   foreach($art0 as $art)
   {

   	  $nn=$pg->getMagazineByArticleId($art[page_id],null,null,null,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);
      if(!empty($nn[0][number_en]))
        $page_name_number_en = $nn[0][number_en];
      else
        $page_name_number_en = $nn[0][number];
//   	  print_r($nn);
   	  echo "<div class='jarticle'>";
      if ($_SESSION[lang]!='/en')
        $people0=$pg->getAutors($art[people]);
      else {
          $secondField = false;
          if($_REQUEST['jj']==1669) {
              $secondField = true;
          }
          $people0=$pg->getAutorsEn($art['people'],$secondField);
      }

       echo "<div class='autors'>";

       $autorBuilder = new AuthorBuilder($people0, $_REQUEST['page_id'], $_SESSION['lang'], false);
       $avtList = $autorBuilder->getAuthorRowWithLinks();
       echo $avtList;

       echo "</div>";
       if($_SESSION[jour_url]=="WER") {
           if ($_SESSION[lang]!='/en')
               echo "<div class='name'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art['name'.$suff].
                    " <br />(".$nn[0][number].")";
           else
               echo "<div class='name'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art['name'.$suff].
                        " <br />(".$nn[0][number].")";
       }
       else {
           	if($_SESSION[lang]!='/en')
           		$txtn='№ ';
           	else
           		$txtn='No ';
		   if($_REQUEST[jj]==1665 || $_REQUEST[jj]==1668) {
			   if (!is_numeric($nn[0][number]))
                   $txtn = '';
               else {
                   if($_SESSION[lang]!='/en')
                       $txtn = '№ ';
                   else
                       $txtn = 'No ';
               }
		   }
		   if ($_SESSION[lang]!='/en')
      	   echo "<div class='name'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art['name'.$suff].
      	        " <br />(".$txtn.$nn[0][number].". ". $nn[0][yyear].'. '.$nn[0][page_name].")";
      	   else
		   echo "<div class='name'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art['name'.$suff].
      	        " <br />(".$txtn.str_replace("т.","vol.",$page_name_number_en).". ". $nn[0][yyear].'. '.$nn[0][jname].")";
      }
     
       echo "</a></div>";
       echo "</div>";
   }
}

//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
