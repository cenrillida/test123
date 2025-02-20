<?
$pg = new Pages();
echo $_TPL_REPLACMENT['DATE2'];
// print_r($_TPL_REPLACMENT);
if ($_SESSION[lang]=="/en")
{
$_TPL_REPLACMENT[TITLE]=$_TPL_REPLACMENT[TITLE_EN];
$_TPL_REPLACMENT[PREV_TEXT]=$_TPL_REPLACMENT[PREV_TEXT_EN];
$_TPL_REPLACMENT[LAST_TEXT]=$_TPL_REPLACMENT[LAST_TEXT_EN];
$param="/en";
}
else
$param="";
//echo "<strong>".str_replace("</p>","",str_replace("<p>","",$_TPL_REPLACMENT["DATE"]))."</strong>";
if (!$_TPL_REPLACMENT["REPORT"])
{
if ($_SESSION[lang]!="/en")
$str=
"<a style='text-decoration:none' href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$_TPL_REPLACMENT['ID'].
"&sem=".$_TPL_REPLACMENT[SEM]."&year=".$_TPL_REPLACMENT[TYEAR].">".
"подробнее >>".
"</a>"


;
else
{
$str=
"<a style='text-decoration:none' href=/en/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$_TPL_REPLACMENT['ID'].
"&sem=".$_TPL_REPLACMENT[SEM]."&year=".$_TPL_REPLACMENT[TYEAR].">".
"more >>".
"</a>"
;


}
}
else
{

if ($_SESSION[lang]!='/en')
$str=
"<a style='text-decoration:none' href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$_TPL_REPLACMENT['ID'].
"&sem=".$_TPL_REPLACMENT[SEM]."&year=".$_TPL_REPLACMENT[TYEAR].
">".
"отчет >>".
"</a>"
;
else
$str=
"<a style='text-decoration:none' href=/en/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$_TPL_REPLACMENT['ID'].
"&sem=".$_TPL_REPLACMENT[SEM]."&year=".$_TPL_REPLACMENT[TYEAR].
">".
"report >>".
"</a>"
;
}
if (!empty($_TPL_REPLACMENT[SEM_NAME]))
  echo "<h4><a title='О семинаре' href=".$param."/index.php?page_id=".$_TPL_REPLACMENT[SEM_ID].
  ">".$_TPL_REPLACMENT[SEM_NAME]."</a></h4>";

if($_TPL_REPLACMENT["GO"])
{
   echo substr($_TPL_REPLACMENT["PREV_TEXT"],0,-4).str_replace("</p>",$str."</p>",
     substr($_TPL_REPLACMENT["PREV_TEXT"],-4,4));
}
else
  echo $_TPL_REPLACMENT["PREV_TEXT"];
//if ($_TPL_REPLACMENT[GO]) echo $str;

echo $str;
?>
<hr />
<br clear="all" />
