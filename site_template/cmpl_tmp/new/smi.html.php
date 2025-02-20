<?
global $_CONFIG, $site_templater;
if(!empty($_GET["specrub"])){
	global $DB;
	$specrubrics = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS rubric, ex.icont_text AS extra_section, exf.icont_text AS extra_section_flag
                    FROM adm_ilines_type AS c
                   INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=13 
                   INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
                   INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var= 'sort'
                   INNER JOIN adm_ilines_content AS ex ON ex.el_id=e.el_id AND ex.icont_var= 'extra_section'
                   INNER JOIN adm_ilines_content AS exf ON exf.el_id=e.el_id AND exf.icont_var= 'extra_section_flag'
                     ORDER BY s.icont_text");
	$site_templater->appendValues(array("TITLE" => $specrubrics[$_GET["specrub"]]["rubric"]));

	//Statistic::theCounter("specrub-".(int)$_GET[specrub]);
}
else {
    $eng_stat = "";
    if($_SESSION["lang"]=="/en")
        $eng_stat = "-en";
	//Statistic::theCounter("pageid-".(int)$_REQUEST[page_id].$eng_stat);
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if(!empty($_GET["specrub"])) {
    Statistic::ajaxCounter("specrub", (int)$_GET["specrub"]);
} else {
    Statistic::ajaxCounter("pageid", (int)$_REQUEST["page_id"]);
}


if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
//echo "<br />___".$_TPL_REPLACMENT["FULL_SMI_ID"].$_TPL_REPLACMENT["NEWS_LINE"];
$ilines = new Ilines();
//print_r($_TPL_REPLACMENT);


	if($_SESSION["lang"]!="/en")
	{
		$rows = $ilines->getLimitedElementsDateRub(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],"",false,$_REQUEST["year"],$_REQUEST["alfa"],$_REQUEST["author"]);
		//$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status"); // Ќеправильно тк сразу длЯ двух рубрик кол-во
		$news_count = count($ilines->getLimitedElementsDateRubNoLimit(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],"",$_REQUEST["year"],$_REQUEST["alfa"],$_REQUEST["author"]));

        $foundCountText = "Всего найдено: $news_count публикаций";
    }
	else
	{
		$rows = $ilines->getLimitedElementsDateRubEn(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],"",false,$_REQUEST["year"],$_REQUEST["alfa"],$_REQUEST["author"]);
		//$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status"); // Ќеправильно тк сразу длЯ двух рубрик кол-во
		$news_count = count($ilines->getLimitedElementsDateRubNoLimitEn(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],"",$_REQUEST["year"],$_REQUEST["alfa"],$_REQUEST["author"]));
        $foundCountText = "Total found: $news_count publications";
	}
//echo $news_count."@".$_TPL_REPLACMENT["COUNT"];

	if($news_count>0) {

        $pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3, true);

        $pg = new Pages();
        //print_r($pages);
        if(!empty($_TPL_REPLACMENT["TPL_NAME"]))
           $tplname=$_TPL_REPLACMENT["TPL_NAME"];
        else
           $tplname='smi';
        if($_SESSION["lang"]!="/en") {
            if (!empty($_TPL_REPLACMENT["ANONS"]) && $_TPL_REPLACMENT["ANONS"]!="<p>&nbsp;</p>")
        echo $_TPL_REPLACMENT["ANONS"]."<span class='hr'>&nbsp;</span><br /><br />";
        }

        if(!empty($_GET["specrub"])){


            if($_GET["specrub"]==-1){
                foreach ($specrubrics as $key => $value) {
                    if($value["extra_section_flag"]==1)
                        if(!empty($value["extra_section"]) && $value["extra_section"]!="<p>&nbsp;</p>")
                            echo $value["extra_section"]."<br />";
                }
            }
            else
            {
                if(!empty($specrubrics[$_GET["specrub"]]["extra_section"]) && $specrubrics[$_GET["specrub"]]["extra_section"]!="<p>&nbsp;</p>")
                    echo $specrubrics[$_GET["specrub"]]["extra_section"]."<br />";
            }

        }
        $pages_lang = "Страницы";
            if($_SESSION["lang"]=="/en")
                $pages_lang = "Pages";
        //echo count($pages);
        //if(@count($pages) > 1)
        //{
        //	echo "<b>".$pages_lang.":</b>&nbsp;&nbsp; ";
        //}

        ?>
        <div><b><?=$foundCountText?></b></div>

            <nav class="mt-2">
                <ul class="pagination pagination-sm flex-wrap">
                    <?php
                    $addParams = array();

                    if(!empty($_REQUEST['year'])) {
                        $addParams['year'] = $_REQUEST['year'];
                    }
                    if(!empty($_REQUEST['alfa'])) {
                        $addParams['alfa'] = $_REQUEST['alfa'];
                    }
                    $spe2 = Pagination::createPagination($news_count,$_TPL_REPLACMENT["COUNT"],$addParams);
                    echo $spe2;
                    ?>
                </ul>
            </nav>
        <?php

        $i=1;
        if(!empty($rows))
        {

            $rows = $ilines->appendContent($rows);

            if(empty($_REQUEST["p"]))
                $currentPage=0;
            else
                $currentPage=(int)$_REQUEST["p"]-1;
            $elementCounter = $_TPL_REPLACMENT["COUNT"]*$currentPage+1;
            foreach($rows as $k => $v)
            {
            //	print_r($v);
                $tpl = new Templater();
                if(isset($v["content"]["DATE"]))
                {
                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
                    $v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                    if(!empty($year_counter[date("Y", $v["content"]["DATE"])]))
                        $year_counter[date("Y", $v["content"]["DATE"])]++;
                    else
                        $year_counter[date("Y", $v["content"]["DATE"])] = 1;
                    $v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
                }


                $tpl->setValues($v["content"]);
        //		$tpl->appendValues($_TPL_REPLACMENT);
                $tpl->appendValues(array("ID" => $k));
                $tpl->appendValues(array("NUMBER" => $i));
                $tpl->appendValues(array("TITLE_NEWS" => $v["content"]["TITLE"]));
                $tpl->appendValues(array("RET" => $_REQUEST["page_id"]));
                $tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT["FULL_SMI_ID"]));
                $tpl->appendValues(array("GO" => false));
                $tpl->appendValues(array('COUNTER_EL' => $elementCounter));
                if(!empty($v["content"]["FULL_TEXT"]))
                    $tpl->appendValues(array("GO" => true));

                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$tplname.".html");
                $i++;
                $elementCounter++;
            }

            if(isset($_GET["printmode"])) {
                foreach ($year_counter as $year => $year_count) {
                    echo "<br> Год: $year. Количество: $year_count";
                }
            }
        }
        echo "<br />";
        ?>
        <nav class="mt-2">
            <ul class="pagination pagination-sm flex-wrap">
                <?php
                echo $spe2;
                ?>
            </ul>
        </nav>
        <?php
    } else {
	    if($_SESSION['lang']!="/en") {
	        echo "По вашему запросу не найдено элементов. Измените условия поиска.";
        } else {
	        echo "No elements were found for your query.";
        }
    }

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>