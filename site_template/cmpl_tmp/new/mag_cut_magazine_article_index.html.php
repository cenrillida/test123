<?
global $DB,$_CONFIG, $site_templater;

// Индекс статей
//print_r($_REQUEST);

  $pg=new Magazine();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."jtop.html");

$rows=$pg->getAlfArticle();

echo "<br />";

$i=0;
foreach($rows as $row)
{
   $a0[$i]=$row[a];
   $i++;

}
if (empty($_REQUEST[alf]))$_REQUEST[alf]=$a0[0];
$alf=Array("А","Б","В","Г","Д","Е","Ж","З","И","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
//print_r($a);

foreach($alf as $a)
{

   if (in_array($a,$a0))
   {
	     echo "
	     <a href=/index.php?page_id=".$_REQUEST[page_id]."&alf=".$a.">".$a."</a>&nbsp;&nbsp;";

   }
   else
	   echo "<span style='color:gray;'>".$a."</span>&nbsp;&nbsp;";
}
//echo $_REQUEST[alf]." @ ".$a0[0];
$rows=$pg->getArticleByAlf($_REQUEST[alf]);
echo '<br /><br />Статьи на букву "'.$_REQUEST[alf].'"';
foreach($rows as $row)
{
    $people0=$pg->getAutors($row[people]);


      	 			$avtList='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		      	   foreach($people0 as $people)
      			   {
      	      		if (!empty($people[id]))
      	      			{
			      	      if($people!='редакция')
      	    			  {
				      	      if ($people[otdel]!='Умершие сотрудники')
      	        				  $avtList.="<a href=/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>, ";
		      			      else
                     	           $avtList.="<a style='border:1px solid gray;' href=/index.php?page_id".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>, "; //.$people[work].",".$people[mail1]."";
                          }
                     }
                   }
          		   echo "<div class='autors'>";
			           $avtList=substr($avtList,0,-2);
           			   echo $avtList;
      	   			echo "</div>";
			     	 echo "<div class='name'><a href=/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".
			     	 $row[name]." // Вестник Института социологии. ".$row[year]." №".$row[number]." C. ".$row[pages].
			     	 "</a></div>";

}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."jbottom.html");
?>
