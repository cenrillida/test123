<?
global $DB, $DBH, $_CONFIG, $site_templater;

if(!empty($_REQUEST['publid'])) {
    $site_templater->appendValues(array("NO_RIGHT_COLUMN" => '1'));
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if($_GET['vid']==428 && $_GET['year']==2020) {
    ?>
    <div class="text-right"><b>Библиографические описания статей сделаны в соответствии с ГОСТ Р 7.0.100–2018</b></div>
<?php
}

if ($_SESSION["lang"]!='/en')
{
    $next_txt='следующая';
    $prev_txt='предыдущая';
    $delayed='отложить';
    $delayed2='Вы сохранили эту публикацию';
    $articleText = "Текст статьи";
}
else
{
    $next_txt='next';
    $prev_txt='previous';
    $delayed='save';
    $delayed2='You save this publication';
    $articleText ="Text";
}

if(empty($_REQUEST["page"])) {
    $_REQUEST["page"] = 1;
}

// Сколько публикаций выводить на одном листе

$pp = new Publications();
//if(!empty($_GET['fio'])) {
    $pp->setWithAfjourn(true);
//}

if(empty($_TPL_REPLACMENT['COUNT'])) {
    $_TPL_REPLACMENT['COUNT'] = 40;
}

$pp->performQueryForList($_REQUEST,$_TPL_REPLACMENT['COUNT']);


///////////////////////////////////////////////////////////////////////////////////////////////////
// Последние поступления
if (isset($_REQUEST["last"]))
{
    $lastcount0=$DB->select("SELECT count(id) AS count,substring(date,7,2) AS year,substring(date,4,2) AS month FROM `publ` WHERE 1 GROUP BY substring(date,7,2),substring(date,4,2) ORDER BY substring(date,7,2) DESC,substring(date,4,2) DESC");
    $lastcount=0;
    $ii=0;
    foreach($lastcount0 as $ll)
    {
        $ii++;
        if ($ll["year"]<date('y')-2) break;
        if ($ll["year"]<(date('y')-1) && $ii>3) break;

        if ($lastcount>50) break;

        $lastcount+=$ll['count'];
        $yearlast=$ll["year"];
        $monthlast=$ll["month"];
        $pole="date,";
        $search_string="1 AND ";
        $order="substring(z.date,7,2) DESC,substring(z.date,4,2) DESC, substring(z.date,1,2) DESC";
    }
}

///////////

$numpubl = $pp->getListCountAfterQuery($_GET,$_TPL_REPLACMENT['COUNT']);

///////////////////////////////////
// Всего страниц

$spe2 = Pagination::createPagination($numpubl,$_TPL_REPLACMENT['COUNT'],$_GET,"page");

$publ0 = $pp->getListAfterQuery($_REQUEST,$_TPL_REPLACMENT['COUNT'], $_REQUEST['page']);

echo "<div style='position:relative;'>";

echo "</div>";

////////////////// Начало печати ///////////////////////
if (!isset($_REQUEST["en"]))
    echo "<b>Всего найдено: ".$numpubl." публикаций</b>";
else
    echo "<b>Total found: ".$numpubl." publications</b>";

//if ($numpubl>$nn_page)
//    echo "<br />".$spe."";

if ($numpubl>$_TPL_REPLACMENT['COUNT']) {
    ?>
    <nav class="mt-2">
        <ul class="pagination pagination-sm flex-wrap">
            <?=$spe2?>
        </ul>
    </nav>
    <?php
}

$ii=($_REQUEST["page"]-1)*$_TPL_REPLACMENT['COUNT'];;

foreach($publ0 as $publ)
{
    $ii++;

    if(empty($publ["picsmall"]) && $_SESSION["lang"]!='/en')
    {
        switch ($publ["tip"]) {
            case 441:
                $publ["picsmall"]='e_logo_2_book.jpg';
                break;
            case 442:
                $publ["picsmall"]='e_logo_2_journal.jpg';
                break;
            case 443:
                $publ["picsmall"]='e_logo_2_electronic.jpg';
                break;

            default:
                $publ["picsmall"]='e_logo_2.jpg';
                break;
        }
    }
    if(empty($publ["picsmall"]) && $_SESSION["lang"]=='/en')
    {
        switch ($publ["tip"]) {
            case 441:
                $publ["picsmall"]='e_logo_2_book.jpg';
                break;
            case 442:
                $publ["picsmall"]='e_logo_2_journal_en.jpg';
                break;
            case 443:
                $publ["picsmall"]='e_logo_2_electronic_en.jpg';
                break;

            default:
                $publ["picsmall"]='e_logo_2_en.jpg';
                break;
        }
    }
        $pfoto="
      			<img  alt='/dreamedit/pfoto/".$publ["picsmall"]."' title='".str_replace("'"." ",$publ["name"])."'".
            "src=/dreamedit/pfoto/".$publ["picsmall"]."  border=3 style='border-color:#cecce8;' hspace=20 vspace=2 /><br />
               ";
    if ($publ["id"]<0) {
        preg_match_all('@src="([^"]+)"@', $publ["picsmall"], $imgSrc);
        $imgSrc = array_pop($imgSrc);
        if (empty($imgSrc)) {
            preg_match_all('@src="([^"]+)"@', $publ["picsmall"], $imgSrc);
            $imgSrc = array_pop($imgSrc);
            if (empty($imgSrc)) {
                if (empty($row['logo'])) {
                    $image_url = '/dreamedit/pfoto/e_logo_slider.jpg';
                } else
                    $image_url = '/dreamedit/pfoto/' . $publ["picsmall"];
            } else
                $image_url = $imgSrc[0];
        } else
            $image_url = $imgSrc[0];

        $pfoto = "
                <img title='" . str_replace("'" . " ", $publ["name"]) . "'" .
            "src=" . $image_url . "  border=3 style='border-color:#cecce8; width: 70px;' hspace=20 vspace=2 /><br />
               ";
    }
    echo "<div class='row py-3'><div class='col-2 col-lg-1 my-auto'>".
        $pfoto.
        "</div><div class='col-10 col-lg-9'>";


    if (($publ["avthide"]!='on' && $publ["hide_autor"]!='on' )&& $publ["avtor"]!='Коллектив авторов' && strpos($publ["avtor"],"Коллектив авторов")===false)
    {

        $avt=$pp->getAuthors($publ["avtor"],$_TPL_REPLACMENT["PERSONA_PAGE"]);
        if ($publ["parent_id2"]==0)
            echo "".$ii.". ".$avt[0]."<br />";
        else
            echo " >> ".$avt[0].". ";
    }
    else
    {
        echo $ii.". ";
    }


    if ($publ['id']>0) {
        echo  "<a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["PUBL_PAGE"]."&id=".$publ["id"];
        echo      " title='more...' >";
    } else {
        echo "<a href=" . $_SESSION['lang'] . $publ['link'];
        echo " title='more...' >";
    }

    if($publ['id']>0) {
        if (!isset($_REQUEST["en"]) || empty($publ["name2"])) echo str_replace("<p>&nbsp;</p>", "", $publ["name"]); else echo str_replace("<p>&nbsp;</p>", "", $publ["name2"]);
    } else {
        $pg = new MagazineNew();
        if($publ['magazine_id']=='-1') {
            $referenceLink = $pg->getReferenceLink(-$publ['id'], false, false, true,true);
            echo $referenceLink;
        } else {
            $referenceLink = $pg->getReferenceLink(-$publ['id'], false, false, true);
            echo $referenceLink;
        }
    }

    echo "</a>";
    if (isset($_REQUEST["last"]))
    {
        if ($_SESSION["lang"]!='/en')
            echo "<br />Дата размещения: ".$publ['date'];
        else
            echo "<br />Date in the Catalog: ".substr($publ['date'],3,2)."/".substr($publ['date'],0,2)."/".substr($publ['date'],6,2);
    }

    if($publ['id']>0) {

            if ($_SESSION["lang"]=='/en')
                $publ['link'] = str_replace("<p>&nbsp;</p>","",$publ['link_en']);
            else
                $publ['link'] = str_replace("<p>&nbsp;</p>","",$publ['link']);

            if (strpos($publ['link'],'/files/el/',0) >0)
            {
                echo $publ['link'];
            }
            else
            {

                if (strpos($publ['link'],'href=',0) >0)
                {
                    $publ['link'] = str_replace("\"/files","\"https://imemo.ru/files",$publ['link']);
                    $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]\.pdf/i";

                    preg_match_all($filter,$publ['link'],$res);

                    for($i=0;$i<=count($res);$i++)
                    {
                        $publ['link']=str_replace($res[0][$i],"/index.php?page_id=647&module=publ&id=".$publ["id"]."&param=".str_replace(' ','^',$res[0][$i]),$publ['link']);
                    }

                    $publ['link'] = preg_replace("/<img[^>]+src=\"(https?:\/\/(www\.)?imemo\.ru)?\/files\/Image\/pdf\.gif\"[^>]*\/? ?> ?(&nbsp;)?/i","<i class=\"far fa-file-pdf text-danger\"></i> ",$publ['link']);
                    $publ['link'] = preg_replace("/<img[^>]+src=\"(https?:\/\/(www\.)?imemo\.ru)?\/files\/Image\/internet_explorer\.png\"[^>]*\/? ?> ?(&nbsp;)?/i","",$publ['link']);


                    echo $publ['link'];
                }
            }

    } else {
        if($_SESSION["lang"]=='/en') {
            if(!empty($publ['magazine_file_link_en']) && $publ['magazine_file_link_en']!='<p>&nbsp;</p>')
                $publ['magazine_file_link']=$publ['magazine_file_link_en'];
        }
        $publ['magazine_file_link'] = str_replace("<p>&nbsp;</p>","",$publ['magazine_file_link']);

        if(strpos($publ['magazine_file_link'],"https:")==0 && strpos($publ['magazine_file_link'],"http:")==0)
        {
            $publ['magazine_file_link']=str_replace("/files/File/","https://".$_SERVER["HTTP_HOST"]."/files/File/",$publ['magazine_file_link']);

        }
        $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";
        preg_match_all($filter,$publ['magazine_file_link'],$res);

        //  print_r($res); echo "<br />";echo "<br />";
        //  echo $res[0][0]." ".count($res)."**";

        if($publ['magazine_id']=='-1') {
            if(!empty($res) && !empty($res[0]) && !empty($res[0][0])) {
                $res[0][0] = str_replace("imemo.ru/","afjournal.ru/",$res[0][0]);
                $publ['magazine_file_link'] = "<p><a href=\"{$res[0][0]}\" target=\"_blank\">{$articleText}</a></p>";
            } else {
                $publ['magazine_file_link'] = '';
            }
        } else {
            for($i=0;$i<=count($res);$i++)
            {
                if($publ['magazine_id']!=1614) {
                    $publ['magazine_file_link'] = str_replace($res[0][$i], $_SESSION["lang"] . "/index.php?page_id=647&module=article&id=" . (-$publ['id']) . "&param=" . str_replace(' ', '^', $res[0][$i]), $publ['magazine_file_link']);
                } else {
                    $publ['magazine_file_link'] = str_replace($res[0][$i],$_SESSION["lang"]."/index.php?page_id=647&module=article&script_download=1&id=".(-$publ['id'])."&param=".str_replace(' ','^',$res[0][$i]),$publ['magazine_file_link']);
                }
            }
        }

        $linkRegex = array();

        preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>(.+)<\/a>/iU",$publ['magazine_file_link'],$linkRegex);

        $text = $linkRegex[2][0];
        $link = $linkRegex[1][0];
        if ($_SESSION["lang"] == '/en') {
            $text = str_replace('Текст', 'Text', str_replace('Текст статьи', 'Text', str_replace('Титул и содержание', 'Title and content', $text)));
        }


        $numberId = $pg->getNumberIdByArticleId(-$publ['id']);
        $numberContent = $pg->getArticleContentByPageId($numberId);

        if($publ['magazine_id']!=1614 || $publ['fulltext_open']==1 || $numberContent['FULL_TEXT_OPEN']==1 || ($publ['author_open_text']==1 && !empty($_REQUEST['fio']))) {

            if(empty($publ['magazine_file_link'])) {
                echo "<div class='mb-3'> &nbsp;</div>";
            } else {

                if(!empty($text) && !empty($link)) {
                    echo "<div class='mb-3'><i class=\"far fa-file-pdf text-danger\"></i> <a target='_blank' href=\"".$link."\">".$text."</a></div>";
                }
            }
        }
    }

    echo "</div></div>";


    $bib=new BibEntry();
    $aa=$bib->toCoinsMySQL($publ,$avt[1]);
    print_r($aa);
}
//if ($numpubl>$nn_page)
//    echo "<br /><br />".$spe;

if ($numpubl>$_TPL_REPLACMENT['COUNT']) {
    ?>
    <nav>
        <ul class="pagination pagination-sm flex-wrap">
            <?=$spe2?>
        </ul>
    </nav>
    <?php
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
