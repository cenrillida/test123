<?php



//АДреса страниц

include_once dirname(__FILE__)."/_include.php";

$pages = $DB->select("SELECT id AS ARRAY_KEY, publ.* FROM publ 
                      ORDER BY id");


//$pages = $DB->select("SELECT ae.el_id AS ARRAY_KEY, ae.el_id AS page_id, t.icont_text AS page_name, te.icont_text AS page_name_en FROM adm_ilines_element AS ae
//                      INNER JOIN adm_ilines_content AS t ON t.el_id=ae.el_id AND t.icont_var='title'
//                      INNER JOIN adm_ilines_content AS te ON te.el_id=ae.el_id AND te.icont_var='title_en'
//                      WHERE ae.itype_id=1 OR ae.itype_id=3 OR ae.itype_id=6 OR ae.itype_id=4 OR ae.itype_id=5
//                      ORDER BY ae.el_id");

$used = array();

echo "<table border='1' cellpadding='8'>";
foreach ($pages AS $page) {
    echo "<tr>";
    echo "<td>".$page["id"]."</td>";

    //echo "<td><a target='_blank' href='/dreamedit/index.php?mod=pages&action=edit&id=".$page["page_id"]."'>Открыть в админке</a></td>";
    //echo "<td><a target='_blank' href='/index.php?page_id=".$page["page_id"]."'>Открыть на сайте</a></td>";
    echo "<td".$textRed.">".$page["name"]."</td>";
    echo "<td>".$page["name2"]."</td>";
    //echo "<td>".$page["page_urlname"]."</td>";
    //echo "<td>".$page["page_status"]."</td>";
    echo "<td>";
    if (!empty($page['name_title'])) {
        $latName = Dreamedit::cyrToLat($page['name_title']);
    } elseif(!empty($page['name2'])) {
        $latName = Dreamedit::cyrToLat($page['name2']);
    } else {
        $latName = Dreamedit::cyrToLat($page['name']);
    }
    $latName = preg_replace("/[^a-zA-Z-\d ]/","",$latName);
    $latName = preg_replace("/ +/"," ",$latName);

    $latName = ltrim(rtrim($latName));
    $latName = str_replace(" ","-",$latName);
    $latName = str_replace("---","-",$latName);
    $latName = mb_strtolower($latName);

    if(empty($latName)) {
        $latName = "publ";
    }

    while (true) {
        $used = $DB->select("SELECT * FROM publ WHERE uri=?",$latName);

        $sameId = false;
        foreach ($used as $value) {
            if($value[id] == $page['id']) {
                $sameId = true;
            }
        }
        if (!empty($used) && !$sameId) {
            $latName .= "-" . $page['id'];
        } else {
            break;
        }
    }

    echo $latName;
    echo "</td>";
    echo "</tr>";
    //$DB->query("UPDATE publ SET uri=? WHERE id=?d",$latName,$page["id"]);
}
echo "</table>";