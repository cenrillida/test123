<?php

global $_CONFIG, $DB, $site_templater, $page_content;
if (!empty($_REQUEST["id"]) && substr($dd[0]["page_template"],0,8)=='magazine' && $dd[0]["page_template"]!='magazine_author')
{
    $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".(int)$_REQUEST["id"].
        " WHERE p.page_id=".(int)$_REQUEST["page_id"]);

}
else
    $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.rightblock,p.mobile_right_totop,p.nocomment
	  FROM adm_pages AS p ".

        " WHERE p.page_id=".(int)$_REQUEST["page_id"]);



?>
</div>
</div>
<?php if($pname[0]['nocomment']!="1"):?>
<div class="row shadow border bg-white mt-5">
    <div class="col-12 p-lg-5 p-md-3 py-4">
        <?php
                include($_TPL_REPLACMENT['NEWSITE_COMMENT']);
        ?>
    </div>
</div>
<?php endif;?>
</div>
</div>
<!-- right column -->

<?php


if($pname[0]['noright'] != '1' && $_TPL_REPLACMENT['NO_RIGHT_COLUMN']!='1'):

$headers = new Headers();

if($_TPL_REPLACMENT['MAG_HEADER'] == 1 && !empty($_TPL_REPLACMENT["RIGHT_COLLUMN"])) {
    $elements = $headers->getHeaderElements($_TPL_REPLACMENT["RIGHT_COLLUMN"]);
    $elements = $headers->appendContent($elements);
} else {
    if (empty($pname[0]['rightblock']))
        $elements = $headers->getHeaderElements("Текст - Новый сайт Правая колонка");
    else {
        $rightBlocks = explode(";",$pname[0]['rightblock']);
        $elements = array();
        foreach ($rightBlocks as $rightBlock) {
            $elementsTemp = $headers->getHeaderElements($rightBlock);
            foreach ($elementsTemp as $k=>$v) {
              $elements[$k] = $v;
            }
            //$elements = array_merge($elements,$headers->getHeaderElements($rightBlock));
        }


    }
    $elements = $headers->appendContent($elements);
}




//$sliderMain = $DB->select('');
?>
<div class="<?php if(!empty($_TPL_REPLACMENT['LEFT_BLOCK_CUSTOM_SIZE'])) echo 'col-xl-'.(12-$_TPL_REPLACMENT['LEFT_BLOCK_CUSTOM_SIZE']); else echo 'col-xl-3';?> d-block pt-3 pb-3 px-xl-0 right-column<?php if($pname[0]['mobile_right_totop']) echo ' order-first order-xl-last'; ?>">
    <div class="right-column-fake"></div>
    <div class="right-column-stick pr-xl-3">
        <div class="container-fluid">
            <?php
            if($_SESSION["jour_url"]!='') {
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."text_magazine_right");
            }
            elseif(!empty($elements))
            {
                foreach($elements as $k => $v)
                {

                    $tpl = new Templater();
                    $tpl->setValues($v);
                    $tpl->appendValues(array("HEADER_ID_EDIT" => $k));
                    if($v["ctype"] == "Фильтр")
                        $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                    if($_TPL_REPLACMENT['MAG_HEADER'] == 1 && !empty($_TPL_REPLACMENT["RIGHT_COLLUMN"])) {
                        $tpl->setValues($v['content']);
                        $tpl->appendValues(array("HEADER_ID_EDIT" => $k));

                        $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                        $tpl->appendValues(array("YEARS_ID" => $_TPL_REPLACMENT["YEARS_ID"]));
                        $tpl->appendValues(array("ARCHIVE_ID" => $_TPL_REPLACMENT["ARCHIVE_ID"]));
                        $tpl->appendValues(array("ART_ARCHIVE_EN_ID" => $_TPL_REPLACMENT["ART_ARCHIVE_EN_ID"]));
                        $tpl->appendValues(array("RUBRICS_ID" => $_TPL_REPLACMENT["RUBRICS_ID"]));
                        $tpl->appendValues(array("AUTHORS_YEARS_ID" => $_TPL_REPLACMENT["AUTHORS_YEARS_ID"]));
                        $tpl->appendValues(array("AUTHORS_ID" => $_TPL_REPLACMENT["AUTHORS_ID"]));
                        $tpl->appendValues(array("SEND_ARTICLE_ID" => $_TPL_REPLACMENT["SEND_ARTICLE_ID"]));
                        $tpl->appendValues(array("MAIN_JOUR_ID" => $_TPL_REPLACMENT["MAIN_JOUR_ID"]));
                        $tpl->appendValues(array("NO_PREFIX" => $_TPL_REPLACMENT["NO_PREFIX"]));

                        if(isset($_TPL_REPLACMENT['RIGHT_BLOCK_BACK_OFF']) && $_TPL_REPLACMENT['RIGHT_BLOCK_BACK_OFF']==1) {
                            $headers->displayWithTemplate($tpl, 0,$v['content']['CACHE'],$v['el_id']);
                        } else {
                            $headers->displayWithTemplate($tpl, 1,$v['content']['CACHE'],$v['el_id']);
                        }
                    } else {
                        $tpl->appendValues($v['content']);
                        $headers->displayWithTemplate($tpl, 0,$v['content']['CACHE'],$v['el_id']);
                    }
                }
                if($_GET["publ_smi"]==1)
                {
                    $tpl = new Templater();
                    $v["ctype"]="Фильтр";
                    $tpl->setValues($v);
                    $tpl->appendValues(array("FILTERCONTENT" => $page_content["SMI_PUBL"]));
                    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
                }
            }

            ?>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
</div>
</section>

<?php
	global $_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");

?>

