<?
$pg = new Pages();

//print_r($_TPL_REPLACMENT);
//echo "<br />___".$_TPL_REPLACMENT[FULL_TEXT]."###";

if ($_TPL_REPLACMENT[NEWS_LINE]==4)
   echo "<b>".@$_TPL_REPLACMENT["DATE2"]." ".@$_TPL_REPLACMENT["TITLE_NEWS"]."</b>";
else   
   echo "<b>".@$_TPL_REPLACMENT["TITLE_NEWS"]."</b>";

?>
<?=@$_TPL_REPLACMENT["PREV_TEXT"]?>
<?
if(!empty($_TPL_REPLACMENT[FULL_TEXT]))
{
if ($_SESSION[lang]!='/en')
{
?>

<a title='подробнее' href=/index.php?page_id=<?=@$_TPL_REPLACMENT["FULL_ID"]?>&id=<?=@$_TPL_REPLACMENT["ID"]?>&p=<?=@$_REQUEST["p"]?>&ret=<?=@$_TPL_REPLACMENT[RET_ID]?>
&year=<?=@$_TPL_REPLACMENT["TYEAR"]?>&sem=<?=@$_TPL_REPLACMENT["SEM"]?>>
<!--<img src='/files/Image/str_black.jpg' />-->подробнее...
</a>
<?

}
else
{
?>

<a title='more' href=/en/index.php?page_id=<?=@$_TPL_REPLACMENT["FULL_ID"]?>&id=<?=@$_TPL_REPLACMENT["ID"]?>&p=<?=@$_REQUEST["p"]?>&ret=<?=@$_TPL_REPLACMENT[RET_ID]?>
&year=<?=@$_TPL_REPLACMENT["TYEAR"]?>&sem=<?=@$_TPL_REPLACMENT["SEM"]?>>
<!--<img src='/files/Image/str_black.jpg' />-->more...
</a>
<?

}
}
?>
<br /><br clear="all" />
