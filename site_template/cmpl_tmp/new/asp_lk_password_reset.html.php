<?php

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$aspModule = AspModule::getInstance();


if(!empty($_GET['code']) && !empty($_GET['email'])) {

    if($aspModule->getAspRegistrationService()->checkResetCode($_GET['email'],$_GET['code'])) {
        $aspModule->getAspPageBuilderManager()->setPageBuilder("passwordUpdate");
        $aspModule->getAspPageBuilder()->build();
    } else {
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
        echo "Запрос не найден";
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
    }
} else {
    if ($aspModule->getAspAuthorizationService()->checkLogin()) {
        $pages = new Pages();
        $personalPageId = $pages->getFirstPageIdByTemplate("asp_lk");
        if(!empty($personalPageId)) {
            Dreamedit::sendHeaderByCode(301);
            Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
            return;
        }
    } else {
        $aspModule->getAspPageBuilderManager()->setPageBuilder("passwordReset");
        $aspModule->getAspPageBuilder()->build();
    }
}