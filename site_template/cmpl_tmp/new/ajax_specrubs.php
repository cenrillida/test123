<?php
global $_CONFIG, $site_templater;

$current_number = (int)$_GET['ajax_specrubs'];

if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=502;
if (empty($_TPL_REPLACMENT["SORT_TYPE"])) $_TPL_REPLACMENT["SORT_TYPE"]="DESC";
if (empty($_TPL_REPLACMENT["SORT_FIELD"])) $_TPL_REPLACMENT["SORT_FIELD"]="date";
if (empty($_TPL_REPLACMENT["COUNT"])) $_TPL_REPLACMENT["COUNT"]=9;

$ilines = new Ilines();

$pages = new Pages();

$branch = $pages->getBranch((int)$_REQUEST[page_id],1);

$specrubs = array();
foreach ($branch as $page) {
    $specrubs[] = $page['page_id'];
}

$rows = $ilines->getLimitedElementsDateRubSpecRub("*", @$_TPL_REPLACMENT["COUNT"], $current_number, @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],$specrubs);

if(!empty($_TPL_REPLACMENT[TPL_NAME]))
    $tplname=$_TPL_REPLACMENT[TPL_NAME];
else
    $tplname='smi_specrub';

$i=1+($_TPL_REPLACMENT["COUNT"]*($current_number-1));
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
            $v["content"]["DATE"] = date("d.m.Y ã.", $v["content"]["DATE"]);
        }

        $tpl->setValues($v["content"]);
        //		$tpl->appendValues($_TPL_REPLACMENT);
        $tpl->appendValues(array("ID" => $k));
        $tpl->appendValues(array("NUMBER" => $i));
        $tpl->appendValues(array("TITLE_NEWS" => $v[content][TITLE]));
        $tpl->appendValues(array("PDF_FILE" => $v[content][PDF_FILE]));
        $tpl->appendValues(array("RET" => $_REQUEST[page_id]));
        $tpl->appendValues(array("COMMENT_COLOR" => $_TPL_REPLACMENT["COMMENT_COLOR"]));
        $tpl->appendValues(array("SPECRUB" => $_REQUEST[specrub]));
        $tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT[FULL_SMI_ID]));
        $tpl->appendValues(array("ROW_COUNT" => $_TPL_REPLACMENT["ROW_COUNT"]));
        $tpl->appendValues(array("GO" => false));
        $tpl->appendValues(array('COUNTER_EL' => $elementCounter));
        if(!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"]!="<p>&nbsp;</p>")
            $tpl->appendValues(array("GO" => true));

        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$tplname.".html");
        $i++;
        $elementCounter++;
    }
}