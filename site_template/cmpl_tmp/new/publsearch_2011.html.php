<?

// Форма подбора публикаций


global $DB,$_CONFIG, $site_templater;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


?>
<script language="JavaScript">
function check_email(input) {
  var filter = /^[0-9]/;
  var err = true;

  for (var i = 0; i < input.length; i++) {
      var chr = input.charAt(i);
      if(!filter.test(chr)) err=false;
  }
  return(err);
}
 function MyFBCheck() {

    if (document.publ.other_year.value !="") {
       var err=false;
       if (document.publ.other_year.value.length < 4) err=true;
       if  (!check_email(document.publ.other_year.value))  err=true;
       if (document.publ.other_year.value < 1960 || document.publ.other_year.value > 2020) err=true;
       if (err) {
           alert("Не правильно указан год выпуска");
           return false;
       }
    }
 //if (document.publ.name.value == '')return false;
 //else return true;
   return true;
}
</script>
<?
if ($_SESSION[lang]!='/en') $suff="";else $suff="_en";
////////////// Авторы
//////
if($_SESSION[lang]!='/en')
  $rowsa=$DB->select(
         "SELECT  id,fio,fio_en FROM
			(
			SELECT '0' AS id,avtor AS fio,avtor AS fio_en FROM publ
			UNION
			 SELECT p.id,
			 CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio,
			 autor_en AS fio_en
			 FROM persons AS p
			INNER JOIN publ ON avtor LIKE CONCAT(p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id)
			) AS t
			");
else
    $rowsa=$DB->select(
        "SELECT  id,fio,fio_en FROM
			(
			SELECT '0' AS id,avtor AS fio,avtor AS fio_en FROM publ
			UNION
			 SELECT p.id,
			 autor_en AS fio,
			 autor_en AS fio_en
			 FROM persons AS p
			INNER JOIN publ ON avtor LIKE CONCAT(p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id)
			) AS t
			");
//  print_r($rowsa);
			
  foreach($rowsa as $row)
  {
  	 if ($row[id]!=0)
  	 {
  	     if (substr($row[fio][fio],0,1)<="Z")
  	     {
  	        $fio_en[$row[fio]][id]=$row[id];
  	     	$fio_en[$row[fio]][fio]=$row[fioshort];
  	     }
  	     else
  	     {
  	     	$fio[$row[fio]][id]=$row[id];
  	     	$ff=explode("|",$row[fio]);
			$fio[$row[fio]][fio]=$ff[0];
			$fio_en[$row[fio]][fio]=$ff[1];
  	     }
  	 }
  	 else
  	 {
  	 	$str0=explode("<br>",$row[fio]);
//  	 	echo "<hr />".$row[fio];

  	 	foreach($str0 as $str)
  	 	{
  	 		$t=trim($str);

  	 		if (!empty($t) && $t!='Коллектив авторов')
  	 		   if (!is_numeric($t))
  	 		   {
                  if (substr($t,0,1)<="Z")
                     $fio_en[$t][id]=0;
                  else
  	 			     $fio[$t][id]=0;
//  	 			  $fio[$t][fio]=$t;
               }
  	 	}
  	 }
  }

  ksort($fio);
  ksort($fio_en);

////////////
//print_r($fio);
echo $_TPL_REPLACMENT[CONTENT];

echo "<br />";
$pg = new Pages();
//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");

if ($_GET[search]=="поиск...") $_GET[search]="";
$_GET[search]=str_replace("_"," ",$_GET[search]);
//<form name=publ method=get action='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&sr' onSubmit='return MyFBCheck()'>
$text='Текст';
$author='Автор';
$vid_publ='Вид публикации';
$type_publ='Тип публикации';
$clue_words='Ключевые слова';
$year_publ='Год издания';
$full_text='Есть полный текст';
$search_text='Искать';
$vid_all='все';
if($_SESSION[lang]=='/en'){
    $text='Text';
    $author='Author';
    $vid_publ='Publication Views';
    $type_publ='Type of publication';
    $clue_words='Keywords';
    $year_publ='Publishing year';
    $full_text='There is a full text';
    $search_text='Search';
    $vid_all='all';
}
echo "

<form class='search-publ-form' name=publ method=get action='".$_SESSION[lang]."/index.php' onSubmit='return MyFBCheck()'>
<input style='display: none' type='hidden' name='page_id' value='732'>
<input name=ps type=hidden value=1>


     
       <table cellspacing='2' cellpadding='1'> ";
echo "
      <tr><td> <b>".$text."</b></td>
      <td> <input style=font-size='13px' name='name' type=text size='69' value=".$_REQUEST[search]."></td></tr>";
echo "<tr><td> <b>".$author."</b></td><td>";
//<input size='29'  style=font-size='13px' name=fio type=text>

echo "<select name='fio'>";
echo "<option value=''></option>";

if($_SESSION[lang]!="/en")
foreach ($fio as $ff => $f) {

    if ($f[id] != 0)
        echo "<option 	value=\"" . $f[id] . "\">" . $ff . "</option>";
    else
        echo "<option 	value=\"" . $ff . "\">" . $ff . "</option>";

}
foreach($fio_en as $ff=>$f)
{
  if ($f[id]!=0)
     echo "<option 	value=\"".$f[id]."\">".$ff."</option>";
  else
     echo "<option 	value=\"".$ff."\">".$ff."</option>";

}
echo "</select>";
echo "</td></tr>";

echo
      "<tr><td> <b>".$vid_publ."</b> </td><td>
      <select name='vid' style=font-size='13px' >
      <option value=''>".$vid_all."</option>";
      $buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS text FROM adm_directories_content AS c
                   INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=19 
				   INNER JOIN adm_directories_content AS ss ON ss.el_id=c.el_id AND ss.icont_var='sort' 
				   WHERE c.icont_var='text".$suff."'
				   ORDER BY ss.icont_text");

      foreach ($buffer as $i=>$vid)
      {

         echo "<option value='".$vid[id]."'>".$vid[text]."</option>";

      }
echo "
      </select></td></tr>
      <tr><td> <strong>ISBN</strong></td>
      <td> <input style=font-size='13px' name=isbn type=text size='29'></td></tr>";

echo "<tr>";
$i=0;

   echo "<td><strong>".$type_publ."</string></td><td>";
        echo " <select name='type' style=font-size='13px'>
         <option value=''>".$vid_all."</option>";
 //     $cch=$pg->getChilds(280,true);
    $rub0=$DB->select("SELECT c.el_id AS id,c.icont_text AS text FROM adm_directories_content AS c
                   INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=21 
				   WHERE c.icont_var='text".$suff."' 
				   ORDER BY id");
     foreach($rub0 as $rubrica)
     {
	 echo "<option value='".$rubrica[id]."'>".$rubrica[text]."</option>";
     }


      echo "</select></td></tr>";

// Ключевые слова
echo "<tr><td colspan='2'>&nbsp;</td></tr>";
echo "<tr><td colspan='2'>";
echo "<strong>".$clue_words.": </strong></td></tr>
     <tr><td align='right'><strong>1.</strong></td><td> <input style=font-size='13px' name='keyword1' type=text size='69'></td></tr>";
echo     "<tr><td align='right'><strong>2.</strong></td><td> <input style=font-size='13px' name='keyword2' type=text size='69'></td></tr>";
echo     "<tr><td align='right'><strong>3.</strong></td><td> <input style=font-size='13px' name='keyword3' type=text size='69'></td></tr>";

echo "<tr><td colspan='2'>&nbsp;</td></tr>";



echo "<tr><td valign='top'>
    <strong>".$year_publ."</strong><br /> ";
echo "</td><td>";
echo "<select name='year'>
    <option value='' selected ></option>
    <option value=".date('Y')." >".date('Y')."</option>";

    for ($i=(date("Y")-1);$i>=(date("Y")-20);$i=$i-1)
    {
    	echo "<option value=".$i.">".$i."</option>";
    }

    echo "</select>";


//Тип публикации
/*
      echo    "<br /><br /><strong>Тип публикации</strong><br />";

      $buffer=$DB->select("SELECT * FROM type ORDER BY id");
      $check=" checked";
      foreach ($buffer as $i=>$tip)
      {
    	  echo    " <input type='checkbox' name='type[]' value='".$i."'".$check." />".trim($tip[text])."<br>";


      }
 */
 //         echo   " <input type='checkbox' name='type4[] value='3'".$check." />".ВСЕ."<br>";

     echo "</td></tr>";
	 echo "<tr><td colspan='2'><br /><b><img src=/files/Image/pdf.gif hspace='10'/>".$full_text."</b> <input type='checkbox' name='fullt'  />

</td></tr>";


// Читать рубрикатор

/////////////
echo "</table>";

?>

<br>

<input type=submit name 'Submit' value=<?=$search_text?> >
</form>
<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>