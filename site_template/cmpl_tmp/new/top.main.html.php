<?php
    global $_CONFIG, $DB, $site_templater, $page_content;
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");

if (empty($_SESSION[jour])) {
    $headers = new Headers();
    $elements = $headers->getHeaderElements("Главная - Новый сайт");
    $elements = $headers->appendContent($elements);
    ?>

    <main>
        <?php
        if (!empty($elements)) {
            foreach ($elements as $k => $v) {
                $tpl = new Templater();
                $tpl->setValues($v);
                $tpl->setValues($v['content']);
                $tpl->appendValues(array("HEADER_ID_EDIT" => $k));
                if ($v["ctype"] == "Фильтр")
                    $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers.html");
            }
        }
        ?>
    </main>
    <?php
}
if (!empty($_SESSION[jour]))
{
    if($_GET[debug]!=4) {
        //$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.main_jour.html");
    }
}
?>