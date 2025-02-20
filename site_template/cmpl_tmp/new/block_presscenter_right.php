<!-- right column -->
<?php

global $_CONFIG, $DB, $site_templater, $page_content;

$pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.rightblock,p.mobile_right_totop, lc.cv_text AS left_col, rc.cv_text AS right_col
  FROM adm_pages AS p ".
    "INNER JOIN adm_pages_content AS lc ON lc.cv_name='LEFT_COLLUMN' AND lc.page_id=p.page_id ".
    "INNER JOIN adm_pages_content AS rc ON rc.cv_name='RIGHT_COLLUMN' AND rc.page_id=p.page_id ".
    " WHERE p.page_id=".(int)$_REQUEST[page_id]);

if($pname[0]['noright'] != '1'):

    $headers = new Headers();

    $elements = $headers->getHeaderElements($pname[0]['right_col']);
    $elements = $headers->appendContent($elements);



//$sliderMain = $DB->select('');
    ?>

                <?php
                if($_SESSION[jour_url]!='') {
                    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."text_magazine_right");
                }
                elseif(!empty($elements))
                {
                    foreach($elements as $k => $v)
                    {
                        $tpl = new Templater();
                        $tpl->setValues($v);
                        $tpl->setValues($v['content']);
                        $tpl->appendValues(array("HEADER_ID_EDIT" => $k));
                        if($v["ctype"] == "Ôèëüòð")
                            $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                        $tpl->appendValues(array("PERSON" => $_TPL_REPLACMENT["PERSON"]));
                        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
                    }
                    if($_GET[publ_smi]==1)
                    {
                        $tpl = new Templater();
                        $v["ctype"]="Ôèëüòð";
                        $tpl->setValues($v);
                        $tpl->appendValues(array("FILTERCONTENT" => $page_content["SMI_PUBL"]));
                        $tpl->appendValues(array("PERSON" => $_TPL_REPLACMENT["PERSON"]));
                        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
                    }
                }

                ?>
<?php endif; ?>