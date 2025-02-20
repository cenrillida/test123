<?php

global $DB,$_CONFIG, $site_templater;

$aspModule = AspModule::getInstance();
$aspModule->getAspPageBuilderManager()->setPageBuilder("register");
$aspModule->getAspPageBuilder()->build();