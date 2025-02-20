<?php
    ini_set('memory_limit', '512M');
    include_once dirname(__FILE__)."/_include.php";
    header("Content-type: application/json");
    $elmnts = array();
    $pg = new Article();
    if(!empty($_GET[selected]))
        $parents = $pg->getParents($_GET[selected]);
    $rows = $pg->getChilds(0);
    $count=0;
    $parentsCount = $DB->select("SELECT page_parent AS ARRAY_KEY, COUNT(page_id) as cnt FROM adm_article GROUP BY page_parent");
    $elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=articls&action=edit&id={ID}";
    foreach($rows as $k => $v) {
        $elmnts[$count][id] = $k;
        if ($v[page_template]=='jnumber')
            $elmnts[$count][text] = normJsonStr($v['j_name']."-".$v["year"]."-".$v["page_name"]);
        else
            $elmnts[$count][text] = normJsonStr($v['page_name']);
        if($parentsCount[$v[page_id]][cnt]>0)
            $elmnts[$count][children] = true;
        $elmnts[$count][icon]="skin/classic/images/dTree/page.gif";
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
            if($v[id]==$par_k)
                $elmnts[$k][state][opened] = true;
        }
    }






    echo json_encode($elmnts);

    function normJsonStr($str){
        $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
        return iconv('cp1251', 'utf-8', $str);
    }
?>