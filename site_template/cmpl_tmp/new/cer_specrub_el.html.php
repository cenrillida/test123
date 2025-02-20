<?

global $DB,$_CONFIG, $site_templater;

$id = (int)$_GET[id];

if(!empty($id)) {

    $manager = new CerSpecrubManager();
    $element = $manager->getElementByID($id);

    $site_templater->appendValues(array("TITLE" => $element->getTitle()));
    $site_templater->appendValues(array("TITLE_EN" => $element->getTitleEn()));
    if($_GET[debug]==200) {
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text_100.html");
    } else {
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
    }
    Statistic::ajaxCounter("cerspecrub", $id);
    ?>
    <iframe src="https://www.imemo.ru<?=$_SESSION[lang]?>/iframe-retranslator/?id=<?=$id?>" frameborder="0" scrolling="no" style="border: 0px; width: 100%; height: 100%;">></iframe>

    <script>
        function iframeCheckHeightTimeout(block) {
            jQuery(block).height(jQuery(block).contents().find('html').height());
            setTimeout(function () {
                iframeCheckHeightTimeout(block);
            }, 700);
        }
        jQuery( document ).ready(function() {
            jQuery('iframe').on('load', function(){
                jQuery(this).height(jQuery(this).contents().outerHeight()+50);
                jQuery('iframe').contents().find('html').on("click", function(){jQuery('iframe').height(jQuery('iframe').contents().find('html').height());});
            });
            iframeCheckHeightTimeout("iframe");
        });
    </script>

    <?php

    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
} else {
    Dreamedit::sendHeaderByCode(404);
    exit;
}

?>