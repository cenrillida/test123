<?
global $DB,$_CONFIG, $site_templater;

$id_news=(int)$_GET['id'];
$all_views = 0;

if(!empty($id_news)) {
    $eng_stat = "";
    if($_SESSION[lang]=="/en")
        $eng_stat = "-en";
    //Statistic::theCounter("magarticle-".$id_news.$eng_stat);
    $all_views = Statistic::getAllViews("magarticle-".$id_news.$eng_stat);
}


if ($_SESSION[lang]=='/en')
{
    $suff='';
    $txt1="No ";
    $txt2='Rubric';
    $txt3= 'download free';
    $txt4='Contents ';
    $suff2="_en";
    $txtpage="P.";
    $ppages="pp.";
}
else
{
    $suff='';$suff2="";
    $txt1="№ ";$txt2='Рубрика';$txt3='скачать бесплатно';$txt4='Оглавление номера ';
    $txtpage="С.";
    $ppages="сс.";
}
//print_r($_REQUEST);

$pg=new Magazine();
if (!empty($_SESSION[jour_id]))
{
    $_REQUEST[jid]=$_SESSION[jour_id];
    $_REQUEST[jj]=$_SESSION[jour_id];
}
if (empty($_REQUEST[jid])) //Найти свежий номер журнала
{

    $jid0=$pg->getLastMagazineNumber();

    $_REQUEST[jid]=$jid0[0][page_id];
    $_REQUEST[jj]=$jid0[0][journal];

}
$_REQUEST[id] = (int)$_REQUEST[id];
$_REQUEST[jid] = (int)$_REQUEST[jid];
$_REQUEST[jj] = (int)$_REQUEST[jj];
$jour0=$pg->getMagazineByArticleId($_REQUEST[id]);
//print_r($jour0);

$rows=$DB->select("SELECT  name AS title,name_en AS title_en,CONCAT('".$txt1." ',number,', ',year) AS jname, CONCAT(number,', ',year) AS jname_cut, number AS number, name_black, name_black_en 
   FROM adm_article WHERE  page_id=".(int)$_REQUEST[id]);


if($_SESSION[jour_url]=="god_planety")
    if(!is_numeric(substr($rows[0][number], 0, 1)))
    {
        if($_SESSION[lang]!="/en")
            $rows[0][jname]=$rows[0][jname_cut];
        else
            $rows[0][jname]=str_replace("Ежегодник", "Yearbook", $rows[0][jname_cut]);
    }
//print_r($rows);
$_REQUEST[jid]=(int)$jour0[0][page_id];
$_REQUEST[jj]=(int)$jour0[0][journal];
//print_r($rows);
if ($_SESSION[lang]!='/en')
{
    $jname=$txt1.$jour0[0][page_name].", ".$jour0[0][year];
    $title=$rows[0][jname];
}
else
{

    $jname=$txt1.$rows[0][title_en].", ".$jour0[0][year];
    $title=$rows[0][jname];
}
//print_r($rows);
$art_title=$rows[0][title];
$art_title_en=$rows[0][title_en];
if(!empty($rows[0][name_black])) {
    $rows[0][title] = str_replace($rows[0][name_black],"<span style=\"border: 1px solid black; padding: 0 3px;\">".$rows[0][name_black]."</span>",$rows[0][title]);
}
if(!empty($rows[0][name_black_en])) {
    $rows[0][title_en] = str_replace($rows[0][name_black_en],"<span style=\"border: 1px solid black; padding: 0 3px;\">".$rows[0][name_black_en]."</span>",$rows[0][title_en]);
}
$site_templater->appendValues(array("TITLE" => $rows[0][title]));
$site_templater->appendValues(array("TITLE_EN" => $rows[0][title_en]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if(!empty($id_news)) {
    Statistic::ajaxCounter("magarticle", $id_news);
    Statistic::getAjaxViews("magarticle", $id_news);
}

echo "<div style='text-align: right; color: #979797;'><img width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";

$rowas=$pg->getArticleById($_REQUEST[id]);
//  print_r($rowas);
if (!empty($rowas[0][page_parent]))
{
    $rowrs=$DB->select("SELECT page_id, IFNULL(name,page_name) AS rubric,name_en AS rubric_en ".
        // cv_text AS rubric FROM adm_article_content  AS pc
        " FROM adm_article ".
        " WHERE  page_id=".$rowas[0][page_parent]." AND page_status=1 AND page_template='jrubric'"  ); //." AND cv_name='rubric".$suff2."'");

    $rowj=$DB->select("SELECT page_id,page_name AS journal,page_name_en AS journal_en FROM adm_magazine WHERE page_id=".(int)$_REQUEST[jj]);
}
foreach($rowas as $k=>$row)
{
//print_r($row);echo "name".$suff2." ".$row[name.$suff2];
    echo "<div class='jarticle'>";
    if (!isset($_REQUEST[en]))
    {
        $people0=$pg->getAutors($row[people]);
        $avtbib=$pg->getAutorsBib($row[people]);
    }
    else
    {
        $people0=$pg->getAutorsEn($row[people]);
        $avtbib=$pg->getAutorsBibEN($row[people]);

    }
    echo "<div class='autors_a mb-3'>";
    $avt_list="";
    $avt_list_short="";
    $avt_list_short_side="";
    foreach($people0 as $people)
    {
        if (!empty($people[id]) && $people[id] != '488' && $people[id]!='270')
        {
            $fios=$people[fio];
            if($_SESSION[jour_url]!='god_planety')
            {
                if($people[full_name_echo]==1) {
                    $fios = $people[name_surname];
                } else {
                    if ($_SESSION[lang] != '/en') {
                        $fios = $people[fioshort];
                    } else {
                        $fios = substr(mb_stristr($people[fioshort], " "), 1, 1) . ". " . mb_stristr($people[fioshort], " ", true);
                        $people[fioshort_side] = mb_stristr($people[fioshort], " ", true) . " " . substr(mb_stristr($people[fioshort], " "), 1, 1) . ".";
                    }
                }
            }
            $avt_list.=$fios.", ";
            if($people[full_name_echo]==1) {
                $avt_list_short.=$people[name_surname].", ";
                $avt_list_short_side.=$people[name_surname].", ";
            } else {
                $avt_list_short.=$people[fioshort_side].", ";
                $avt_list_short_side.=$people[fioshort].", ";
            }

            if ($people[otdel]!='Умершие сотрудники')
            {
                echo "<br />".
                    "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].$suff.">".
                    $fios."</a>";
                if (!empty($people[work])) echo ",<br />".$people[work];
                if (!empty($people[mail1]) && $people[mail1]!='no' && $_SESSION[jour_url]!='meimo') echo ", <a href=mailto:".$people[mail1].">".$people[mail1]."</a>";
            }
            else
                echo "<br /><span style='border:1px solid gray;'>".
                    "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].$suff.">".
                    $fios."</a></span>";
        }

    }
    if (!empty($avt_list)) $avt_list=substr($avt_list,0,-2);
    if (!empty($avt_list_short)) $avt_list_short=substr($avt_list_short,0,-2);
    if (!empty($avt_list_short_side)) $avt_list_short_side=substr($avt_list_short_side,0,-2);
    echo "</div>";
    if($_SESSION[lang]=="/en"){
        $row[number]=str_replace("Ежегодник", "Yearbook", $row[number]);
        if(!empty($row[number_en]))
            $row[number]=$row[number_en];
    }
    if($_SESSION[jour_url]!="meimo") {
        $vol_pos = strripos($row[number], "т.");
        if ($vol_pos === false) {
            if ($_SESSION[jour_url] == "god_planety" || $_SESSION[jour_url] == "oprme") {
                if (is_numeric(substr($row[number], 0, 1)))
                    echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $txt1 . " " . $row[number];
                else
                    echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $row[number];
            } elseif ($_SESSION[jour_url] == "WER")
                echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year];
            else
                echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $txt1 . " " . $row[number];
        } else {
            $volume = substr($row[number], $vol_pos);
            if ($_SESSION[lang] == '/en')
                $volume = str_replace("т.", "Vol.", $volume);
            else
                $volume = str_replace("т.", "Т.", $volume);
            $number = spliti(",", $row[number]);
            if ($_SESSION[jour_url] == "god_planety" || $_SESSION[jour_url] == "oprme") {
                if (is_numeric(substr($row[number], 0, 1)))
                    echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $volume . ", " . $txt1 . " " . $number[0];
                else
                    echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $row[number];
            } else
                echo "<div class='jrubric'>" . $row['name' . $suff2] . "<br />// " . $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $volume . ", " . $txt1 . " " . $number[0];
        }

        if ($_SESSION[lang] == "/en")
            $row[number] = str_replace("т.", "vol.", $row[number]);
        if (empty($volume)) {
            if ($_SESSION[jour_url] == "god_planety" || $_SESSION[jour_url] == "oprme") {
                if (is_numeric(substr($row[number], 0, 1)))
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $txt1 . " " . $row[number];
                else
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $row[number];
            } else {
                if ($_SESSION[jour_url] == "WER")
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year];
                elseif ($_SESSION[jour_url] != "meimo" && $_SESSION[jour_url] != "RNE")
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $txt1 . " " . $row[number];
                else
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $txt1 . " " . $row[number] . ", " . $row[year];
            }
        } else {
            if ($_SESSION[jour_url] == "god_planety" || $_SESSION[jour_url] == "oprme") {
                if (is_numeric(substr($row[number], 0, 1)))
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $volume . ", " . $txt1 . " " . $number[0];
                else
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $row[number];
            } else {
                if ($_SESSION[jour_url] != "meimo" && $_SESSION[jour_url] != "RNE")
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $volume . ", " . $txt1 . " " . $number[0];
                else
                    $jourissue = $rowj[0]['journal' . $suff2] . ". " . $row[year] . ". " . $volume . ", " . $txt1 . " " . $number[0];
            }
        }
        $issuename = $rowj[0]['journal' . $suff2];
        $issueyear = $row[year];
        $issuenumber = $row[number];
        if (!empty($row[pages]))
            echo ". " . $txtpage . " " . $row[pages];
        echo "</div><br />";
    }
    else
    {
        $vol_pos = strripos($row[number], "т.");
        if($vol_pos !== false) {
            $volume = substr($row[number], $vol_pos);
            if ($_SESSION[lang] == '/en')
                $volume = str_replace("т.", "Vol.", $volume);
            else
                $volume = str_replace("т.", "Т.", $volume);
            $number = spliti(",", $row[number]);
        }
        //echo "<div class='jrubric'>";
        if ($_SESSION[lang] != '/en') {
            if (empty($volume)) {
                //echo $avt_list_short . " " . $art_title . ". <i>" . $rowj[0]['journal' . $suff] . "</i>, " . $row[year] . ", " . $txt1 . " " . $row[number];
                $jourissue = $rowj[0]['journal' . $suff] . ". " . $row[year] . ", " . $txt1 . " " . $row[number];
            }
            else {
                //echo $avt_list_short . " " . $art_title . ". <i>" . $rowj[0]['journal' . $suff] . "</i>, " . $row[year] . ", " . $number[1] . ", " . $txt1 . " " . $number[0];
                $jourissue = $rowj[0]['journal' . $suff] . ". " . $row[year] . ", " . $number[1] . ", " . $txt1 . " " . $number[0];
            }
            //if (!empty($row[pages]))
                //echo ", " . $ppages . " " . $row[pages];
        } else {
            if (empty($volume)) {
                //echo $avt_list_short . " " . $art_title_en . ". <i>" . $rowj[0]['journal_en'] . "</i>, " . $row[year] . ", " . $txt1 . " " . str_replace("т.", "vol.", $row[number]);
                $jourissue = $rowj[0]['journal_en'] . ". " . $row[year] . ", " . $txt1 . " " . str_replace("т.", "vol.", $row[number]);
            }
            else {
                //echo $avt_list_short . " " . $art_title_en . ". <i>" . $rowj[0]['journal_en'] . "</i>, " . $row[year] . ", " . str_replace("т.", "vol.", $number[1]) . ", " . $txt1 . " " . $number[0];
                $jourissue = $rowj[0]['journal_en'] . ". " . $row[year] . ", " . str_replace("т.", "vol.", $number[1]) . ", " . $txt1 . " " . $number[0];
            }
            //if (!empty($row[pages]))
                //echo ", " . $ppages . " " . $row[pages];
        }
        //echo "</div><br />";

    }
    if (!empty($rowrs[0][rubric]) && $rowrs[0][rubric]!='1')
        echo "<div class='jrubric_a mb-3'>".
            $txt2.": <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID].
            "&id=".$rowrs[0][page_id].
            ">".$rowrs[0]['rubric'.$suff2]."</a>".

            "</div>";
    if (!empty($row[doi]))
        echo "<div class='jrubric_a mb-3'>DOI: ".$row[doi]."</div>";
    if($row['affiliation'.$suff2]!="<p>&nbsp;</p>")
        echo "<div>".$row['affiliation'.$suff2]."</div><br />";
    else
        echo "<br />";
    if (!empty($row[annots]) && $row[annots]!='<p>&nbsp;</p>' && $_SESSION[lang]!='/en')
    {
        if (!empty($row[annots]) && $row[annots]!='<p>&nbsp;</p>')
        {
            echo "<div class='jrubric_a'><b>Аннотация</b></div>";
            echo "<div class='annot_text text-justify'>".$row[annots]."</div><br />";
        }
    }

    if (!empty($row[annots_en]) && $row[annots_en]!='<p>&nbsp;</p>' && $_SESSION[lang]=='/en')
    {
        if (!empty($row[annots_en]) && $row[annots_en]!='<p>&nbsp;</p>') echo "<br /><div class='jrubric_a'><b>Abstract</b></div>";

        if (strpos($row[annots_en], '<p style="text-align: center;">REFERENCES</p>') !== false) {
            echo "<div class='annot_text text-justify'>".substr($row[annots_en], 0, strpos($row[annots_en], '<p style="text-align: center;">REFERENCES</p>'))."</div><br>";
        }
        else
            echo "<div class='annot_text text-justify'>".$row[annots_en]."</div><br />";
    }
    if (!empty($row[add_text]) && $row[add_text]!='<p>&nbsp;</p>' && $_SESSION[lang]!='/en')
    {
        echo "<div>".$row[add_text]."</div><br />";
    }
    if (!empty($row[add_text_en]) && $row[add_text_en]!='<p>&nbsp;</p>' && $_SESSION[lang]=='/en')
    {
        echo "<div>".$row[add_text_en]."</div><br />";
    }
    //    if (!empty($row[keyword]) || ! empty($row[keyword_en]))
    //   {
    if (!empty($row[keyword]) && $row[keyword]!='<p>&nbsp;</p>' && $_SESSION[lang]!='/en')
    {
        echo "<div class='jrubric_a'><b>Ключевые слова</b></div>";
        echo "<div class='annot_text'>".$row[keyword]."</div><br />";
    }
    if (!empty($row[keyword_en]) && $row[keyword_en]!='<p>&nbsp;</p>' && $_SESSION[lang]=='/en')
    {
        if (!empty($row[keyword_en]) && $row[keyword_en]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Keywords</b></div>";
        echo "<div class='annot_text'>".$row[keyword_en]."</div><br />";
    }


    if (!empty($row[contents]) && $_SESSION[lang]!='/en' && $row[contents]!="<p>&nbsp;</p>")
    {

        //   if (!empty($row[contents]) && $row[contents]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Аннотация</b></div>";
        echo "<div class='annot_text'>".$row[contents]."</div><br />";
    }
    if (!empty($row[contents_en]) && $_SESSION[lang]=='/en' && $row[contents_en]!="<p>&nbsp;</p>")
    {

        //   if (!empty($row[contents]) && $row[contents]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Аннотация</b></div>";
        echo "<div class='annot_text'>".$row[contents_en]."</div><br />";
    }

    if (!empty($row[annots_en]) && isset($_REQUEST[en])) {
        if (strpos($row[annots_en], '<p style="text-align: center;">REFERENCES</p>') !== false) {
            echo "<div class='annot_text'>".substr($row[annots_en], strpos($row[annots_en], '<p style="text-align: center;">REFERENCES</p>'))."</div><br />";
        }
    }
    //         }

/////////

    if (strpos($row['link'],'href=',0) >0)
    {

        /* if(strpos($row['link'],"http:")==0)
        {
          $row['link']=str_replace("/files/File/","http://".$_SERVER[HTTP_HOST]."/files/File/",$row['link']);

        }
         if(strpos($row['link_en'],"http:")==0)
        {
          $row['link_en']=str_replace("/files/File/","http://".$_SERVER[HTTP_HOST]."/files/File/",$row['link_en']);

        }*/

        if(strpos($row['link'],"https:")==0 && strpos($row['link'],"http:")==0)
        {
            $row['link']=str_replace("/files/File/","https://".$_SERVER[HTTP_HOST]."/files/File/",$row['link']);

        }
        if(strpos($row['link_en'],"https:")==0 && strpos($row['link'],"http:")==0)
        {
            $row['link_en']=str_replace("/files/File/","https://".$_SERVER[HTTP_HOST]."/files/File/",$row['link_en']);

        }
        $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";

        preg_match_all($filter,$row['link'],$res);
        //  print_r($res); echo "<br />";echo "<br />";
        $script_download = "";
        if($_SESSION[jour_url]=='meimo') {
            $script_download = "&script_download=1";
        }
        //  echo $res[0][0]." ".count($res)."**";
        for($i=0;$i<=count($res);$i++)
        {
            $row['link']=str_replace($res[0][$i],$_SESSION[lang]."/index.php?page_id=647&module=article&id=".$_REQUEST[id].$script_download."&param=".str_replace(' ','^',$res[0][$i]),$row['link']);
        }

        preg_match_all($filter,$row['link_en'],$res_en);
        //  print_r($res); echo "<br />";echo "<br />";
        //  echo $res[0][0]." ".count($res)."**";
        for($i=0;$i<=count($res_en);$i++)
        {
            $row['link_en']=str_replace($res_en[0][$i],$_SESSION[lang]."/index.php?page_id=647&module=article&id=".$_REQUEST[id].$script_download."&param=".str_replace(' ','^',$res_en[0][$i]),$row['link_en']);
        }

//   echo $row['link'];
        if($_SESSION[jour_url]!='meimo') {
            if($_SESSION[lang]=="/en") {
                if(!empty($row['link_en']) && $row['link_en']!='<p>&nbsp;</p>')
                    $link_text=$row['link_en'];
                else
                    $link_text=str_replace('Текст','Text',str_replace("Текст статьи", "Text", $row['link']));
            }
            else
                $link_text=$row['link'];

            echo "<div class='article_pdf'><div class='jrubric_a'>".str_replace("<a ","<a title='".$txt3."' ",$link_text)."</div></div>";
        }
        else
        {
            if(($_SESSION['meimo_authorization']==1) || $row['fulltext_open']==1) {
                if($_SESSION[lang]=="/en") {
                    if(!empty($row['link_en']) && $row['link_en']!='<p>&nbsp;</p>')
                        $link_text=$row['link_en'];
                    else
                        $link_text=str_replace('Текст','Text',str_replace("Текст статьи", "Text", $row['link']));
                }
                else
                    $link_text=$row['link'];

                echo "<div class='article_pdf'><div class='jrubric_a'>".str_replace("<a ","<a title='".$txt3."' ",$link_text)."</div></div>";
            }
        }
    }
//////////

    ////////////
    if (!empty($row[rinc]))
    {
        if($_SESSION[lang]!='/en')
            echo "<a href=".$row[rinc].">Размещено в РИНЦ</a><br><br>";
        else echo "<a href=".$row[rinc].">Registered in system SCIENCE INDEX</a><br><br>";
    }
    //if (empty($row[annots]) && !empty($row['contents'])) echo $row[contents];


    ///////////
    if ($_SESSION[lang]!='/en')
    {
        // print_r($rowj);
        echo "<div style='padding:2px;border:1px solid #EEE9E9;background-color:#EEE9E9;'> Правильная ссылка на статью: <br /><br />";
        echo "<h6 style='font-weight: bold'>"."";
        if($_SESSION[jour_url]=="god_planety" || $_SESSION[jour_url]=="oprme") {
            if(is_numeric(substr($row[number], 0,1)))
                echo $avt_list_short." ".$art_title.". ".$rowj[0]['journal'.$suff].". — ". $row[year].". — ".$txt1." ".$row[number];
            else
                echo $avt_list_short." ".$art_title.". ".$rowj[0]['journal'.$suff].". — ". $row[year];
        } elseif($_SESSION[jour_url]=="PEBq") {

            echo $avt_list_short." ".ltrim(ltrim($art_title,"1234567890.")," ").". <i>".str_replace(" (квартальный)","",$rowj[0]['journal'.$suff])."</i>, ". $row[year].", ".$txt1." ".$row[number];
        }
        else {
            if(empty($volume)) {
                if($_SESSION[jour_url]=="WER")
                    echo $avt_list_short." ".$art_title.". <i>".$rowj[0]['journal'.$suff]."</i>, ". $row[year];
                else
                    echo $avt_list_short." ".$art_title.". <i>".$rowj[0]['journal'.$suff]."</i>, ". $row[year].", ".$txt1." ".$row[number];
            }
            else
                echo $avt_list_short." ".$art_title.". <i>".$rowj[0]['journal'.$suff]."</i>, ". $row[year].", ".$number[1].", ".$txt1." ".$number[0];
        }
        if (!empty($row[pages]))
            echo ", ".$ppages." ".$row[pages];
        if (!empty($row[doi])) echo ". <a href=\"https://doi.org/".$row[doi]."\">https://doi.org/".$row[doi]."</a>";
        echo  "</h6></div><br />";
    }
    else
    {
        echo "<div style='padding:2px;border:1px solid #EEE9E9;background-color:#EEE9E9;'> For citation: <br />";
        echo "<h6 style='font-weight: bold'>"."";
        if($_SESSION[jour_url]=="god_planety" || $_SESSION[jour_url]=="oprme") {
            if(is_numeric(substr($row[number], 0,1)))
                echo $avt_list_short." ".$art_title_en.". ".$rowj[0]['journal_en'].". — ". $row[year].". — ".$txt1." ".str_replace("т.","vol.",$row[number]);
            else
                echo $avt_list_short." ".$art_title_en.". ".$rowj[0]['journal_en'].". — ". $row[year];
        }
        elseif($_SESSION[jour_url]=="PEBq") {

            echo $avt_list_short." ".ltrim(ltrim($art_title_en,"1234567890.")," ").". <i>".$rowj[0]['journal_en']."</i>, ". $row[year];
        }
        else {
            if(empty($volume)){
                if($_SESSION[jour_url]=="WER")
                    echo $avt_list_short." ".$art_title_en.". <i>".$rowj[0]['journal_en']."</i>, ". $row[year];
                else
                    echo $avt_list_short." ".$art_title_en.". <i>".$rowj[0]['journal_en']."</i>, ". $row[year].", ".$txt1." ".str_replace("т.","vol.",$row[number]);
            }
            else
                echo $avt_list_short." ".$art_title_en.". <i>".$rowj[0]['journal_en']."</i>, ". $row[year].", ".str_replace("т.","vol.",$number[1]).", ".$txt1." ".$number[0];
        }
        if (!empty($row[pages]))
            echo ", ".$ppages." ".$row[pages];
        if (!empty($row[doi])) echo ". <a href=\"https://doi.org/".$row[doi]."\">https://doi.org/".$row[doi]."</a>";
        echo  "</h6></div><br />";


    }




    echo "</div>";
    $jidcurr=$row[jid];

}

////////////// тэги
/////////////////  Когда будут тэги
//  $tags=explode(";",trim($row[tags]));
//  echo "тэги: ";
//  foreach ($tags as $tag)
//  {
//     if (!empty($tag))
//	     echo "<a href='index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_LIST]."&key='".$tag."' >".$tag."</a> | ";
//
//  }

/*
  if ($_REQUEST[at]=="a")
  {

       $rowns=$pg->getMagazineNumber($_REQUEST[jid]);





  echo "<div class='jrubric'>Все статьи автора в этом номере (".$rows[0][title]."):</div>";

  foreach($rowns as $k=>$row)
  {
  if (strpos($row[people],">".$_REQUEST[pid]."<")>0 ||substr($row[people],0,strlen($_REQUEST[pid])+1)==$_REQUEST[pid]."<")

  {


         echo "<div class='jarticle'>";
      	   $people0=$pg->getAutors($row[people]);
      	   echo "<div class='autors'>";
      	   foreach($people0 as $people)
      	   {
      	      echo "<a href=http://www.isras.ru/pers_about.html?id=".$people[id].">".$people[fio]."</a>"; //.$people[work].",".$people[mail1]."";
      	   }
      	   echo "</div>";
      	   echo "<div class='name'><a href=/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&at=a>".$row[name]."</a></div>";
      	   echo "</div>";
	}
  }
  }
  echo "<hr />";
*/

if(!empty($jourissue) && $jourissue!='<p>&nbsp;</p>') {
    echo "<hr />";
    echo "<div class='jrubric'>";
//  print_r($_REQUEST[jid]);
    echo $txt4;
    echo "<a style='text-decoration:underline;' href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $jidcurr . "&jj=" . $_REQUEST[jj] . $suff . ">" .
        $jourissue . "</a>";
    echo "</div>";
}

echo "<br clear='all'>";
//	 print_r($jour0);
//  $row[jtitle]=$jour0[0]['j_name'.$suff2];
$row[jtitle]=$jour0[0]['page_name'.$suff2];
$row[number]=$issuenumber;//$jour0[0]['page_name'];
$row[issn]=$jour0[0][issn];
$row[year]=$jour0[0][year];
$row[issue]=$jour0[0]['page_name'];
$row[vid]=2;
//         echo "<br /><br />____".$avtbib."<br />";print_r($row);

//echo "<br />";print_r($row); echo "<br />";print_r($jour0);
$bib=new BibEntry();
$aa=$bib->toCoinsMySQL($row,$avtbib);
print_r($aa);
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
