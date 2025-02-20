<?
global $page_content;

$pg = new Pages();
if ($_SESSION[jour]!='/jour' && $_SESSION[jour]!='/jour_cut')
{
if ($_SESSION[lang]!='/en')
{
	$menuRes = $pg->getChilds(440, 1);
	$param='';
}
else	
{
	$menuRes = $pg->getChildsEn(440, 1);
    $param="/en";
}
}
else
{
if ($_SESSION[lang]!='/en')
{
	$menuRes = $pg->getChilds(922, 1);
	$param='';
}
else	
{
	$menuRes = $pg->getChildsEn(922, 1);
    $param="/en";
}
}

$menuRes = $pg->appendContent($menuRes);
//print_r($_SERVER);
$page_content["RAZDEL"] = "";

//определяем сколько горизонтальных линий для меню нужно
$temp = 0;
foreach($menuRes as $row)
$temp++;

$i = 1;

if(!empty($menuRes))
{
?>
<ul id="nav2" class="menu">
<?


foreach($menuRes as $row)
{
	if($i > 1) 
		echo "<li>|</li>";
	
	echo "<li>";

	$news_templater = new Templater();
	$news_templater->setValues($row);
	$news_templater->appendValues($row["content"]);
//	$news_templater->appendValues(array("PAGE_URLNAME" => $pg->getPageUrl($row["page_id"]), "LINK_NUM" => $i));
	$news_templater->appendValues(array("PAGE_URLNAME" => $param."/index.php?page_id=".$row["page_id"]));

	$styles="";
	if($row['page_name']=='Спецпроект')
		$styles=' style="color: red; font-weight: bold;"';
	if ($_SESSION[lang]=='/en') $row[page_name]=$row[page_name_en];
	if($row["page_id"]!=923)
	    echo '<a alt="'.$row["page_name"].'" href="'.$param.'/index.php?page_id='.$row["page_id"].'"'.$styles.'>';
	else
        echo '<a alt="'.$row["page_name"].'" href="/"'.$styles.'>';
	echo $row["page_name"];
	if($row['page_name']=="Выборы в США" || $row['page_name']=="Спецрубрики")
		echo '<span class="marked-button"></span>';
	if($row['page_name']=="Спецрубрика")
		echo '<img style="height: 12px;margin-left: 5px;" src="/images/euu-f.gif">';
	echo "</a>";
	$i++;
	
	echo "</li>";
}

?>
</ul>
<?
}
?>