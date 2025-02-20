<?
// Страница одного подразделения
global $DB, $_CONFIG, $site_templater;

if ($_SESSION["lang"]=='/en')
{
    $suff="_en";
    $txtruk='Head';
    $txtsekr="Scientific Secretary";
    $txt1="Structure";
    $txt2="Field of Research";
    $txt3="List of Staff";
    $txt4='List of division\'s Publications';
    $txt5='Unit\'s news';
    $txt6='Unit\'s events';
    $sym="/";
}
else
{
    $suff='';

    $txtruk='Руководитель';
    $txtsekr="Ученый секретарь";
    $txt1="Структура";
    $txt2="Направления деятельности";
    $txt3="Список сотрудников";
    $txt4="Список публикаций подразделения";
    $txt5="Новости подразделения";
    $txt6="Мероприятия подразделения";
    $sym="";

}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

?>
<?
$pg = new Pages();
$persons = new Persons();
$ilines = new Ilines();

// Найти центр
$nn = $pg->getPageById($_REQUEST["page_id"]);
$pageContent = $pg->getContentByPageId($_REQUEST["page_id"]);
$ntype=$nn["page_parent"];
if (!empty($nn["page_link"]))
{
    $nn = $pg->getPageById($nn["page_link"]);
    $_REQUEST["page_id"]=$nn["page_id"];
}
$pcenter=$nn["page_id"];
$parent=$nn["page_parent"];
$ncenter=$nn["page_name".$suff];
$tid=$nn["page_parent"]; // Здесь будет ID отдела (сектора)


if ($tid==$pcenter) $tid=$_REQUEST["page_id"]; //Это отдел (сектор)
if ($pcenter==$_REQUEST["page_id"]) $tid=$_REQUEST["page_id"];



// Собираем детей
$i=0;
if ($_SESSION["lang"]!='/en')
    $ch=$pg->getChilds($tid,true);
else
    $ch=$pg->getChildsEn($tid,true);

$ch = $pg->appendContent($ch);

$str= $pg->getPageById($_REQUEST["page_id"]);
if (!empty($str["page_link"]))
    $str = $pg->getPageById($str["page_link"]);
// print_r($str);
if ($str["page_status"] != 0)  //если подразделение видимо
{

    // Руководитель
    echo "<div class='container-fluid mb-5'>";

    echo "<div class='row'>";
    if ($_SESSION["lang"]!='/en')
    {
        $persona = $persons->getPersonsRegaliiByCenterId($str["page_id"],"chif");
        $fiochif=$persona[0]["surname"]." ".$persona[0]["name"]." ".$persona[0]["fname"];
    }
    else
    {
        $persona = $persons->getPersonsRegaliiByCenterIdEn($str["page_id"],"chif");
        $fiochif=$persona[0]["Autor_en"];
    }
    if ($_SESSION["lang"]!="/en")
    {
        $persona_sekr = $persons->getPersonsRegaliiByCenterId($str["page_id"],"sekretar");
    }
    else
    {
        $persona_sekr = $persons->getPersonsRegaliiByCenterIdEn($str["page_id"],"sekretar");

    }

    if (!empty($persona)) {
        if (!empty($persona_sekr)) {
            echo "<div style='width: 140px;'>" . $txtruk . ":</div>";
        } else {
            echo "<div style='width: 105px;'>" . $txtruk . ":</div>";
        }

        echo "<div class='col-10'>".
            $persona[0]["chlen"]." ".
            $persona[0]["us"]." ".
            $persona[0]["uz"]." ".
            "<a href='".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT['PERSONA_PAGE']."&id=".$persona[0]["id"]."'>".
            $fiochif."</a>";
        echo "<br />";
        echo $persona[0]["contact"];
        echo "</div>";
    }
    echo "</div>";

    $id_ruk=$persona[0]['id'];


    //Ученый секретарь

    echo "<div class='row'>";

    if (!empty($persona_sekr))
    {
        if($_SESSION["lang"]!="/en") {
            $fiochif=$persona_sekr[0]["surname"]." ".$persona_sekr[0]["name"]." ".$persona_sekr[0]["fname"];
        } else {
            $fiochif = $persona_sekr[0]["Autor_en"];
        }
        echo "<div style='width: 140px;'>".$txtsekr.":</div> ";
        echo "<div class='col-10'>".
            $persona_sekr[0]["chlen"]." ".
            $persona_sekr[0]["us"]." ".
            $persona_sekr[0]["uz"]." ".
            "<a href='".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT['PERSONA_PAGE']."&id=".$persona_sekr[0]["id"]."'>".
            $fiochif."</a>";
        echo "<br />";
        echo $persona_sekr[0]["contact"];
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    $i=0;
    $ch_string="";
    // echo "___________".$tid;
    if ($tid!=160 ) //($ntype<>65) Не библиотека
    {
        echo "<div class=\"container-fluid\">";
        echo "<div class=\"row\">";
        echo "<div class=\"col-12 col-md-6\">";
        if (count($ch)>0) echo "<h4>".$txt1."</h4>";
        echo "<ul class='speclist'>";
        foreach ($ch as $k=>$cc)
        {
            if($cc['page_status'] != 0) {
                if ($_SESSION["lang"] != '/en')
                    $ch2 = $pg->getChilds($cc["page_id"]);
                else
                    $ch2 = $pg->getChildsEn($cc["page_id"]);
                echo "<li>";
                if ($cc['content']['LIST_LINK_OFF'] == 1) {
                    echo $cc["page_name" . $suff];
                } else {
                    echo "<a href='" . $_SESSION["lang"] . "/index.php?page_id=" . $cc['page_id'] . "'>" . $cc['page_name' . $suff] . "</a>";
                }

                $ch2 = $pg->appendContent($ch2);

                if (count($ch2) > 0) {
                    echo "<ul class='speclist'>";
                    foreach ($ch2 as $k2 => $cc2) {
                        if($cc2['page_status'] != 0) {
                            echo "<li>";
                            if ($cc2['content']['LIST_LINK_OFF'] == 1) {
                                echo $cc2["page_name" . $suff];
                            } else {
                                echo "<a href='" . $_SESSION["lang"] . "/index.php?page_id=" . $cc2['page_id'] . "'>" . $cc2['page_name' . $suff] . "</a>";
                            }
                            echo "</li>";
                        }
                    }
                    echo "</ul>";
                }

                echo "</li>";
            }
        }
        echo "</ul>";
        echo "</div>";
        echo "<div class=\"col-12 col-md-6 text-right my-auto\">";
        //echo "<a href=".$_SESSION["lang"].$sym."index.php?page_id=732&tid=".$_REQUEST["page_id"].">".$txt4."</a>";
        if($pageContent["NEWS_LINK_OFF"]!="1") {
            echo "<div><a href=".$_SESSION["lang"].$sym."index.php?page_id=498&otdel=".$_REQUEST["page_id"].">".$txt5."</a></div>";
        }
        if($pageContent["EVENTS_LINK_OFF"]!="1") {
            echo "<div><a href=".$_SESSION["lang"].$sym."index.php?page_id=506&otdel=".$_REQUEST["page_id"].">".$txt6."</a></div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    //    echo "<br /><br />";
    if(!empty($_TPL_REPLACMENT["CONTENT_BEFORE_FOR".strtoupper($suff)])) {
        echo "<hr />".$_TPL_REPLACMENT["CONTENT_BEFORE_FOR".strtoupper($suff)];
    }
    if(!empty($_TPL_REPLACMENT["CONTENT".strtoupper($suff)])) {
        echo "<hr /><h4>" . $txt2 . "</h4>";
        echo $_TPL_REPLACMENT["CONTENT" . strtoupper($suff)];
    }
}
if($pageContent['GRANT_LINK_OFF']!=1) {
//// Темы НИР
    $nir = new Nirs();
//$rowsn=$nir->getGrantByPodrName(0,date("Y"),16,$_REQUEST["page_id"]);
    $rowsn = $nir->getGrantByPodrName(0, -1, 16, $_REQUEST["page_id"]);
    if (count($rowsn) > 0 && $_SESSION["lang"] != "/en")
        echo "<hr />";

    $nir->echoGrantListByType("Гранты РГНФ", 2);

    $nir->echoGrantListByType("Гранты РФФИ", 3);

    $nir->echoGrantListByType("Гранты РНФ", 6);
}
//
$dr=new Directories();
$serv=$dr->getServiceAll($_REQUEST["page_id"]);
//$uu=$ilines->getUslugaByPodr($_REQUEST["page_id"]);
//print_r($uu);
$gruppa='';
if (count($serv)>0)
{
    echo "<hr /><h4>".$ncenter."<br />оказывает услуги:</h4>";
    foreach($serv as $v)
    {
//echo "<br />__________________________<br />";print_r($v);
        if ($v["type"]=='u')
        {

            //       	$rowsu=$ilines->appendContentUsluga($v[el_id]);
            $uu=explode(".",$v["usluga"]);
            if ($gruppa!=$uu[0])
            {
                echo "<h4>".$uu[0]."</h4>";
                echo "<ul class='speclist'>";
                $i=1;
                $gruppa=$uu[0];
            }
            echo "<li><b>".$uu[1]."</b>";
            //           echo $rowsu[PREV_TEXT];
            echo "</li>";
            //           if (!empty($rowsu[FULL_TEXT]))
            echo "<a title='Подробное описание услуги' href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["SERVICE_PAGE"]."&id=".$v["el_id"].">подробнее...</a><br /><br />";


        }
        else
        {
            if ($i!=0) echo "</ul>";
            echo "<h4>".$v["usluga"]."</h4>";
            echo "<ul class='speclist'>";
            $i=1;
            $gruppa=$v["usluga"];
        }
    }
    echo "</ul>";
}

if($pageContent['PERSONAL_LIST_OFF']!=1) {
    ///////////Сотрудники
    echo "<hr /><h4>".$txt3."</h4>";
    $pr=new Persons();
    if ($_SESSION["lang"]!='/en')
        $pers=$pr->getPersonsByPodrId($_REQUEST["page_id"]);
    else
        $pers=$pr->getPersonsByPodrIdEn($_REQUEST["page_id"]);

    foreach($pers as $row3)
    {
        $second_profile = $DB->select("SELECT COUNT(*) AS cnt FROM persons WHERE second_profile=".$row3["id"]);
        if($second_profile[0]['cnt']!=0)
            continue;
        $doljn="";

        if($row3["otdel"]==$tid)
            $doljn="dolj";
        if($row3["otdel2"]==$tid)
            $doljn="dolj2";
        if($row3["otdel3"]==$tid)
            $doljn="dolj3";
//
//    echo "<br />";
        if (empty($_TPL_REPLACMENT["SWITCH_PAGE"]))
        {
            echo "&nbsp;&nbsp;<a  href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT['PERSONA_PAGE']."&id=".$row3["id"]."><b>".$row3["fullname"].'</b></a><br>';
        }
        else
        {
            echo "&nbsp;&nbsp;<a  href=".$_SESSION["lang"]."/index.php?page_id=".$FULL_ID."&id=".$row3["id"]."><b>".$row3["shortname"]." (".$row3["year1"]."-".$row3["year_institute"].")".'</b></a><br>';
        }
//    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
//        trim(str_replace(', ,',',' , $row3[chlen].", ".$row3[us].", ".$row3[uz].", ".$row3[$doljn]), ', ') ;

    }
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
