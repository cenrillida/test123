<?php
global $DB,$_CONFIG,$site_templater;


    $_REQUEST["year"] = (int)$DB->cleanuserinput($_REQUEST["year"]);

    $pg = new Pages();
    $news = new News();

    $pageContent = $pg->getContentByPageId($_REQUEST['page_id']);

    if ($_SESSION["lang"]!="/en")
    {
        $rebric_head="Рубрика: ";
        $param="";
        $ytext='Все';
        $suff="";
        $suff2="";
    }
    else
    {
        $rebric_head="Rubric: ";
        $param="/en";
        $ytext='All';
        $suff="_en";
        $suff2="&en";
    }

    ?>
    <?php
//////////////////
// Выборка по годам
    $where = 1;
    $req = "";
    $whereyear = "";
    $reqyear = "";
    $current_search_request = "";

    $whereyear .= " 1 ";
    $whereyear = str_ireplace("select", "", $whereyear);
    $whereyear = str_ireplace("union", "", $whereyear);
    $whereyear = str_ireplace("sleep", "", $whereyear);
    $whereyear = str_ireplace("drop", "", $whereyear);
    $whereyear = str_ireplace("insert", "", $whereyear);
    $whereyear = str_ireplace("update", "", $whereyear);

    $rubrics=$DB->select("SELECT c.el_id,c.icont_text AS rubric,cc.icont_text AS rubric_en,l.icont_text AS line,p.icont_text AS page 
                      FROM adm_directories_content AS c
					  INNER JOIN adm_directories_content AS l ON l.el_id=c.el_id AND l.icont_var='news_line'
					  INNER JOIN adm_directories_content AS r ON r.el_id=c.el_id AND r.icont_var='sort'
					  INNER JOIN adm_directories_content AS p ON p.el_id=c.el_id AND p.icont_var='page'
					  LEFT OUTER JOIN adm_directories_content AS cc ON cc.el_id=c.el_id AND cc.icont_var='text_en'
					  LEFT OUTER JOIN adm_directories_content AS nsr ON nsr.el_id=c.el_id AND nsr.icont_var='news_not_show'
					  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=3
					  WHERE c.icont_var='text' AND (nsr.icont_text IS NULL OR nsr.icont_text=0)
					  ORDER BY r.icont_text,c.icont_text");

    foreach ($rubrics AS $rubric) {
        if($_GET["rub"]==$rubric['el_id']) {
            if($_SESSION["lang"]!="/en") {
                $current_search_request .= "Рубрика: ".$rubric['rubric']."<br>";
            } else {
                $current_search_request .= "Rubric: ".$rubric['rubric_en']."<br>";
            }
            break;
        }
    }
    $linesArray = array();
    if(!empty($_TPL_REPLACMENT['FILTER_LINES'])) {
        $explodedLines = explode(",",$_TPL_REPLACMENT['FILTER_LINES']);
        foreach ($explodedLines as $explodedLine) {
            $linesArray[] = $explodedLine;
        }
    } else {
        $linesArray[] = '3';
    }

    $years = $DB->select("
SELECT DISTINCT SUBSTRING(ac.icont_text,1,4) AS `year`
FROM adm_ilines_content AS ac 
INNER JOIN adm_ilines_content AS st ON ac.el_id=st.el_id AND st.icont_var='status'
INNER JOIN adm_ilines_element AS ae ON ac.el_id=ae.el_id
WHERE ac.icont_var='date' AND st.icont_text=1 AND ae.itype_id IN (?a) AND " . $whereyear . " ORDER BY year DESC", $linesArray);

    $current_year_int = (int)$_GET["year"];

    if (!empty($current_year_int)) {
        if ($_SESSION["lang"] != "/en") {
            $current_search_request .= "Год " . $current_year_int . "<br>";
        } else {
            $current_search_request .= "Year " . $current_year_int . "<br>";
        }
    }
    if (strlen($_GET["alfa"]) >= 1) {
        $alfa_substr = substr($_GET["alfa"], 0, 2);
        if ($_GET["alfa"] == "eng") {
            $alfa_substr = "A..Z";
        }
        if (!empty($alfa_substr)) {
            if ($_SESSION["lang"] != "/en") {
                $current_search_request .= "Авторы: \"" . $alfa_substr . "\"<br>";
            } else {
                $current_search_request .= "Authors: \"" . $alfa_substr . "\"<br>";
            }

        }
    }

    $authors = $news->getAuthors();

    if(isset($_REQUEST['author']) && isset($authors[$_REQUEST['author']])) {
        if ($_SESSION["lang"] != "/en") {
            $current_search_request .= "Автор: \"{$authors[$_REQUEST['author']]['fio']}\"<br>";
        } else {
            $current_search_request .= "Author: \"{$authors[$_REQUEST['author']]['fio_en']}\"<br>";
        }
    }


    ?>

    <div class="col-12 col-md-8 col-xl-12 pb-3">
        <div class="shadow border bg-white p-3 h-100 position-relative">
            <div class="row">
                <div class="col-12<?php if (!empty($current_search_request)) echo ' d-none'; ?>">
                    <div class="text-center">
                        <a class="btn btn-lg imemo-button text-uppercase imemo-publlistfilters-button"
                           id="showPublListFilters" href="#"
                           role="button"><?php if ($_SESSION["lang"] != "/en") echo 'Показать фильтры'; else echo 'Show filters'; ?></a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="publlist-filters-element<?php if (!empty($current_search_request)) echo ' d-block'; ?>">


                        <?php

                        if (!empty($current_search_request)) {
                            //$current_search_request = substr($current_search_request, 0, -2);

                            if ($_SESSION["lang"] != "/en") {
                                echo "<p><b>ВЫБРАНО:</b></p>";
                                echo "<p><b>$current_search_request</b></p>";
                                echo "<p><a href='" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "'>Сбросить</a></p>";
                            } else {
                                echo "<p><b>SELECTED:</b></p>";
                                echo "<p><b>$current_search_request</b></p>";
                                echo "<p><a href='" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "'>Reset</a></p>";
                            }
                            echo "<hr>";
                        }


// Сколько публикаций выводить на одном листе

                        if(isset($_TPL_REPLACMENT['COUNT'])) {
                            $nn_page = $_TPL_REPLACMENT['COUNT'];
                        } else {
                            $nn_page = 10;
                        }

                            if (empty($nn_page)) $nn_page = 40;

                            $txt = "";
                            $search_string = "";
                            $request_string = "";

                            if (isset($_REQUEST["en"])) $request_string = "&en";
                            else $request_string = "&rus";
                            $pp = new Publications();


                            $land_txt = "";
                            if (!empty($_REQUEST['land']))
                                $land_txt = "&land=" . $_REQUEST['land'];

                            $vid_txt = "";
                            if (!empty($_REQUEST['vid']))
                                $vid_txt = "&vid=" . $_REQUEST['vid'];

/////////////////  RUS //////////////////////

                            echo "<div class='row mt-3'>";
                            if(isset($_TPL_REPLACMENT['FILTER_RUBRICATOR']) && $_TPL_REPLACMENT['FILTER_RUBRICATOR']==1) {
                                echo "<div class='col-12'>";
                                if ($_SESSION["lang"] != "/en") {
                                    echo "<p style='text-transform: uppercase;'><b>Рубрикатор новостей:</b></p>";
                                } else {
                                    echo "<p style='text-transform: uppercase;'><b>News rubricator:</b></p>";
                                }
                                if ($_SESSION["lang"]=='/en')
                                {
                                    $txtall='All';
                                }
                                else
                                {
                                    $txtall='Все новости';
                                }
                                echo "<div><a href=" . $_SESSION["lang"] . "/index.php?page_id=498>" . $txtall . "</a></div>";
                                foreach($rubrics as $r) {
                                    if ($_SESSION["lang"] != '/en') {
                                        $rubric = $r["rubric"];
                                    } else {
                                        $rubric = $r["rubric_en"];
                                    }

                                    if ($r['el_id'] == 440 || $r['el_id'] == 439) {
                                        echo "<div><a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $r["page"] . ">" . $rubric . "</a></div>";
                                    } else {
                                        echo "<div><a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $r["page"] . "&" . http_build_query(array_merge($_GET, array('rub' => $r["el_id"], 'p' => 1))) . ">" . $rubric . "</a></div>";
                                    }
                                }


                                echo "<hr>";
                                echo "</div>";

                            }

                            if(isset($_TPL_REPLACMENT['FILTER_YEARS']) && $_TPL_REPLACMENT['FILTER_YEARS']==1) {
                                echo "<div class='col-12'>";
                                if ($_SESSION["lang"] != "/en") {
                                    echo "<p style='text-transform: uppercase;'><b>Год:</b></p>";
                                } else {
                                    echo "<p style='text-transform: uppercase;'><b>Year:</b></p>";
                                }
                                if (empty($_REQUEST["year"])) {
                                    echo "<b>" . $ytext . "</b> | ";

                                } else echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => "", 'p' => 1))) . ">" . $ytext . "</a> | ";
                                $yold = "20";
                                $iyear = 0;
                                foreach ($years as $yy) {
                                    if ($_REQUEST["year"] == $yy["year"])
                                        echo "<b>" . $yy["year"] . "</b> | ";
                                    else echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => $yy["year"], 'p' => 1))) . ">" . $yy["year"] . "</a> | ";
                                    $iyear++;

                                }
                                echo "<hr>";
                                echo "</div>";
                            }
///// Алфавит
                            $style = "bold";
                            if(isset($_TPL_REPLACMENT['FILTER_AUTHOR']) && $_TPL_REPLACMENT['FILTER_AUTHOR']==1) {
                                echo "<div class='col-12'>";


                                if ($_SESSION["lang"] != "/en") {
                                    echo "<p><b>АВТОРЫ:</b></p>";
                                } else {
                                    echo "<p><b>AUTHORS:</b></p>";
                                }

                                ?>
                                <div class="ui-widget">
                                    <select class="form-control" id="combobox" style="display: none">
                                        <option value></option>
                                        <?php
                                        $selected = "";
                                        foreach ($authors as $author) {
                                            $selected = "";
                                            if($_REQUEST['author']==$author['id']) {
                                                $selected = "selected";
                                            }
                                            if ($_SESSION["lang"] != "/en") {
                                                $fio = $author['fio'];
                                            } else {
                                                $fio = $author['fio_en'];
                                            }
                                            echo "<option value=\"{$author['id']}\" {$selected}>{$fio}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php

                                if (!empty($_REQUEST["search"])) $value = $_REQUEST["search"]; else $value = $_REQUEST["namef"];

                                echo "</div>";
                                ?>
                                <script>
                                    jQuery( document ).ready(function() {
                                        $( "#combobox" ).combobox();
                                        $( "#toggle" ).on( "click", function() {
                                            $( "#combobox" ).toggle();
                                        });
                                        $( ".custom-combobox-input" ).on( "autocompleteselect", function( event, ui ) {
                                            document.location.href = "<?=$_SESSION['lang']?>/index.php?page_id=<?=$_REQUEST['page_id']?>&author="+ui.item.option.value;
                                        } );
                                    });
                                </script>
                                <?php
                            }
                            echo "</div><hr /><br />";


                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>