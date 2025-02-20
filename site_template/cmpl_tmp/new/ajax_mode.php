<?php
global $_CONFIG, $site_templater;

if(!empty($_GET['ajax_expert_opinion'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_expert_opinion");
}
if(!empty($_GET['ajax_president_smi'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_president_smi");
}
if(!empty($_GET['ajax_president_news'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_president_news");
}
if(!empty($_GET['ajax_president_publs'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_president_publs");
}
if(!empty($_GET['ajax_smi_full'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_smi_full");
}
if(!empty($_GET['ajax_smi_about_full'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_smi_about_full");
}
if(!empty($_GET['ajax_videogallery'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_videogallery");
}
if(!empty($_GET['ajax_specrubs'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_specrubs");
}
if(!empty($_GET['ajax_cernews'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_cernews");
}
if(!empty($_GET['ajax_cer_expert_opinions'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_cer_expert_opinions");
}
if(!empty($_GET['ajax_cerconferences'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_cerconferences");
}
if(!empty($_GET['ajax_cerpubls'])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_cerpubls");
}