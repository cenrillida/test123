<?php

global $DB,$_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if(!empty($_GET['code'])) {
    $aspModule = AspModule::getInstance();
    $aspModule->getAspRegistrationService()->confirmRegister($_GET['code']);
} else {
    echo "Ошибка подтверждения email.";
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");