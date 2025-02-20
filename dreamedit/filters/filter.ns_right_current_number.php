<?
global $_CONFIG, $page_content;
// Последний номер журнала
$headers = new Headers();
$mz = new Magazine();





//print_r($_SESSION);
$rowsm = $mz->getLastMagazineNumber($_SESSION[jour_id]);
$rowsy=$mz->getMagazineAllYear($_SESSION[jour_id]);
$rows=$mz->getLastMagazineNumberRub($_SESSION[jour_id],$rowsm[0][page_name],$rowsm[0][year]);


if(!empty($rowsm[0][page_name_en]))
    $page_name_number_en = $rowsm[0][page_name_en];
else {
    $page_name_number_en = str_replace("Ежегодник","Yearbook",$rowsm[0][page_name]);
}

if ($_SESSION[lang]!='/en')
    $rowsth=$mz->getMagazineNumber($rowsm[0][page_id]);
else
    $rowsth=$mz->getMagazineNumberEn($rowsm[0][page_id]);
$rowsth=$mz->appendContentArticle($rowsth);

//print_r($rowsm);
if ($_SESSION[lang]=='/en')
{
    $txtn='No. ';
    $txtend='View this issue';

}
else
{
    $txtn="№ ";
    $txtend='Открыть этот выпуск';
}
if($_SESSION[jour_url]=='god_planety' || $_SESSION[jour_url]=='WER' || $_SESSION[jour_url]=='oprme' || $_SESSION[jour_url]=='Russia-n-World' || $_SESSION[jour_url]=='SIPRI')
{
    $txtn="";
    if ($_SESSION[lang]=='/en')
        $rowsm[0][page_name]=str_replace("Ежегодник","Yearbook",$rowsm[0][page_name]);
}
//print_r($rowsm);
$vol_pos = strripos($rowsm[0][page_name], "т.");
if ($vol_pos === false) {
    if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='Russia-n-World' && $_SESSION[jour_url]!='SIPRI') {
        if ($_SESSION[lang] != '/en') {
            if ($_SESSION[jour_url] != "WER")
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtn . $rowsm[0][page_name] . ", " . $rowsm[0][year] . "</a>" .
                    "<br /><table><tr><td>";
            else
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtn . $rowsm[0][page_name] . "</a>" .
                    "<br /><table><tr><td>";
        } else
            $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $rowsm[0][year] . ", " . $txtn . $page_name_number_en . "</a>" .
                "<br /><table><tr><td>";
    }
    else {
        if ($_SESSION[lang] != '/en') {
            if ($_SESSION[jour_url] == "god_planety")
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtn . $rowsm[0][page_name] . ", " . $rowsm[0][year] . "</a>" .
                    "<br /><table><tr><td>";
            else
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtn . $rowsm[0][page_name] . "</a>" .
                    "<br /><table><tr><td>";
        } else {
            if ($_SESSION[jour_url] == "god_planety")
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $rowsm[0][year] . ", " . $txtn . $page_name_number_en . "</a>" .
                    "<br /><table><tr><td>";
            else
                $txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtn . $page_name_number_en . "</a>" .
                    "<br /><table><tr><td>";
        }
    }
}
else
{
    $volume=substr($rowsm[0][page_name], $vol_pos);
    if($_SESSION[lang]=='/en')
        $volume=str_replace("т.", "vol.",$volume);
    $number=spliti(",",$rowsm[0][page_name]);
    if ($_SESSION[lang]!='/en')
        $txt="<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".
            $rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$volume.", ".$txtn.$number[0].", ".$rowsm[0][year]."</a>".
            "<br /><table><tr><td>";
    else
        $txt="<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".
            $rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$rowsm[0][year].", ".$volume.", ".$txtn.$number[0]."</a>".
            "<br /><table><tr><td>";
}
if($_SESSION[jour_url]!='meimo' && $_SESSION[jour_url]!='WER')
{
    $txt.="<ul>";
    //    foreach($rows as $row)
//    {
//        if ($_SESSION[lang]!='/en' || empty($row[name_en]))
//            $txt.="<li>- ".$row[page_name]."</li>";
//        else
//            $txt.="<li>- ".$row[name_en]."</li>";
//
//    }
    foreach ($rowsth as $k=>$row) {
        if($row[page_template]=="jrubric")
        {
            if ($_SESSION[lang]!='/en' || empty($row[name_en]))
                $txt.="<li>- ".$row[page_name]."</li>";
            else
                $txt.="<li>- ".$row[name_en]."</li>";
        }
    }
    $txt.="</ul>";
}
else
{
    /*if ($_SESSION[lang]!='/en')
        $txt.='<div style="font-style: italic;">'.$rowsth[$rowsm[0][page_id]][content][CONTENT].'</div>';
    else
        $txt.='<div style="font-style: italic;">'.$rowsth[$rowsm[0][page_id]][content][CONTENT_EN].'</div>';*/
    if ($_SESSION[lang]!='/en')
        $txt.='<div style="font-style: italic;">'.substr(substr($rowsth[$rowsm[0][page_id]][content][SUBJECT],0,-4),3).'</div>';
    else
        $txt.='<div style="font-style: italic;">'.substr(substr($rowsth[$rowsm[0][page_id]][content][SUBJECT_EN],0,-4),3).'</div>';
}
$txt.="</td></tr></table>";

$elements=Array();

$link_txt = "";
if ($rowsm[0][page_template]!='magazine')
{
    $vol_pos = strripos($rowsm[0][page_name], "т.");
    if ($vol_pos === false) {
        if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='Russia-n-World' && $_SESSION[jour_url]!='SIPRI') {
            if ($_SESSION[lang] != '/en') {
                if ($_SESSION[jour_url] != "WER")
                    $link_txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                        $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtend . " (" . $txtn . $rowsm[0][page_name] . ", " . $rowsm[0][year] . ")</a>";
                else
                    $link_txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                        $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtend . " (" . $txtn . $rowsm[0][page_name] . ")</a>";
            } else
                $link_txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtend . " (" . $rowsm[0][year] . ", " . $txtn . $page_name_number_en . ")</a>";
        }
        else
        {
            if ($_SESSION[lang] != '/en') {
                $link_txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtend . "</a>";
            } else
                $link_txt = "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" .
                    $rowsm[0][page_summary] . "&jid=" . $rowsm[0][page_id] . ">" . $txtend . "</a>";
        }
    }
    else
    {
        $volume=substr($rowsm[0][page_name], $vol_pos);
        if($_SESSION[lang]=='/en')
            $volume=str_replace("т.", "vol.",$volume);
        $number=spliti(",",$rowsm[0][page_name]);
        if ($_SESSION[lang]!='/en')
            $link_txt = "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".
                $rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtend." (".$volume.", ".$txtn.$number[0].", ".$rowsm[0][year].")</a>";
        else
            $link_txt = "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".
                $rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtend." (".$rowsm[0][year].", ".$volume.", ".$txtn.$number[0].")</a>";
    }
/////////////
    $years="";
    foreach($rowsy as $row)
    {
        $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.
            "&year=".$row[year].
            ">".$row[year]."</a> |";
    }
    $tpl = new Templater();
    $tpl->appendValues(array("CCLASS" => "Красный"));
    $tpl->appendValues(array("CTYPE" => "Текст"));
    if ($_SESSION[lang]!='/en')
        $tpl->appendValues(array("TITLE" => "По годам"));//$pagem[0][jj]));
    else
        $tpl->appendValues(array("TITLE_EN" => "Years"));
    $tpl->appendValues(array("TEXT" => $years));
    $tpl->appendValues(array("TEXT_EN" => $years));
//	echo '<div class="box">';
//			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
//	echo '</div>';
}


$elements[0][text]="<div style='font-size: 17px;'>".$txt."</div>";
$elements[0][text_en]="<div style='font-size: 17px;'>".$txt."</div>";
$elements[0][ctype]='Текст';
$elements[0][cclass]='Красный';
if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='Russia-n-World' && $_SESSION[jour_url]!='SIPRI')
{
    if ($_SESSION[lang]!='/en') $elements[0]['titlenew']='Текущий номер'; else $elements[0]['titlenew_en']='Current Issue';
}
else
{
    if ($_SESSION[lang]!='/en') $elements[0]['titlenew']='Текущий выпуск'; else $elements[0]['titlenew_en']='Current Issue';
}
$elements[0]['sort']='0001';
$elements[0][showtitle]='1';
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