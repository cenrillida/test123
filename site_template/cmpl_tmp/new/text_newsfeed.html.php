<?
global $_CONFIG, $site_templater, $DB;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
    if($_SESSION[lang]!='/en') {
        $lang_query = "";
        if ($_SESSION[lang] == '/en')
            $lang_query = "_en";
        $count_n = 8;
        $page_n = $_REQUEST["p"];
        $start_q = "";
        $start_q = (int)$page_n < 1 ? 0 : ((int)$page_n - 1) * $count_n;
        $newsfeed = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS title, len.icont_text AS title_en, d.icont_text AS 'date', ft.icont_text AS full_text, ften.icont_text AS full_text_en, li.icont_text AS link
                FROM adm_ilines_type AS c
               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=" . (int)$_TPL_REPLACMENT["ID_NEWS"] . " 
               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
               INNER JOIN adm_ilines_content AS len ON len.el_id=e.el_id AND len.icont_var= 'title_en'
               INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var= 'date'
               INNER JOIN adm_ilines_content AS ft ON ft.el_id=e.el_id AND ft.icont_var= 'full_text'
               INNER JOIN adm_ilines_content AS li ON li.el_id=e.el_id AND li.icont_var= 'link'
               INNER JOIN adm_ilines_content AS ften ON ften.el_id=e.el_id AND ften.icont_var= 'full_text_en'
               INNER JOIN adm_ilines_content AS st ON st.el_id=e.el_id AND st.icont_var= 'status" . $lang_query . "'
               WHERE st.icont_text='1'
                 ORDER BY d.icont_text DESC LIMIT " . (int)$start_q . ", " . (int)$count_n);
        $newsfeed_count = count($DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS title, len.icont_text AS title_en, d.icont_text AS 'date', ft.icont_text AS full_text, ften.icont_text AS full_text_en, li.icont_text AS link
                FROM adm_ilines_type AS c
               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=" . (int)$_TPL_REPLACMENT["ID_NEWS"] . " 
               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
               INNER JOIN adm_ilines_content AS len ON len.el_id=e.el_id AND len.icont_var= 'title_en'
               INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var= 'date'
               INNER JOIN adm_ilines_content AS ft ON ft.el_id=e.el_id AND ft.icont_var= 'full_text'
               INNER JOIN adm_ilines_content AS li ON li.el_id=e.el_id AND li.icont_var= 'link'
               INNER JOIN adm_ilines_content AS ften ON ften.el_id=e.el_id AND ften.icont_var= 'full_text_en'
               INNER JOIN adm_ilines_content AS st ON st.el_id=e.el_id AND st.icont_var= 'status" . $lang_query . "'
               WHERE st.icont_text='1'
                 ORDER BY d.icont_text DESC"));
        if ($_GET[debug] == 1)
            var_dump($newsfeed_count);
        if (!empty($newsfeed)) {
            $pages = Pagination::createPages($newsfeed_count, $count_n, $page_n, 3);
            $pg = new Pages();
            if (@count($pages) > 1) {
                if ($_SESSION[lang] != "/en")
                    echo "<b>Страницы:</b>&nbsp;&nbsp; ";
                else
                    echo "<b>Pages:</b>&nbsp;&nbsp; ";

                foreach ($pages as $v) {
                    if (($v[0] == $_REQUEST['p']) || ((empty($_REQUEST["p"]) && ($v[0] == 1))))
                        echo "<b>" . $v[0] . "</b>&nbsp;&nbsp;";
                    else {
                        echo "<a href=\"" . $_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0])) . "\">" . $v[1] . "</a>&nbsp;&nbsp;";
                    }

                }
                echo "<br /><br />";
            }
            if (!empty($_TPL_REPLACMENT[TPL_NAME]))
                $tplname = $_TPL_REPLACMENT[TPL_NAME];
            else
                $tplname = 'text_newsfeed';
            $i = 1;
            ?>
            <div class="container-fluid">
                <div class="row">

                    <?php
                    foreach ($newsfeed as $k => $v) {
                        //	print_r($v);
                        $tpl = new Templater();
                        if (isset($v["date"])) {
                            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["date"], $matches);
                            $v["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                            $v["date"] = date("d.m.Y г.", $v["date"]);
                        }

                        $tpl->setValues($v);
                        $tpl->appendValues(array("ID" => $k));
                        $tpl->appendValues(array("NUMBER" => $i));
                        $tpl->appendValues(array("TITLE" => $v['title']));
                        $tpl->appendValues(array("TITLE_EN" => $v['title_en']));
                        $tpl->appendValues(array("FULL_TEXT" => $v['full_text']));
                        $tpl->appendValues(array("FULL_TEXT_EN" => $v['full_text_en']));
                        $tpl->appendValues(array("LINK" => $v['link']));
                        $tpl->appendValues(array("RET" => $_REQUEST[page_id]));

                        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl." . $tplname . ".html");
                        $i++;
                    }
                    ?>

                </div>
            </div>
            <?php
        }

        if ($_SESSION[lang] != '/en') {
            if (!empty($_TPL_REPLACMENT["CONTENT"]) && $_TPL_REPLACMENT["CONTENT"] != '<p>&nbsp;</p>') {
                echo @$_TPL_REPLACMENT["CONTENT"];
            } else {
                if ($_GET[debug] == 2) {
                    echo $_TPL_REPLACMENT["SUBMENU"];
                } else {
                    include($_TPL_REPLACMENT["SUBMENU"]);
                }
            }
        } else {
            if (!empty($_TPL_REPLACMENT["CONTENT_EN"]) && $_TPL_REPLACMENT["CONTENT_EN"] != '<p>&nbsp;</p>') {
                echo @$_TPL_REPLACMENT["CONTENT_EN"];
            } else {

                if ($_GET[debug] == 2) {
                    echo $_TPL_REPLACMENT["SUBMENU"];
                } else {
                    include($_TPL_REPLACMENT["SUBMENU"]);
                }

            }
        }
        if (!isset($_REQUEST[printmode])) {
            ?>
            <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
            <script src="https://yastatic.net/share2/share.js"></script>
            <div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
            <?
        }

    } else {
        echo "<b>Sorry! This page is not in the English version</b>";
    }
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
