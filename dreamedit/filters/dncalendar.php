<?php
    // бере?конфиг систем?если конфиг не найден - выходи?
    $_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/../_config.ini", true);
    if(empty($_CONFIG["global"]))
        die("Config is not found!");
    // создае?дополнительную переменную admin_path - полный путь до директории ?системой администрирования
    $_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
    $_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];


    // подключаем заголовк?страни?
    include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/headers.php";
    // подключаем файл соединен? ?базо?
    include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/connect.php";
    // подключаем файл соединен? ?базо?
    include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";
    include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Dreamedit.php";

    header("Content-type: application/json");
    //$elmnts = array();

    include_once dirname(__FILE__)."/../includes/class.Events.php";

    if($_GET[lang]=="ru") {
        $ilines_spisok = "1,4,5,6"; //"2,17,14,3,16";]
    } else {
        $ilines_spisok = "1,4"; //"2,17,14,3,16";]
    }
    $il0=explode(",",trim($ilines_spisok));
    $str="(";
    foreach($il0 as $il)
    {
        $str.=" ie.itype_id=".$il." OR ";
    }
    $str=substr($str,0,-4).")";

    $month = (int)$_GET[month];
    if(strlen($month)==1) {
        $month = "0".$month;
    }
    $day = 31;
    for ($i=0; $i<5; $i++) {
        if(Dreamedit::validateDate((int)$_GET[year] . "." . $month . "." . $day)) {
            break;
        }
        $day--;
    }

    $ilines = new Events();
    if($_GET[lang]=="ru") {
        $days = $ilines->getLimitedElementsDateClnRub(@$str, 9999, 1, "", "", "status", (int)$_GET[year] . "." . $month . "." . "01", (int)$_GET[year] . "." . $month . "." . $day, "", "", true);
    } else {
        $days = $ilines->getLimitedElementsDateClnRubEn(@$str, 9999, 1, "", "", "status", (int)$_GET[year] . "." . $month . "." . "01", (int)$_GET[year] . "." . $month . "." . $day, "", "", true);
    }

    echo json_encode($days);

    function normJsonStr($str){
        $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
        return iconv('cp1251', 'utf-8', $str);
    }

