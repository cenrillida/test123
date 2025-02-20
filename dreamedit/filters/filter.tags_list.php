<?
global $_CONFIG;

// Найти все темы (ключевые слова)  ///////////////////
$rows=$DB->select("SELECT keyword FROM publ ");

foreach($rows as $row)
{
  $kws=explode(";",trim($row[keyword]));
  foreach($kws as $k=>$kw)
  {
  	$k=trim($kw);
  	if (!empty($kw) && trim($kw)!="-" && trim($kw)!="." && $kw!="")
  	{
  		if (empty($tags[strtolower($kw)])) $tags[strtolower($kw)]=0;
  		$tags[strtolower($kw)]++;

  	}
  }

}
if(count($tags)>0)
{
	ksort($tags);

//print_r($page_content);
$tpl = new Templater();
$tpl->setValues($tags);
$tpl->appendValues(array("TITLE" => "Список тем"));
$tpl->appendValues(array("CCLASS" => "Обычный (светло-синий)"));
$tpl->appendValues(array("CTYPE" => "Текст"));
if (count($tags)>0) ksort($tags);

if ($_GET[keyword1]=="*" )
    $text="<a href=/index.php?page_id=".$page_content[PUBL_SPISOK]." >".
              "<b>ВСЕ</b>"."</a><br /><br />";
else
     $text="<a href=/index.php?page_id=".$page_content[PUBL_SPISOK]." >".
              "ВСЕ"."</a><br /><br />";

foreach($tags as $tag => $tagcount)
	{
//       echo "<br />*".trim($_GET[keyword1])."*".trim($tag)."*";
       if (trim(str_replace("_"," ",$_GET[keyword1]))==trim($tag))
           $text.="<a href=/index.php?page_id=".$page_content[PUBL_SPISOK]."&keyword1=".str_replace(" ","_",$tag).">".
             "<b>".$tag." [".$tagcount."]"."</b></a><br />";
       else
       $text.="<a href=/index.php?page_id=".$page_content[PUBL_SPISOK]."&keyword1=".str_replace(" ","_",$tag).">".
              $tag." [".$tagcount."]"."</a><br />";

	}
 $tpl->appendValues(array("TEXT" => $text));
$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
}
?>
