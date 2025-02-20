<?
// Страница одного подразделения
global $DB, $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$pr=new Persons();
if ($_SESSION[lang]!='/en')
    $pers=$pr->getPersonsByPodrId($_TPL_REPLACMENT['OTDEL']);
else
    $pers=$pr->getPersonsByPodrIdEn($_TPL_REPLACMENT['OTDEL']);

$pg = new Pages();
$otdelContent = $pg->getContentByPageId($_TPL_REPLACMENT['OTDEL']);

foreach($pers as $row3)
{
    $second_profile = $DB->select("SELECT COUNT(*) AS cnt FROM persons WHERE second_profile=".$row3[id]);
    if($second_profile[0]['cnt']!=0)
        continue;
    $doljn="";

    if($row3[otdel3]==$_TPL_REPLACMENT['OTDEL'])
        $doljn="dolj3";
    if($row3[otdel2]==$_TPL_REPLACMENT['OTDEL'])
        $doljn="dolj2";
    if($row3[otdel]==$_TPL_REPLACMENT['OTDEL'])
        $doljn="dolj";



    echo "<br />";

    if($row3[id]==$otdelContent['CHIF']) {
        if ($_SESSION[lang]!='/en')
            $row3[dolj] = "руководитель центра";
        else
            $row3[dolj] = "head";
    }


    echo "&nbsp;&nbsp;<a  href=".$_SESSION[lang]."/index.php?page_id=555&id=".$row3[id]."><b>".$row3[fullname].'</b></a><br>';

    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        trim(str_replace(', ,',',' , $row3[chlen].", ".$row3[us].", ".$row3[uz].", ".$row3[$doljn]), ', ') ;

}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
