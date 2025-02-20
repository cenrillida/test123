<?
global $_CONFIG, $page_content;
// Последний номер журнала
$headers = new Headers();
$mz = new MagazineNew();

//print_r($_SESSION);
$rowsm = $mz->getLastMagazineNumber($_TPL_REPLACMENT["MAIN_JOUR_ID"]);
$rowsy=$mz->getMagazineAllYear($_TPL_REPLACMENT["MAIN_JOUR_ID"]);
$rows=$mz->getLastMagazineNumberRub($_TPL_REPLACMENT["MAIN_JOUR_ID"],$rowsm[0]["page_name"],$rowsm[0]["year"]);

if(!empty($rowsm[0]["page_name_en"]))
    $page_name_number_en = $rowsm[0]["page_name_en"];
else {
    $page_name_number_en = str_replace("Ежегодник","Yearbook",$rowsm[0]["page_name"]);
}

if ($_SESSION["lang"]!='/en')
    $rowsth=$mz->getMagazineNumber($rowsm[0]["page_id"], null, null, null, $_TPL_REPLACMENT["MAIN_JOUR_ID"]);
else
    $rowsth=$mz->getMagazineNumberEn($rowsm[0]["page_id"], null, null, null, $_TPL_REPLACMENT["MAIN_JOUR_ID"]);
$rowsth=$mz->appendContentArticle($rowsth);

//print_r($rowsm);
if ($_SESSION["lang"]=='/en')
{
    $txtn='No. ';
    $txtend='View this issue';

}
else
{
    $txtn="№ ";
    $txtend='Открыть этот выпуск';
}
if(!$_TPL_REPLACMENT["NO_PREFIX"])
{
    $txtn="";
}

if($_SESSION["lang"]=="/en") {
    $yearPrefPostfix = $rowsm[0]["year"] . ", ";
} else {
    $yearPrefPostfix = ", " . $rowsm[0]["year"];
}

if($_TPL_REPLACMENT["NO_ECHO_YEAR"]==1) {
    $yearPrefPostfix = "";
}

//print_r($rowsm);
$vol_pos = strripos($rowsm[0]["page_name"], "т.");
if ($vol_pos === false) {

    if($_SESSION["lang"]=="/en") {
        $txt = "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" .
            $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $rowsm[0]["page_id"] . ">" . $yearPrefPostfix . $txtn . $page_name_number_en . "</a>" .
            "<br /><table><tr><td>";
    } else {
        $txt = "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" .
            $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $rowsm[0]["page_id"] . ">" . $txtn . $rowsm[0]["page_name"] . $yearPrefPostfix . "</a>" .
            "<br /><table><tr><td>";
    }


}
else
{
    $volume=substr($rowsm[0]["page_name"], $vol_pos);
    if($_SESSION["lang"]=='/en')
        $volume=str_replace("т.", "vol.",$volume);
    $number=spliti(",",$rowsm[0]["page_name"]);
    if ($_SESSION["lang"]!='/en')
        $txt="<a href=".$_SESSION["lang"]."/index.php?page_id=".
            $_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$rowsm[0]["page_id"].">".$volume.", ".$txtn.$number[0].", ".$rowsm[0]["year"]."</a>".
            "<br /><table><tr><td>";
    else
        $txt="<a href=".$_SESSION["lang"]."/index.php?page_id=".
            $_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$rowsm[0]["page_id"].">".$rowsm[0]["year"].", ".$volume.", ".$txtn.$number[0]."</a>".
            "<br /><table><tr><td>";
}


if($_TPL_REPLACMENT["ECHO_SUBJECT"]==1) {
    if ($_SESSION["lang"] != '/en')
        $txt .= '<div style="font-style: italic;">' . $rowsth[$rowsm[0]["page_id"]]["content"]["SUBJECT"] . '</div>';
    else
        $txt .= '<div style="font-style: italic;">' . $rowsth[$rowsm[0]["page_id"]]["content"]["SUBJECT_EN"] . '</div>';
} else {
    $txt.="<ul>";

    foreach ($rowsth as $k=>$row) {
        if($row["page_template"]=="jrubric")
        {
            if ($_SESSION["lang"]!='/en' || empty($row["name_en"]))
                $txt.="<li>- ".$row["page_name"]."</li>";
            else
                $txt.="<li>- ".$row["name_en"]."</li>";
        }
    }
    $txt.="</ul>";
}

$txt.="</td></tr></table>";

$elements=Array();

$link_txt = "";
if ($rowsm[0]["page_template"]!='magazine')
{
    $vol_pos = strripos($rowsm[0]["page_name"], "т.");
    if ($vol_pos === false) {


        if($_SESSION["lang"]=="/en") {
            $link_txt = "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" .
                $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $rowsm[0]["page_id"] . ">" . $txtend . " (" . $yearPrefPostfix . $txtn . $page_name_number_en . ")</a>";
        } else {
            $link_txt = "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" .
                $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $rowsm[0]["page_id"] . ">" . $txtend . " (" . $txtn . $rowsm[0]["page_name"] . $yearPrefPostfix . ")</a>";
        }

    }
    else
    {
        $volume=substr($rowsm[0]["page_name"], $vol_pos);
        if($_SESSION["lang"]=='/en')
            $volume=str_replace("т.", "vol.",$volume);
        $number=spliti(",",$rowsm[0]["page_name"]);
        if ($_SESSION["lang"]!='/en')
            $link_txt = "<a href=".$_SESSION["lang"]."/index.php?page_id=".
                $_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$rowsm[0]["page_id"].">".$txtend." (".$volume.", ".$txtn.$number[0].", ".$rowsm[0]["year"].")</a>";
        else
            $link_txt = "<a href=".$_SESSION["lang"]."/index.php?page_id=".
                $_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$rowsm[0]["page_id"].">".$txtend." (".$rowsm[0]["year"].", ".$volume.", ".$txtn.$number[0].")</a>";
    }

}


$elements[0]["text"]="<div style='font-size: 17px;'>".$txt."</div>";
$elements[0]["text_en"]="<div style='font-size: 17px;'>".$txt."</div>";
$elements[0]["ctype"]='Текст';
$elements[0]["cclass"]='Красный';
if($_SESSION["jour_url"]!='god_planety' && $_SESSION["jour_url"]!='Russia-n-World' && $_SESSION["jour_url"]!='SIPRI')
{
    if ($_SESSION["lang"]!='/en') $elements[0]['titlenew']='Текущий номер'; else $elements[0]['titlenew_en']='Current Issue';
}
else
{
    if ($_SESSION["lang"]!='/en') $elements[0]['titlenew']='Текущий выпуск'; else $elements[0]['titlenew_en']='Current Issue';
}
$elements[0]['sort']='0001';
$elements[0]["showtitle"]='1';
$i=0;
//print_r($elements);
//if(!empty($rows))
//{
echo '<div class="box">';
foreach($elements as $k => $v)
{

    echo $v["text"];
}
echo '</div>';

//}


?>