<?php

function isPathToRootExist($page_id, $pages) {

    if(!empty($pages[$page_id])) {
        if($pages[$page_id]['page_parent']!=0) {
            if($pages[$page_id]['page_parent'] == $page_id)
                return false;
            return isPathToRootExist($pages[$page_id]['page_parent'], $pages);
        } else {
            return true;
        }
    } else {
        return false;
    }

}

//АДреса страниц

include_once dirname(__FILE__)."/_include.php";

$pages = $DB->select("SELECT page_id AS ARRAY_KEY, adm_pages.* FROM adm_pages ORDER BY page_id");

echo "<table border='1' cellpadding='8'>";
foreach ($pages AS $page) {
    echo "<tr>";
    echo "<td>".$page["page_id"]."</td>";
    $textRed = "";
    if(!isPathToRootExist($page["page_id"],$pages)) {
        $textRed = " style='color: red;'";
    }

    echo "<td><a target='_blank' href='/dreamedit/index.php?mod=pages&action=edit&id=".$page["page_id"]."'>Открыть в админке</a></td>";
    echo "<td><a target='_blank' href='/index.php?page_id=".$page["page_id"]."'>Открыть на сайте</a></td>";
    echo "<td".$textRed.">".$page["page_name"]."</td>";
    echo "<td>".$page["page_name_en"]."</td>";
    echo "<td>".$page["page_urlname"]."</td>";
    echo "<td>".$page["page_status"]."</td>";
    echo "<td>";
    if(!empty($page["page_name_en"])) {
        $latName = Dreamedit::cyrToLat($page["page_name_en"]);
    } else {
        $latName = Dreamedit::cyrToLat($page["page_name"]);
    }
    $latName = preg_replace("/[^a-zA-Z-\d ]/","",$latName);
    $latName = preg_replace("/ +/"," ",$latName);

    $latName = ltrim(rtrim($latName));
    $latName = str_replace(" ","-",$latName);
    $latName = mb_strtolower($latName);


    if(!empty($latName) && $page['page_status']==1
        && $page['page_template']!='0'
        && $page['page_template']!='index'
        && $page['page_template']!='pm_programm_speaker'
        && $page['page_template']!='pm_programm_day_element'
        && substr($page['page_template'],0,8)!='magazine'
        && $page['page_template']!='pm_programm_files') {
        echo $latName;
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>";