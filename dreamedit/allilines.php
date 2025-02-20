<?php



//АДреса страниц

include_once dirname(__FILE__)."/_include.php";

$pages = $DB->select("SELECT ae.el_id AS ARRAY_KEY, ae.el_id AS page_id, t.icont_text AS page_name, te.icont_text AS page_name_en FROM adm_ilines_element AS ae 
                      INNER JOIN adm_ilines_content AS t ON t.el_id=ae.el_id AND t.icont_var='title'
                      LEFT JOIN adm_ilines_content AS te ON te.el_id=ae.el_id AND te.icont_var='title_en'
                      WHERE ae.itype_id=6
                      ORDER BY ae.el_id");


//$pages = $DB->select("SELECT ae.el_id AS ARRAY_KEY, ae.el_id AS page_id, t.icont_text AS page_name, te.icont_text AS page_name_en FROM adm_ilines_element AS ae
//                      INNER JOIN adm_ilines_content AS t ON t.el_id=ae.el_id AND t.icont_var='title'
//                      INNER JOIN adm_ilines_content AS te ON te.el_id=ae.el_id AND te.icont_var='title_en'
//                      WHERE ae.itype_id=1 OR ae.itype_id=3 OR ae.itype_id=6 OR ae.itype_id=4 OR ae.itype_id=5
//                      ORDER BY ae.el_id");

$used = array();

echo "<table border='1' cellpadding='8'>";
foreach ($pages AS $page) {
    echo "<tr>";
    echo "<td>".$page["page_id"]."</td>";

    //echo "<td><a target='_blank' href='/dreamedit/index.php?mod=pages&action=edit&id=".$page["page_id"]."'>Открыть в админке</a></td>";
    //echo "<td><a target='_blank' href='/index.php?page_id=".$page["page_id"]."'>Открыть на сайте</a></td>";
    echo "<td".$textRed.">".$page["page_name"]."</td>";
    echo "<td>".$page["page_name_en"]."</td>";
    //echo "<td>".$page["page_urlname"]."</td>";
    //echo "<td>".$page["page_status"]."</td>";
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
    $latName = str_replace("---","-",$latName);
    $latName = mb_strtolower($latName);

//    while (true) {
//        if (in_array($latName, $used)) {
//            $latName .= "-" . $page['page_id'];
//        } else {
//            break;
//        }
//    }
//    $used[] = $latName;
    while (true) {
        $used = $DB->select("SELECT * FROM adm_ilines_content WHERE icont_var='iline_url' AND icont_text=?",$latName);

        if (!empty($used)) {
            $latName .= "-" . $page['page_id'];
        } else {
            break;
        }
    }

    echo $latName;
    echo "</td>";
    echo "</tr>";
    //$DB->query("INSERT INTO adm_ilines_content(el_id,icont_var,icont_text) VALUES(?,?,?)",$page['page_id'],"iline_url",$latName);
}
echo "</table>";