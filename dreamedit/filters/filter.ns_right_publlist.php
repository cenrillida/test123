<?php
global $DB,$_CONFIG,$site_templater;

if (isset($_REQUEST["printmode"])) $_REQUEST["printmode"]=$DB->cleanuserinput($_REQUEST["printmode"]);
if (isset($_REQUEST["last"])) $_REQUEST["last"]=$DB->cleanuserinput($_REQUEST["last"]);
$_REQUEST["vid"]=(int)$DB->cleanuserinput($_REQUEST["vid"]);
$_REQUEST["land"]=(int)$DB->cleanuserinput($_REQUEST["land"]);
$_REQUEST["type"]=(int)$DB->cleanuserinput($_REQUEST["type"]);
$_REQUEST["page_id"]=(int)$DB->cleanuserinput($_REQUEST["page_id"]);
if (isset($_REQUEST["rub2"]))$_REQUEST["rub2"]=(int)$DB->cleanuserinput($_REQUEST["rub2"]);
$_REQUEST["fio"]=$DB->cleanuserinput($_REQUEST["fio"]);
$_REQUEST["year"]=(int)$DB->cleanuserinput($_REQUEST["year"]);
$_REQUEST["alfa"]=$DB->cleanuserinput($_REQUEST["alfa"]);
$_REQUEST["namef"]=$DB->cleanuserinput($_REQUEST["namef"]);
$_REQUEST["rubric"]=$DB->cleanuserinput($_REQUEST["rubric"]);
if (isset($_REQUEST["retro"]))$_REQUEST["retro"]=$DB->cleanuserinput($_REQUEST["retro"]);
if (isset($_REQUEST["actual"]))$_REQUEST["actual"]=$DB->cleanuserinput($_REQUEST["actual"]);

$pp=new Publications();

if ($_SESSION["lang"]!="/en")
{
    $ytext='Все';
    $yTitleText='Год';
}
else
{
    $ytext='All';
    $yTitleText='Year';
}

?>
<?php
//////////////////
// Выборка по годам

$whereyear="";
if (!empty($_REQUEST["type"]))
{
    $whereyear.="tip=".$_REQUEST["type"]." AND ";
}
if (!empty($_REQUEST["vid"]))
{
    $whereyear.="vid=".$_REQUEST["vid"]." AND ";
}
if (!empty($_REQUEST["land"]))
{
    $whereyear.="land=".$_REQUEST["land"]." AND ";
}

$whereyear.=" 1 ";
$whereyear=str_ireplace("select","",$whereyear);
$whereyear=str_ireplace("union","",$whereyear);
$whereyear=str_ireplace("sleep","",$whereyear);
$whereyear=str_ireplace("drop","",$whereyear);
$whereyear=str_ireplace("insert","",$whereyear);
$whereyear=str_ireplace("update","",$whereyear);
$years=$DB->select("SELECT DISTINCT year FROM publ WHERE status=1 AND ".$whereyear." ORDER BY year DESC");
$years = array_map(function ($el) { return $el['year'];}, $years);

if((empty($_REQUEST['type']) || $_REQUEST['type']==442) && (empty($_REQUEST['vid']) || $_REQUEST['vid']==428) && empty($_REQUEST['land'])) {
    $yearsArticle = $DB->select("SELECT DISTINCT year FROM adm_article WHERE page_status=1 AND page_template='jarticle' ORDER BY year DESC");
    $yearsArticle = array_map(function ($el) { return $el['year'];}, $yearsArticle);
    $years = array_unique(array_merge($years,$yearsArticle));
    arsort($years);
}

$land_sort = " ORDER BY acr.icont_text";
if($_SESSION["lang"]=="/en")
    $land_sort = " ORDER BY ace.icont_text";

$lands = $DB->select("SELECT ae.el_id AS 'id', acr.icont_text AS 'land', ace.icont_text AS 'land_en' FROM `adm_directories_element` AS ae
INNER JOIN adm_directories_content AS acr ON acr.el_id=ae.el_id AND acr.icont_var = 'text'
INNER JOIN adm_directories_content AS ace ON ace.el_id=ae.el_id AND ace.icont_var = 'value'
WHERE ae.itype_id = 22".$land_sort);

$vid0 = $DB->select("SELECT ae.el_id AS 'id', acr.icont_text AS 'text', ace.icont_text AS 'text_en' FROM `adm_directories_element` AS ae
INNER JOIN adm_directories_content AS acr ON acr.el_id=ae.el_id AND acr.icont_var = 'text'
INNER JOIN adm_directories_content AS ace ON ace.el_id=ae.el_id AND ace.icont_var = 'text_en'
WHERE ae.itype_id = 19");

$type0 = $DB->select("SELECT ae.el_id AS 'id', acr.icont_text AS 'text', ace.icont_text AS 'text_en' FROM `adm_directories_element` AS ae
INNER JOIN adm_directories_content AS acr ON acr.el_id=ae.el_id AND acr.icont_var = 'text'
INNER JOIN adm_directories_content AS ace ON ace.el_id=ae.el_id AND ace.icont_var = 'text_en'
WHERE ae.itype_id = 21");

$rubrics = $DB->select("SELECT ae.el_id AS 'id', acr.icont_text AS 'text', ace.icont_text AS 'text_en' FROM `adm_directories_element` AS ae
INNER JOIN adm_directories_content AS acr ON acr.el_id=ae.el_id AND acr.icont_var = 'text'
INNER JOIN adm_directories_content AS ace ON ace.el_id=ae.el_id AND ace.icont_var = 'value'
WHERE ae.itype_id = 23 ORDER BY acr.icont_text");

$fieldsOfKnowledge = $DB->select("SELECT ae.el_id AS 'id', acr.icont_text AS 'text', ace.icont_text AS 'text_en' FROM `adm_directories_element` AS ae
INNER JOIN adm_directories_content AS acr ON acr.el_id=ae.el_id AND acr.icont_var = 'text'
INNER JOIN adm_directories_content AS ace ON ace.el_id=ae.el_id AND ace.icont_var = 'text_en'
WHERE ae.itype_id = 28 ORDER BY acr.icont_text");

$current_search_request = "";

if($_GET["sort"]=="desc") {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Сортировка: По убыванию<br>";
    } else {
        $current_search_request .= "Sort: Descending<br>";
    }
}

if($_GET["sort_field"]=="name") {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Сортировка: По имени<br>";
    } else {
        $current_search_request .= "Sort: By name<br>";
    }
}

if($_GET["sort_field"]=="year") {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Сортировка: По году<br>";
    } else {
        $current_search_request .= "Sort: By year<br>";
    }
}

if($_GET["sort_field"]=="date") {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Сортировка: По дате публикации<br>";
    } else {
        $current_search_request .= "Sort: By date<br>";
    }
}

foreach ($fieldsOfKnowledge AS $fieldOfKnowledge) {
    if($_GET["field_of_knowledge"]==$fieldOfKnowledge['id']) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Область знаний: ".$fieldOfKnowledge['text']."<br>";
        } else {
            $current_search_request .= "Field of knowledge: ".$fieldOfKnowledge['text_en']."<br>";
        }
        break;
    }
}

foreach ($rubrics AS $rubric) {
    if($_GET["rubric"]==$rubric['id']) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Рубрика: ".$rubric['text']."<br>";
        } else {
            $current_search_request .= "Rubric: ".$rubric['text_en']."<br>";
        }
        break;
    }
}

foreach ($type0 AS $type) {
    if($_GET["type"]==$type['id']) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Тип: ".$type['text']."<br>";
        } else {
            $current_search_request .= "Publication Type: ".$type['text_en']."<br>";
        }
        break;
    }
}

foreach ($vid0 AS $vid) {
    if($_GET["vid"]==$vid['id']) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Тип: ".$vid['text']."<br>";
        } else {
            $current_search_request .= "Publication Type: ".$vid['text_en']."<br>";
        }
        break;
    }
}

$tidId = (int)$_GET['tid'];

$pg = new Pages();

if(!empty($tidId)) {
    $tidContent = $pg->getContentByPageId($tidId);
    if(!empty($tidContent)) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Публикации сотрудников " . $tidContent['TITLE_R'] . "<br>";
        } else {
            $current_search_request .= $tidContent['TITLE_EN']." publications <br>";
        }
    }
}

$current_year_int = (int)$_GET["year"];

if(!empty($current_year_int)) {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Год " . $current_year_int . "<br>";
    } else {
        $current_search_request .= "Year " . $current_year_int . "<br>";
    }
}
if(strlen($_GET["alfa"]) >= 1) {
    $alfa_substr = substr($_GET["alfa"], 0, 2);
    if($_GET["alfa"]=="eng") {
        $alfa_substr = "A..Z";
    }
    if (!empty($alfa_substr)) {
        if($_SESSION["lang"]!="/en") {
            $current_search_request .= "Авторы: \"" . $alfa_substr . "\"<br>";
        } else {
            $current_search_request .= "Authors: \"" . $alfa_substr . "\"<br>";
        }

    }
}

$authors = $pp->getAuthorsList();

if(isset($_REQUEST['fio']) && isset($authors[$_REQUEST['fio']])) {
    if ($_SESSION["lang"] != "/en") {
        $current_search_request .= "Автор: \"{$authors[$_REQUEST['fio']]['fio']}\"<br>";
    } else {
        $current_search_request .= "Author: \"{$authors[$_REQUEST['fio']]['fio_en']}\"<br>";
    }
}



if (!empty($_GET["key"])) {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Ключевое слово: " . htmlspecialchars(str_replace("_"," ",$_GET["key"]),ENT_COMPAT | ENT_HTML5, "cp1251") . "<br>";
    } else {
        $current_search_request .= "Keyword: " . htmlspecialchars(str_replace("_"," ",$_GET["key"]),ENT_COMPAT | ENT_HTML5, "cp1251") . "<br>";
    }

}
if (!empty($_GET["namef"])) {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Название начинается с: " . htmlspecialchars($_GET["namef"],ENT_COMPAT | ENT_HTML5, "cp1251") . "<br>";
    } else {
        $current_search_request .= "Name starts with: " . htmlspecialchars($_GET["namef"],ENT_COMPAT | ENT_HTML5, "cp1251") . "<br>";
    }

}

$cur_lands = array_filter($lands, function($v) {
    return $v["id"] == $_GET['land'];
});
foreach ($cur_lands as $cur_land) {
    if($_SESSION["lang"]!="/en") {
        $current_search_request .= "Страна: ".$cur_land["land"]."<br>";
    } else {
        $current_search_request .= "Country: ".$cur_land["land_en"]."<br>";
    }

}
?>

    <div class="col-12 col-md-8 col-xl-12 pb-3">
        <div class="shadow border bg-white p-3 h-100 position-relative">
            <div class="row">
                <div class="col-12<?php if(!empty($current_search_request)) echo ' d-none'; ?>">
                    <div class="text-center">
                        <a class="btn btn-lg imemo-button text-uppercase imemo-publlistfilters-button" id="showPublListFilters" href="#" role="button"><?php if($_SESSION["lang"]!="/en") echo 'Показать фильтры'; else echo 'Show filters';?></a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="publlist-filters-element<?php if(!empty($current_search_request)) echo ' d-block'; ?>">



<?php

if(!empty($current_search_request)) {
    //$current_search_request = substr($current_search_request, 0, -2);

    if($_SESSION["lang"]!="/en") {
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

if(!isset($_REQUEST["last"])) {
    if ($_SESSION["lang"] != "/en") {
        echo "<p>";
        echo "<a href=/index.php?page_id=" . $_REQUEST["page_id"] .
            " title='Все публикации'>
   Все публикации</a>";
        //echo " | <a href=/index.php?page_id=521 >Поиск публикаций</a>	";

            echo " | <a href=" . $_SESSION["lang"] . "/index.php?page_id=1499";
            echo "&last title='Последние поступления'>
   Последние поступления</a>";
        
        echo "</p>";
    } else {
        echo "<p>";
        echo "<a href=/en/index.php?page_id=" . $_REQUEST["page_id"] .
            " title='All publications'>
   All publications</a>";
        echo " | <a href=/en/index.php?page_id=521 >Search</a>	";

//echo "<br />";


            echo "| <a href=" . $_SESSION["lang"] . "/index.php?page_id=1499";
            //  if (isset($_REQUEST["en"])) echo "?en"; else echo "?rus";
            echo "&last title='Latest Publications'>
   Latest Publications</a>";
        
        echo "</p>";
    }

    if(!isset($value)) {
        $value = "";
    }

    if ($_SESSION["lang"] != "/en") {
        echo "<hr><form class='mt-3' name=publ method=get action=" . $_SESSION["lang"] . "/index.php onSubmit=''>";
        echo "<input style='display: none' type='hidden' name='page_id' value='732'>
      Название начинается с: <input class='form-control' name='namef' type=text size='69' value=" . $value . "></form>";
        echo "<hr>";
        //echo "<p style='text-transform: uppercase;'><b>Год:</b></p>";

    } else {
        echo "<hr><form class='mt-3' name=publ method=get action=" . $_SESSION["lang"] . "/index.php onSubmit=''>";
        echo "<input style='display: none' type='hidden' name='page_id' value='732'>
      Name starts with: <input class='form-control' name='namef' type=text size='69' value=" . $value . "></form>";
        echo "<hr>";
        //echo "<p style='text-transform: uppercase;'><b>Год:</b></p>";

    }

//    if (empty($_REQUEST["year"])) {
//        echo "<b>" . $ytext . "</b> | ";
//
//    } else echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => "", 'page' => 1))) . ">" . $ytext . "</a> | ";
//    $yold = "20";
//    $iyear = 0;
//    foreach ($years as $yy) {
//        if ($_REQUEST["year"] == $yy)
//            echo "<b>" . $yy . "</b> | ";
//        else echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => $yy, 'page' => 1))) . ">" . $yy . "</a> | ";
//        $iyear++;
//
//    }

    echo "<div class='row'><div class='col-12'><p style='text-transform: uppercase;'><b>".$yTitleText.":</b></p>";
    echo "<select class='form-control' onchange=\"location = this.value;\">";
    echo "<option value='" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => '', 'page' => 1))) . "'" . ">" . $ytext . "</option>";
    foreach ($years as $year) {
        $selected = "";
        if ($_GET["year"] == $year)
            $selected = " selected";
        echo "<option value='" . $_SESSION["lang"] . "/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('year' => $year, 'page' => 1))) . "'" . $selected . ">" . $year . "</option>";

    }
    echo "</select>";

    echo "</div></div>";

// Сколько публикаций выводить на одном листе

    if(isset($_TPL_REPLACMENT)) {
        $nn_page=$_TPL_REPLACMENT['COUNT'];
    }
if (empty($nn_page)) $nn_page=40;

$txt="";
$search_string="";
$request_string="";

if (isset($_REQUEST["en"])) $request_string="&en";
else $request_string="&rus";



$land_txt = "";
if(!empty($_REQUEST['land']))
    $land_txt = "&land=".$_REQUEST['land'];

$vid_txt = "";
if(!empty($_REQUEST['vid']))
    $vid_txt = "&vid=".$_REQUEST['vid'];

/////////////////  RUS //////////////////////

        echo "<div class='row mt-3'>";
    echo "<div class='col-12'>";
    echo "<hr>";
    if($_SESSION["lang"]!="/en") {
        echo "<p style='text-transform: uppercase;'><b>Тип публикации:</b></p>";
    } else {
        echo "<p style='text-transform: uppercase;'><b>Publication Type:</b></p>";
    }
    echo "<p>";



    foreach($type0 as $i=>$type)
    {
        if($_SESSION["lang"]!="/en") {
            echo "<a href=/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('type' => $type['id'], 'page' => 1))) . $land_txt . ">" . $type['text'] . "</a> | ";
        } else {
            echo "<a href=/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('type' => $type['id'], 'page' => 1))) . $land_txt . ">" . $type['text_en'] . "</a> | ";
        }
    }

    echo "</p></div>";
//    if($_SESSION["lang"]!="/en") {
//        echo "<div class='col-12'><hr><p style='text-transform: uppercase;'><b>Вид публикации:</b></p>";
//    } else {
//        echo "<div class='col-12'><hr><p style='text-transform: uppercase;'><b>Publication Type:</b></p>";
//    }
//        echo "<p>";
////if ($_REQUEST["vid"]!='428')
////{
//
//
//
//    foreach($vid0 as $i=>$vid)
//    {
//        if($_SESSION["lang"]!="/en") {
//            echo "<a href=/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => $vid['id'], 'page' => 1))) . $land_txt . ">" . $vid['text'] . "</a> | ";
//        } else {
//            echo "<a href=/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => $vid['id'], 'page' => 1))) . $land_txt . ">" . $vid['text_en'] . "</a> | ";
//        }
//    }
//
//        echo "</p></div>";


        echo "</div>";

        if($_SESSION["lang"]!="/en") {
            echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Вид публикации:</b></p>";
            echo "<select class='form-control' onchange=\"location = this.value;\">";
            echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => '', 'page' => 1))) . "'" . ">Все</option>";
        } else {
            echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Publication Type:</b></p>";
            echo "<select class='form-control' onchange=\"location = this.value;\">";
            echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => '', 'page' => 1))) . "'" . ">All</option>";
        }
        foreach ($vid0 as $vid) {
            $selected = "";
            if ($_GET["vid"] == $vid['id'])
                $selected = " selected";

            if($_SESSION["lang"]!="/en") {
                echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => $vid["id"], 'page' => 1))) . "'" . $selected . ">" . $vid['text'] . "</option>";
            } else {
                echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('vid' => $vid["id"], 'page' => 1))) . "'" . $selected . ">" . $vid['text_en'] . "</option>";
            }

        }
        echo "</select>";

        echo "</div></div>";

            ?>
            <style>
                .ui-autocomplete {
                    font-size: 1rem;
                    border: 1px solid #7fbdff !important;
                    max-width: 75%;
                }
                .ui-autocomplete .ui-state-active:hover, .ui-autocomplete .ui-state-active:active, .ui-autocomplete .ui-state-active {
                    font-size: 1rem;
                    border: 1px solid #012b4b;
                    background: #012b4b;
                }
            </style>
            <script>
                $( function() {
                    $( "#keyword_search" ).autocomplete({
                        source: "/index.php?page_id=1562&ajax_get_elements_mode=keywords<?php if($_SESSION['lang']=="/en") echo "&lang=en";?>",
                        appendTo: ".right-column-stick",
                        minLength: 2,
                        select: function( event, ui ) {
                            var label = ui.item.label.replace(" ","_");
                            document.location.href = "<?=$_SESSION['lang']?>/index.php?page_id=<?=$_REQUEST['page_id']?>&key="+label;
                        }
                    });
                    $('#keyword_search').keypress(function (event) {
                        if (event.which == 13) {
                            keyword_choosen = $('#keyword_search').val();
                            if(keyword_choosen!=='')
                                document.location.href = "<?=$_SESSION['lang']?>/index.php?page_id=<?=$_REQUEST['page_id']?>&key="+keyword_choosen;
                            // else
                            //     $('#search_error').show();
                        }
                    });
                } );
            </script>
                        <?php
            if($_SESSION["lang"]!="/en") {
                ?>

                    <div class='row'>
                        <div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Поиск по ключевому слову:</b></p>
                            <div>
                                <input class="form-control" id="keyword_search">
                            </div>
                        </div>
                    </div>

                        <?php
            } else {
                        ?>
            <div class='row'>
                <div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Find by keyword:</b></p>
                    <div>
                        <input class="form-control" id="keyword_search">
                    </div>
                </div>
            </div>

            <?php
            }

            echo "<div class='row'><div class='col-12 mb-3'>";

            echo "<hr>";

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
                        if($_REQUEST['fio']==$author['id']) {
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
                <script>
                    jQuery( document ).ready(function() {
                        $( "#combobox" ).combobox();
                        $( "#toggle" ).on( "click", function() {
                            $( "#combobox" ).toggle();
                        });
                        $( ".custom-combobox-input" ).on( "autocompleteselect", function( event, ui ) {
                            document.location.href = "<?=$_SESSION['lang']?>/index.php?page_id=<?=$_REQUEST['page_id']?>&fio="+ui.item.option.value;
                        } );
                    });
                </script>
            </div>
            <?php


            echo "</div></div>";


                echo "<div class='row'>";

                $selected = "";

                if ($_SESSION["lang"] != "/en") {

                    echo "<div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Сортировка:</b></p>";
                    echo "<select class='form-control' onchange=\"location = this.value;\">";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "", 'page' => 1))) . "'" . "></option>";
                    if ($_GET["sort_field"] == "name")
                        $selected = " selected";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "name", 'page' => 1))) . "'" . $selected . ">По имени</option>";
                    $selected = "";
                    if ($_GET["sort_field"] == "date")
                        $selected = " selected";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "date", 'page' => 1))) . "'" . $selected . ">По дате публикации</option>";
                    $selected = "";
                    if ($_GET["sort_field"] == "year")
                        $selected = " selected";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "year", 'page' => 1))) . "'" . $selected . ">По году</option>";
                    $selected = "";
                } else {
                    echo "<div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Sort:</b></p>";
                    echo "<select class='form-control' onchange=\"location = this.value;\">";
                    echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "", 'page' => 1))) . "'" . "></option>";
                    if ($_GET["sort_field"] == "name")
                        $selected = " selected";
                    echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "name", 'page' => 1))) . "'" . $selected . ">By name</option>";
                    $selected = "";
                    if ($_GET["sort_field"] == "date")
                        $selected = " selected";
                    echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "date", 'page' => 1))) . "'" . $selected . ">By date</option>";
                    $selected = "";
                    if ($_GET["sort_field"] == "year")
                        $selected = " selected";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort_field' => "year", 'page' => 1))) . "'" . $selected . ">By year</option>";
                    $selected = "";
                }
                echo "</select>";
                echo "<br>";
                echo "</div>";

                $selected = "";
                if ($_GET["sort"] == "desc")
                    $selected = " selected";

                if ($_SESSION["lang"] != "/en") {

                    echo "<div class='col-12 mb-3'>";
                    echo "<select class='form-control' onchange=\"location = this.value;\">";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort' => "", 'page' => 1))) . "'" . ">По возрастанию</option>";
                    echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort' => "desc", 'page' => 1))) . "'" . $selected . ">По убыванию</option>";
                } else {
                    echo "<div class='col-12 mb-3'>";
                    echo "<select class='form-control' onchange=\"location = this.value;\">";
                    echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort' => "", 'page' => 1))) . "'" . ">Ascending</option>";
                    echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('sort' => "desc", 'page' => 1))) . "'" . $selected . ">Descending</option>";
                }
                echo "</select>";
                echo "<br>";
                echo "</div></div>";


        if($_SESSION["lang"]!="/en") {
            echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Страны и регионы:</b></p>";
            echo "<select class='form-control' onchange=\"location = this.value;\">";
            echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('land' => '', 'page' => 1))) . "'" . ">Все</option>";
        } else {
            echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Countries and regions:</b></p>";
            echo "<select class='form-control' onchange=\"location = this.value;\">";
            echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('land' => '', 'page' => 1))) . "'" . ">All</option>";
        }
        foreach ($lands as $land) {
            $selected = "";
            if ($_GET["land"] == $land["id"])
                $selected = " selected";

            if($_SESSION["lang"]!="/en") {
                echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('land' => $land["id"], 'page' => 1))) . "'" . $selected . ">" . $land["land"] . "</option>";
            } else {
                echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('land' => $land["id"], 'page' => 1))) . "'" . $selected . ">" . $land["land_en"] . "</option>";
            }

        }
        echo "</select>";
        echo "<br>";

        echo "</div></div>";

    if($_SESSION["lang"]!="/en") {
        echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Рубрики:</b></p>";
        echo "<select class='form-control' onchange=\"location = this.value;\">";
        echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('rubric' => '', 'page' => 1))) . "'" . ">Все</option>";
    } else {
        echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Rubrics:</b></p>";
        echo "<select class='form-control' onchange=\"location = this.value;\">";
        echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('rubric' => '', 'page' => 1))) . "'" . ">All</option>";
    }
    foreach ($rubrics as $rubric) {
        $selected = "";
        if ($_GET["rubric"] == $rubric["id"])
            $selected = " selected";

        if($_SESSION["lang"]!="/en") {
            echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('rubric' => $rubric["id"], 'page' => 1))) . "'" . $selected . ">" . $rubric["text"] . "</option>";
        } else {
            echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('rubric' => $rubric["id"], 'page' => 1))) . "'" . $selected . ">" . $rubric["text_en"] . "</option>";
        }

    }
    echo "</select>";
    echo "<br>";

    echo "</div></div>";

    if($_SESSION["lang"]!="/en") {
        echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Области знаний:</b></p>";
        echo "<select class='form-control' onchange=\"location = this.value;\">";
        echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('field_of_knowledge' => '', 'page' => 1))) . "'" . ">Все</option>";
    } else {
        echo "<div class='row'><div class='col-12 mb-3'><hr><p style='text-transform: uppercase;'><b>Fields of knowledge:</b></p>";
        echo "<select class='form-control' onchange=\"location = this.value;\">";
        echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('field_of_knowledge' => '', 'page' => 1))) . "'" . ">All</option>";
    }
    foreach ($fieldsOfKnowledge as $fieldOfKnowledge) {
        $selected = "";
        if ($_GET["field_of_knowledge"] == $fieldOfKnowledge["id"])
            $selected = " selected";

        if($_SESSION["lang"]!="/en") {
            echo "<option value='/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('field_of_knowledge' => $fieldOfKnowledge["id"], 'page' => 1))) . "'" . $selected . ">" . $fieldOfKnowledge["text"] . "</option>";
        } else {
            echo "<option value='/en/index.php?page_id=" . $_REQUEST["page_id"] . "&" . http_build_query(array_merge($_GET, array('field_of_knowledge' => $fieldOfKnowledge["id"], 'page' => 1))) . "'" . $selected . ">" . $fieldOfKnowledge["text_en"] . "</option>";
        }

    }
    echo "</select>";
    echo "<br>";

///// Алфавит
        $style = "bold";
        echo "</div><div class='col-12'>";


        if (!empty($_REQUEST["search"])) $value = $_REQUEST["search"]; else $value = $_REQUEST["namef"];

        echo "</div></div>";
        echo "<hr /><br />";

}
/////////////////// EN ///////////////////////
else
{

    echo "<br />";

}

?>
                    </div>
                </div>
            </div>
        </div>
    </div>
