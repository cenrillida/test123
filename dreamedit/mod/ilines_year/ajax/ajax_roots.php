<?php

    ini_set('memory_limit', '256M');
    include_once dirname(__FILE__)."/../../../_include.php";
    header("Content-type: application/json");
    $elmnts = array();

$ilines = new Ilines();
//    $pg = new Article();
    if(!empty($_GET[selected])) {
        if($_GET[type]=='l') {
            $parents = $ilines->getTypeByElementIdArray($_GET[selected]);
        }
    }
//    $rows = $pg->getChilds(0);


    // вытаскиваем типы инфолент
    $type_rows = $ilines->getTypes();


    $count=0;
    $parentsCount = $DB->select("SELECT itype_id AS ARRAY_KEY, COUNT(el_id) as cnt FROM adm_ilines_element GROUP BY itype_id");
    $elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=ilines_year&action=edit&id={ID}";
    foreach($type_rows as $k => $v) {
        $elmnts[$count][id] = $k;
        $elmnts[$count][text] = normJsonStr($v['itype_name']);
        if($parentsCount[$v[itype_id]][cnt]>0)
            $elmnts[$count][children] = true;
        $elmnts[$count][icon]="skin/classic/images/dTree/folder.gif";
        $elmnts[$count][a_attr][onclick]="location.href='".str_replace("{ID}",$k,$elementLink)."'";
        if($_GET[selected]==$k) {
            $elmnts[$count][state][opened]=true;
            $elmnts[$count][state][selected] = true;
        }
        $count++;
    }

    foreach($parents as $par_k => $par_v)
    {
        foreach($elmnts as $k => $v) {
            if($v[id]==$par_v['itype_id'])
                $elmnts[$k][state][opened] = true;
        }
    }






    echo json_encode($elmnts);

    function normJsonStr($str){
        $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
        return iconv('cp1251', 'utf-8', $str);
    }
?>