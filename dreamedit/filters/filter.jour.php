<?
// Slider
global $DB,$_CONFIG;
if (!isset($_REQUEST[en]))
	$rows=$DB->select("SELECT page_id,page_name,issn,logo,info FROM adm_magazine WHERE page_template='0' ORDER BY page_name");
else
	$rows=$DB->select("SELECT page_id,page_name_en AS page_name,issn,logo,info_en AS info FROM adm_magazine WHERE page_template='0' ORDER BY page_name");

$mz=new Magazine();

//print_r($rows);
?>
<div>
<div id="basic-accordian" >
<?
$i=0;
foreach($rows as $row)
{

$lastNumber=$mz->getLastMagazineNumber($row[page_id]);
//print_r($lastNumber);
if($i==0)
{
   $class="accordion_headings header_highlight selected";
   $test="";

}
else
{
   $class="accordion_headings";
   $test=$i;

}
// узнать последний номер
?>

  <div id="test<?=@$test?>-header" class="<?=@$class?>" ><?=@str_replace("Журнал «","",str_replace("»","",$row[page_name]))?></div>



  <div id="test<?=@$test?>-content">


    <div class="accordion_child">
    	 <?=@str_replace("<img ","<img align='left' hspace=6 ",str_replace("</p>","",str_replace("<p>","",$row[logo])));?>
    	  <?=@str_replace("</p>","",str_replace("<p>","",$row[info]))." ISSN ".$row[issn]?>

<?
   if (!empty($lastNumber[0][page_summary]))
   {
	   if (!isset($_REQUEST[en]))
	   echo  "<br /><a href=index.php?page_id=".$lastNumber[0][page_summary]."&jid=".$lastNumber[0][page_id].">Свежий номер № ".$lastNumber[0][page_name].". ".
   			$lastNumber[0][year].". " .
		   	"Оглавление</a>";
		else
	   echo  "<br /><a href=index.php?page_id=".$lastNumber[0][page_summary]."&jid=".$lastNumber[0][page_id].">Last number # ".$lastNumber[0][page_name].". ".
   			$lastNumber[0][year].". " .
		   	"</a>";

	}
	if (!isset($_REQUEST[en]))
		echo "<br /><a href=index.php?page_id=".$lastNumber[0][pid]."&jid=".$lastNumber[0][page_id].">О журнале</a>";
	else
		echo "<br /><a href=index.php?page_id=".$lastNumber[0][pid]."&jid=".$lastNumber[0][page_id].">About</a>";

?>
    </div>

  </div>

<?
//}
//else
//{
?>


<?
//}
$i++;


}
?>

</div>
</div>