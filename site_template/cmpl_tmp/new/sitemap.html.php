<?php
// Send the headers
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
global $_CONFIG, $DB;

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php
    $pg = new Pages();
    if (!isset($_REQUEST[en]))
        $cc=$pg->getChildsMenu(2,1);
    else
        $cc=$pg->getChildsMenuEn(2,1);

    foreach($cc as $k=>$page)
    {
        if ($_SESSION[lang]=="/en") $page[page_name]=$page[page_name_en];
        echo "<url><loc>";
        echo "https://www.imemo.ru".$_SESSION[lang]."/index.php?page_id=".$page[page_id];
        echo "</loc></url>";

        if ($_SESSION[lang]!="/en") $bb=$pg->getChildsMenu($page[page_id],1);
        else $bb=$pg->getChildsMenuEn($page[page_id],1);
//print_r($bb);

        foreach($bb as $k2 => $level2)
        {
            if ($_SESSION[lang]=="/en") $level2[page_name]=$level2[page_name_en];
            if ($level2[page_template]!='news_full' && $level2[page_template]!='1publ_2011' && $level2[page_template]!='pers_full' &&
                $level2[page_template]!='grant_full' && $level2[page_template]!='search_persona' && $level2[page_template]!='smi_full') {
                echo "<url><loc>";
                echo "https://www.imemo.ru" . $_SESSION[lang] . "/index.php?page_id=" . $level2[page_id];
                echo "</loc></url>";
            }
            if ($_SESSION[lang]!="/en") $ee=$pg->getChildsMenu($level2[page_id],1);
            else $ee=$pg->getChildsMenuEn($level2[page_id],1);
            if (isset($ee))
            {
                foreach($ee as $k3=>$level3)
                {
                    if ($_SESSION[lang]=="/en") $level3[page_name]=$level3[page_name_en];
                    if ($level3[page_template]!='news_full' && $level3[page_template]!='1publ_2011' && $level3[page_template]!='pers_full' &&
                        $level3[page_template]!='grant_full' && $level3[page_template]!='search_persona' && $level3[page_template]!='smi_full') {
                        echo "<url><loc>";
                        if (substr($level3[page_template],0,8)=='magazine')
                            echo "https://www.imemo.ru".$_SESSION[lang]."/jour/".$level3[page_journame];
                        else
                            echo "https://www.imemo.ru" . $_SESSION[lang] . "/index.php?page_id=" . $level3[page_id];
                        echo "</loc></url>";
                    }
                }
            }
        }


        if ($_SESSION[lang]!='/en') $ee=$pg->getChildsMenu($page[page_id],1);
        else $ee=$pg->getChildsMenuEn($page[page_id],1);
    }
    ?>


    <url>

        <loc>https://www.imemo.ru/</loc>

    </url>
    <?php
    $ilines_spisok= $_TPL_REPLACMENT["ILINE_SPISOK"]; //"2,17,14,3,16";]
    $il0=explode(",",trim($ilines_spisok));
    $str="(";
    foreach($il0 as $il)
    {
        $str.=" ie.itype_id=".$il." OR ";
    }
    $str=substr($str,0,-4).")";
    $ilines = new Events();

    if ($_SESSION[lang]!='/en')
        $rows = $ilines->getLimitedElementsDateClnRub(@$str, 1000000, 1, "", "", "status","2007.01.01",date("Y").".12.31","", "");
    else
        $rows = $ilines->getLimitedElementsDateClnRubEn(@$str, 1000000, 1, "", "", "status","2007.01.01",date("Y").".12.31","", "");

    foreach ($rows as $k=>$v) {
        ?>
<url>
    <loc>https://www.imemo.ru/index.php?page_id=502&amp;id=<?=$k?>&amp;ret=498</loc>
</url>
    <?php
    }
    ?>


</urlset>