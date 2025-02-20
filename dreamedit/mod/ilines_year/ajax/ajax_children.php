<?php


    ini_set('memory_limit', '256M');
    include_once dirname(__FILE__) . "/../../../_include.php";
    header("Content-type: application/json");
    $elmnts = array();
//    $pg = new Article();
//    if(!empty($_GET[selected]))
//        $parents = $pg->getParents($_GET[selected]);
//    $rows = $pg->getChilds($_GET[id]);

    $ilines = new Ilines();


// вытаскиваем типы инфолент
    $type_row = $ilines->getTypeByIdArray($_GET[id]);

// вытаскиваем все элементы инфолент
    $el_rows = array();
    foreach($type_row as $k => $v)
        $el_rows = $el_rows + $ilines->getElementsByType(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"], "", 200);


// присоедин€ем контент и получаем готовый массив дл€ построени€ дерева
    $rows = Dreamedit::createTreeArrayFromIlines($type_row, $ilines->appendContent($el_rows));


    //var_dump($rows);


    $count = 0;
    //$parentsCount = $DB->select("SELECT page_parent AS ARRAY_KEY, COUNT(page_id) as cnt FROM adm_article GROUP BY page_parent");
    $elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=ilines_year&type=l&action=edit&id={ID}";
    $idsCount = array();
    $countJnumber = 1;

    foreach ($rows as $k => $v) {
        if($v['pid']=="t0") {

            continue;
        }
        $elmnts[$count][id] = "l".$v['cleanId'];
        $elmnts[$count][text] = normJsonStr(preg_replace('/<.*>/iUs', "", $v['title']));
        $elmnts[$count][icon] = "skin/classic/images/dTree/".$v['icon'];
        $elmnts[$count][a_attr][onclick] = "location.href='" . str_replace("{ID}", $v['cleanId'], $elementLink) . "'";
        if ($_GET[selected] == $v['cleanId']) {
            $elmnts[$count][state][opened] = true;
            $elmnts[$count][state][selected] = true;
        }
        $idsCount[$v['cleanId']] = $count;
        $count++;
        $countJnumber++;
    }
//    foreach($parents as $par_k => $par_v)
//    {
//        foreach($elmnts as $k => $v) {
//            if($v[id]==$par_k)
//                $elmnts[$k][state][opened] = true;
//        }
//    }
    echo json_encode($elmnts);

    function normJsonStr($str)
    {
        $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
        return iconv('cp1251', 'utf-8', $str);
    }

?>